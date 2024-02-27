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

	public function getSEOData(Request $request){
		$seoData = SeoKeyword::where('user_id',Auth::user()->id)->orderby('created_at','DESC')->get();
		return response()->json([
			'success' => 'success',
			'data' => $seoData
		], 200);
	}

	public function getSEOCrawledData(Request $request){
		try {
			$seoData = SeoKeyword::where('user_id',Auth::user()->id)->where('id',$request->seo_id)->get()->first();

			$urlDataCurrent = null;
			$urlsDataSuccessCount = 0;
			$urlsDataCount = 0;
			$urlsDataFailCount = 0;

			$number_of_words = 0;
			$number_of_paragraphs = 0;
			$number_of_images = 0;
			$number_of_headings = 0;
			$recommended_headings = array();
			$terms = array();
			$nlp_data = array();
			$titles = array();
			$urls = array();

			if($seoData->status == '1'){
				$urlDataCurrent = SeoCrawlData::where('seo_id',$request->seo_id)->where('status','1')->get()->first();
				$urlsDataSuccessCount = SeoCrawlData::where('seo_id',$request->seo_id)->where('status','2')->get()->count();
				$urlsDataFailCount = SeoCrawlData::where('seo_id',$request->seo_id)->where('status','3')->get()->count();
				$urlsDataCount = SeoCrawlData::where('seo_id',$request->seo_id)->get()->count();
			}else if($seoData->status == '2'){
				$seo_crawl_data =  SeoCrawlData::where('seo_id',$request->seo_id)->where('status','2')->get();

				
				foreach ($seo_crawl_data as $key => $seo) {

					$url_arr = explode("&",$seo->url);
					array_push($urls, $url_arr[0]);


					if (!is_array($seo->paragraphs)) $paragraphs_arr = json_decode($seo->paragraphs, true);
					else $paragraphs_arr = $seo->paragraphs;

					if (!is_array($seo->headings)) $headings_arr = json_decode($seo->headings, true);
					else $headings_arr = $seo->headings;

					if (!is_array($seo->titles)) $titles_arr = json_decode($seo->titles, true);
					else $titles_arr = $seo->titles;

					if (!is_array($seo->terms)) $terms_arr = json_decode($seo->terms, true);
					else $terms_arr = $seo->terms;

					if (!is_array($seo->nlp)) $nlp_arr = json_decode($seo->nlp, true);
					else $nlp_arr = $seo->nlp;

					if (!is_array($seo->titles)) $titles_arr = json_decode($seo->titles, true);
					else $titles_arr = $seo->titles;

					if($seo->words >= $number_of_words) $number_of_words = (int)$seo->words;
					if(count($paragraphs_arr) >= $number_of_paragraphs) $number_of_paragraphs = count($paragraphs_arr);
					if((int)$seo->images >= $number_of_images) $number_of_images = (int)$seo->images;
					if(count($headings_arr) >= $number_of_headings) $number_of_headings = count($headings_arr);

					foreach($headings_arr as $heading){
						foreach (json_decode($seoData->keywords) as $keyword) {
							if (strpos($heading, $keyword) !== false) {
								if(!in_array($heading, $recommended_headings)) array_push($recommended_headings, $heading);
							}
						}
					}

					foreach($titles_arr as $title){
						if(!in_array($title, $titles)) array_push($titles, $title);
					}

					foreach($terms_arr as $term_key => $term){
						if($term >= 100){
							array_push($terms, $term_key);
						}
					}
					foreach($nlp_arr as $nlp_key => $nlp){
						if($nlp >= 15){
							array_push($nlp_data, $nlp_key);
						}
					}
				}
			}
			
			return response()->json([
				'success' => 'success',
				'data' => $seoData,
				'url_data_current' => $urlDataCurrent,
				'url_data_count' => $urlsDataCount,
				'number_of_words'=>$number_of_words,
				'number_of_paragraphs'=>$number_of_paragraphs,
				'number_of_images'=>$number_of_images,
				'number_of_headings'=>$number_of_headings,
				'urls_crawled_success' => $urlsDataSuccessCount+$urlsDataFailCount,
				'recommended_headings' => $recommended_headings,
				'seo_terms' => $terms,
				'seo_nlp' => $nlp_data,
				'seo_titles' => $titles,
				'seo_urls' => $urls,
			], 200);
		} catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function checkSEOCrawledData(Request $request){
		try {
			$seoData = SeoKeyword::where('user_id',Auth::user()->id)->where('id',$request->seo_id)->get()->first();

			$urlDataCurrent = null;
			$urlsDataSuccessCount = 0;
			$urlsDataCount = 0;
			$urlsDataFailCount = 0;

			if($seoData->status != '0'){
				$urlDataCurrent = SeoCrawlData::where('seo_id',$request->seo_id)->where('status','1')->get()->first();
				$urlsDataSuccessCount = SeoCrawlData::where('seo_id',$request->seo_id)->where('status','2')->get()->count();
				$urlsDataFailCount = SeoCrawlData::where('seo_id',$request->seo_id)->where('status','3')->get()->count();
				$urlsDataCount = SeoCrawlData::where('seo_id',$request->seo_id)->get()->count();
			}
			
			return response()->json([
				'success' => 'success',
				'data' => $seoData,
				'url_data_current' => $urlDataCurrent,
				'url_data_count' => $urlsDataCount,
				'urls_crawled_success' => $urlsDataSuccessCount+$urlsDataFailCount
			], 200);

		} catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
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
}
