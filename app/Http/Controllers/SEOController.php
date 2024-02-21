<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\SeoKeyword;
use App\Models\SeoCrawlData;

class SEOController extends Controller
{
	protected $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	public function getSEOUrl(Request $request){

		$i=0;

		$urls_array = array();
		$urls_host = array();

		$seo_crawl_data = SeoKeyword::create([
			'user_id'=>Auth::user()->id,
			'keywords'=>$request->keywords,
			'status'=>"0"
		]);

		$keywords = json_decode($request->keywords);
		$keywords = implode(', ', $keywords);

		try {

			$urls = $this->crawlURLS($keywords);
			foreach ($urls as $value) {
				if($i >= 15){
					$url = str_replace('/url?q=', '', $value['url']);

					// Remove query string
					$url_parts = parse_url($url);
					if (isset($url_parts['scheme'], $url_parts['host'], $url_parts['path'])) {
							$clean_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];

							if(strpos($url_parts['host'], 'google.com') === false) {
								if(!in_array($url_parts['host'], $urls_host)){
									array_push($urls_host,$url_parts['host']);

									SeoCrawlData::create([
										"seo_id"=>$seo_crawl_data->id,
										"url"=>$clean_url,
										"content"=>"",
										"nlp"=>"",
										"terms"=>"",
										"headings"=>"",
										"titles"=>"",
										"paragraphs"=>"",
										"words"=>"",
										"images"=>"",
										"status"=>"0",
									]);
								}
							}
					}
				}
				$i++;
			}

			return response()->json(['success' => 'success'], 200);

		} catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}

		
	}

	public function crawlURLS($keyword)
	{
		$url = "https://www.google.com/search?q=" . urlencode($keyword);

		$response = $this->client->request('GET', $url);
		$html = (string) $response->getBody();

		$crawler = new Crawler($html);

		$results_url = $crawler->filter('body a')->each(function (Crawler $node, $i) {

		    $url = $node->filter('a')->last()->attr('href');
		    $position = $i + 1;

		    return compact('url', 'position');
		});

		return $results_url;
	}

	public function crawlData($url)
	{

		// Request the URL
		$response = $this->client->request('GET', $url);
		$html = (string)$response->getBody();

		// Create a new Symfony DomCrawler instance
		$crawler = new Crawler($html);

		// Extract paragraphs
		$paragraphs = $crawler->filter('p')->each(function ($node) {
			return $node->text();
		});

		$paragraphs_uniqueArray = $this->removeArrayDuplicates($paragraphs);
		$paragraphs_uniqueArray = $this->removeShortArrays($paragraphs_uniqueArray);

		$contents = $crawler->filter('body div')->each(function ($node) {
			return $node->text();
		});

		$contents_uniqueArray = $this->removeArrayDuplicates($contents);

		$combine_contents = implode(' ', $contents_uniqueArray);
		$combine_contents = $this->separateWords($combine_contents);

		// Extract headings
		$headings = $crawler->filter('h1, h2, h3')->each(function ($node) {
			return $node->text();
		});

		$headings_uniqueArray = $this->removeArrayDuplicates($headings);
		$headings_uniqueArray = $this->removeShortArrays($headings_uniqueArray);

		$titles = $crawler->filter('h1')->each(function ($node) {
			return $node->text();
		});

		$titles_uniqueArray = $this->removeArrayDuplicates($titles);

		// Extract images
		$images = $crawler->filter('img')->each(function ($node) {
			return $node->attr('src');
		});

		$images_uniqueArray = $this->removeArrayDuplicates($images);

		// NLP
		$tokens = tokenize($combine_contents);
		$normalizedTokens = normalize_tokens($tokens);
		$normalizedTokens = $this->removeArrayIndex($normalizedTokens, 1);
		$rake = rake($normalizedTokens, 3);
		$results = $rake->getKeywordScores();


		// TERMS
		$freqDist = freq_dist(tokenize($combine_contents));
		$result_token = $freqDist->getKeyValuesByFrequency();
		$result_token = $this->removeArrayIndexUsingKey($result_token, 3);

		

		// Extract other elements as needed
		// echo "<pre>";
		// print_r($results);
		// echo "</pre>";

		return [
			'paragraphs' => $paragraphs_uniqueArray,
			'contents' => $combine_contents,
			'headings' => $headings_uniqueArray,
			'titles' => $titles_uniqueArray,
			'images' => $images_uniqueArray,
			'nlp' => $results,
			'terms' => $result_token,
		];
	}

	function removeArrayIndex($content_array,$number_of_characters){
		foreach ($content_array as $key => $value) {
			if (strlen($value) <= $number_of_characters) {
				unset($content_array[$key]);
			}
		}

		return $content_array;
	}

	function removeArrayIndexUsingKey($content_array,$number_of_characters){
		foreach ($content_array as $key => $value) {
			if (strlen($key) <= $number_of_characters) {
				unset($content_array[$key]);
			}
		}

		return $content_array;
	}

	function removeArrayDuplicates($input){
		$uniqueArray = array_unique($input);
		$uniqueArray = array_values($uniqueArray);

		return $uniqueArray;
	}

	function removeShortArrays($array) {
	// Filter out elements with less than three words
		$filteredArray = array_filter($array, function($item) {
			$words = str_word_count($item, 0); // Count words in the string
			return $words >= 4; // Keep elements with three or more words
		});

		return $filteredArray;
	}

	function separateWords($input) {
		// Use regular expression to split compound words based on capitalization
		preg_match_all('/([A-Z][a-z]*)|([a-z]+)/', $input, $matches);

		// Combine matches to form separate words
		$words = implode(' ', $matches[0]);

		return $words;
	}
}
