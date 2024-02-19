<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class SEOController extends Controller
{
	protected $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	public function test(){
		$urls = $this->crawl('Amazing Water Bottle');

		$i=0;

		$urls_array = array();
		$urls_host = array();
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
								array_push($urls_array,$clean_url);
							}
						}
				}
				
			}
			$i++;
		}
	}

	public function crawl($keyword)
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
