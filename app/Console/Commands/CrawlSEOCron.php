<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;

use App\Models\SeoKeyword;
use App\Models\SeoCrawlData;

class CrawlSEOCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:crawl';

    protected $client;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl URLs for SEO Data';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {        

        $seo = SeoKeyword::where('status',"1")->get()->first();
        if ($seo === null) $seo = SeoKeyword::where('status',"0")->get()->first();

        if ($seo !== null){
            $seo_url = SeoCrawlData::where('status','1')->where('seo_id',$seo->id)->get()->first();
            if($seo_url === null) $seo_url = SeoCrawlData::where('status','0')->where('seo_id',$seo->id)->get()->first();

            if($seo_url !== null){
                $seo_url->status = "1";
                $seo_url->update();

                $crawled_data = $this->crawlData($seo_url->url);

                if(isset($crawled_data['error'])){
                    $seo_url->status = "3";
                    $seo_url->update();

                    return Command::SUCCESS;
                }

                $seo_url->content =  $crawled_data['contents'];
                $seo_url->nlp =  $crawled_data['nlp'];
                $seo_url->terms =  $crawled_data['terms'];
                $seo_url->headings =  $crawled_data['headings'];
                $seo_url->titles =  $crawled_data['titles'];
                $seo_url->paragraphs =  $crawled_data['paragraphs'];
                $seo_url->words =  str_word_count($crawled_data['contents']);
                $seo_url->images =  count($crawled_data['images']);

                $seo_url->status = "2";
                $seo_url->update();

                $seo_url = SeoCrawlData::where('status','0')->where('seo_id',$seo->id)->get()->first();

                $seo_url->status = "1";
                $seo_url->update();

                $seo->status = "1";
                $seo->update();
            }else{
                $seo->status = "2";
                $seo->update();
            }  
        }

        return Command::SUCCESS;
    }

    function crawlData($url)
    {

        $this->client = new Client();

        try {
            $array_url = explode("&",$url);
            $response = $this->client->request('GET', $array_url[0]);

            $statusCode = $response->getStatusCode();

            if ($statusCode == 403) {
                // Handle the 403 Forbidden error
                return ['error' => 1];
            }

            $html = (string)$response->getBody();
            $crawler = new Crawler($html);
        } catch (RequestException $e) {
            return [
                'error'=>1
            ];
        }

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

        if($combine_contents == ''){
            return [
                'error'=>1
            ];
        }

        $tokens = tokenize($combine_contents);
        $normalizedTokens = normalize_tokens($tokens);
        $normalizedTokens = $this->removeArrayIndex($normalizedTokens, 1);
        $rake = rake($normalizedTokens, 3);
        $results = $rake->getKeywordScores();


        // TERMS
        $freqDist = freq_dist(tokenize($combine_contents));
        $result_token = $freqDist->getKeyValuesByFrequency();
        $result_token = $this->removeArrayIndexUsingKey($result_token, 3);

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
