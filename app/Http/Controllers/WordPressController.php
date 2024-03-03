<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\Wordpress;

class WordPressController extends Controller
{
	public function index(){
		$wordpress = Wordpress::where('user_id',Auth::user()->id)->get();

		foreach ($wordpress as $key => $value) {

			$request_uri = rtrim($value->url,'/') . '/wp-json/wp/v2/settings';
			$response = Http::withBasicAuth($value->username, $value->password)->get($request_uri);

			$siteName = '';
			$logoUrl = '';
			if ($response->getStatusCode() === 200) {
				$data = json_decode($response->getBody(), true);

				$siteName = @$data['title'];
				$logoUrl = @$data['site_logo'];
			}

			$value->site_title = $siteName;
			$value->site_logo = $logoUrl;
		}

		return view('wordpress.index', compact('wordpress'));
	}

	public function connectPage(){
		return view('wordpress.wp-connect');
	}

	public function wpSave(Request $request){

		$url = $request->wp_url;
		$username = $request->wp_username;
		$password = $request->wp_password;

		try {

			$request_uri = rtrim($url,'/') . '/wp-json/wp/v2/users/me';

			$response = Http::withBasicAuth($username, $password)->get($request_uri);

			if ($response->successful()) {
				Wordpress::create([
					'user_id'=>Auth::user()->id,
					'url'=>$url,
					'username'=>$username,
					'password'=>$password
				]);
				return response()->json(['success' => 'success'], 200);
			} else {
				return response()->json(['error' => 'Oops, We could not connect to your wordpress site. Please check your credentials'], 500);
			}

		} catch (RequestException $e) {
				// Handle request exceptions, e.g., connection error, authentication failure, etc.
				return response()->json(['error' => $e->getMessage()], 500);
		}
	}
}
