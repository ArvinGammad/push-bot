<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\Wordpress;
use App\Models\Articles;

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

	public function editPage($id){
		$wordpress = Wordpress::where('user_id',Auth::user()->id)->where('id',$id)->get()->first();

		if(!$wordpress){
			return redirect('/wp/list');
		}

		return view('wordpress.wp-edit',compact('wordpress'));
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

	public function wpUpdate(Request $request){

		$url = $request->wp_url;
		$username = $request->wp_username;
		$password = $request->wp_password;

		try {

			$request_uri = rtrim($url,'/') . '/wp-json/wp/v2/users/me';

			$response = Http::withBasicAuth($username, $password)->get($request_uri);

			if ($response->successful()) {
				$wp = Wordpress::where('user_id',Auth::user()->id)->where('id',$request->wp_id)->get()->first();

				$wp->url = $url;
				$wp->username = $username;
				$wp->password = $password;

				$wp->update();

				return response()->json(['success' => 'success'], 200);
			} else {
				return response()->json(['error' => 'Oops, We could not connect to your wordpress site. Please check your credentials'], 500);
			}

		} catch (RequestException $e) {
				// Handle request exceptions, e.g., connection error, authentication failure, etc.
				return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function wpDelete(Request $request){
		try {

			$wp = Wordpress::where('user_id',Auth::user()->id)->where('id',$request->wp_id)->get()->first();
			$wp->delete();
			return response()->json(['success' => 'success'], 200);
			
		} catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function getWPDetails(Request $request){
		try {

			$wp = Wordpress::where('user_id',Auth::user()->id)->where('id',$request->wp_id)->get()->first();

			$url = $wp->url;
			$username = $wp->username;
			$password = $wp->password;

			$categories = $this->wpCategories($url, $username, $password);
			$tags = $this->wpTags($url, $username, $password);
			return response()->json([
				'success' => 'success',
				'categories'=>$categories,
				'tags'=>$tags,
			], 200);
			
		} catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function wpPost(Request $request){
		try {

			$tags = '';
			$categories = '';

			$wordpress = Wordpress::where('user_id',Auth::user()->id)->where('id', $request->wp_id)->get()->first();
			$article = Articles::where('user_id',Auth::user()->id)->where('id', $request->input('article-id'))->get()->first();

			$post_data = array(
				'json' => [
					'title' => $article->title,
					'content' => $article->content,
					'status' => $request->wp_status
				]
			);
			if(!is_null($request->wp_categories)){
				$categories = explode(',',implode(',',$request->wp_categories));

				$post_data['json']['categories'] = $categories;
			}

			if(!is_null($request->wp_tags)){
				$tags = explode(',',implode(',',$request->wp_tags));

				$post_data['json']['tags'] = $tags;
			}

			$url = $wordpress->url;
			$username = $wordpress->username;
			$password = $wordpress->password;

			$request_uri = rtrim($url, '/') . '/wp-json/wp/v2/posts';

			$response = Http::withBasicAuth($username, $password)->post($request_uri, $post_data['json']);

			if ($response->successful()) {
				return response()->json(['success' => 'success'], 200);
			} else {
				return response()->json(['error' => 'Oops, We could not connect to your wordpress site. Please check your credentials'], 500);
			}
			
		} catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	function wpCategories($url, $username, $password){
		$request_uri = rtrim($url,'/') . '/wp-json/wp/v2/categories';
		$response = Http::withBasicAuth($username, $password)->get($request_uri);
		return json_decode($response->getBody(), true);
	}

	function wpTags($url, $username, $password){
		$request_uri = rtrim($url,'/') . '/wp-json/wp/v2/tags';
		$response = Http::withBasicAuth($username, $password)->get($request_uri);
		return json_decode($response->getBody(), true);
	}
}
