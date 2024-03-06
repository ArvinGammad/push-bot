<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Articles;
use App\Models\Wordpress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ArticleController extends Controller
{
    protected $pexelsApiKey;
    protected $client;

    public function index(){
        $articles = Articles::select('*')->where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->limit(6)->get();
        return view('articles.index',compact('articles'));
    }

    public function deleteArticle(Request $request){
        try {

            $article = Articles::select('*')->where('user_id',auth()->user()->id)->where('id',$request->article_id)->get()->first();
            $article->delete();
            return response()->json(['success' => 'success'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editor($id){
        $article = Articles::select('*')->where('user_id',auth()->user()->id)->where('id',$id)->get()->first();
        $wordpress = Wordpress::select('*')->where('user_id',auth()->user()->id)->get();


        if(!isset($article->id)){
            return back();
        }

        return view('articles.editor',compact('article','wordpress'));
    }

    public function editorCreate(){
         try {
            $article = Articles::create([
                'user_id'=>auth()->user()->id,
                'title'=> 'Untitled',
                'description'=> '',
                'content'=> '',
                'status'=> 'completed',
                'type'=> 'scratch'
            ]);

            return response()->json(['success' => 'success','id' => $article->id], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editorSave(Request $request){
        try {

            $article = Articles::select('*')->where('user_id',auth()->user()->id)->where('id',$request->id)->get()->first();

            $article->title = $request->article_title;
            $article->description = $request->article_description;
            $article->content = $request->article_content;
            $article->update();

            return response()->json(['success' => 'success'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editorCompose(Request $request){
        try {

            $content = $request->article_content;
            if($content != ""){
                $content = $request->article_title . "\n" . $request->article_description;
            }

            $endpoint = 'https://aiwriter.brainpod.ai/api/v1';
            $auth_bearer = 'awDEU8qzHlawLFK2AuV0hafz1dnm1dilKWXhXN6q';

            $post_data = [
                'task' => 'compose',
                'length' => 64,
                'context' => $content
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $auth_bearer,
                'Content-Type: application/json'
            ]);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

            $response = curl_exec($ch);

            if ($response === false) {
                return response()->json(['error' => 'Unable to generate content, Please Try again!'], 500);
            } else {
                $response = json_decode($response, true);
                return response()->json([
                    'success' => 'success', 
                    'generated' => $response['generated_text']
                ], 200);
            }

            curl_close($ch);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function articleKeywords(){
        return view('articles.keywords');
    }

    public function createArticleKeywords(Request $request){
        set_time_limit(0);
        try {

            $keywords = $request->keywords;
            $content = '';
            foreach($keywords as $key => $keyword){
                $content .= $keyword;
                if(isset($keywords[$key+1])) $content .= ', ';
            }

            $data = array(
                "task" => "template",
                "template_id" => 32,
                "inputs" => json_encode(array(
                    "description" => $content,
                    "keyword" => $content,
                    "tone" => "professional"
                ))
            );

            $response = $this->compose($data);
            $response = json_decode($response, true);
            $generated = $response['generated_text'];
            $titles = explode("\n", $generated);
            $heading = '';
            foreach ($titles as $key => $title) {
                $title_text = str_replace('\"', '', $title);
                $title_text = str_replace('"', '', $title_text);
                $title_text = str_replace('1. ', '', $title_text);
                if($title_text != ' ' && $title_text != null){
                    $heading = $title_text;
                    break;
                }
            }

            $data = array(
                "task" => "template",
                "template_id" => 9,
                "inputs" => json_encode(array(
                    "title" => $heading,
                    "audience" => "",
                    "tone" => "professional"
                ))
            );

            $response = $this->compose($data);
            $response = json_decode($response, true);

            $intro = $response['generated_text'];


            $data = array(
                "task" => "template",
                "template_id" => 10,
                "inputs" => json_encode(array(
                    "content" => $intro,
                    "action" => "",
                    "tone" => "professional"
                ))
            );

            $response = $this->compose($data);
            $response = json_decode($response, true);

            $conclusion = $response['generated_text'];

            $data = array(
                "task" => "template",
                "template_id" => 13,
                "inputs" => json_encode(array(
                    "text" => $intro,
                    "tone" => "professional"
                ))
            );

            $response = $this->compose($data);
            $response = json_decode($response, true);

            $expand1 = $response['generated_text'];

            // $params = array(
            //     'title'=>$heading,
            //     'url'=>'http://2rtx3090-4rtx3090ti.tplinkdns.com:81/generate',
            //     'outline'=>"",
            //     'generate_image'=>false,
            // );

            // $response == http::timeout(0)->post('http://45.56.72.56:5001/brainpod/v3/blog',$params);

            $content = "<h3>".$heading."</h3><br><br>".$intro."<br><br>".$expand1."<br><br>".$conclusion;

            $article = Articles::create([
                'user_id'=>auth()->user()->id,
                'title'=> $heading,
                'description'=> $intro,
                'content'=> $content,
                'status'=> 'completed',
                'type'=> 'keywords'
            ]);

            return response()->json([
                'success' => 'success',
                'article_id' => $article->id,
                'generated' => $content
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => "Can't Generate Content, Please Contact Admin!"], 500);
        }
    }

    public function articleTitle(){

    }

    public function searchPexelsImages(Request $request){
        try {

            $query = $request->search_input;

            $this->pexelsApiKey = env('PEXELS_API_KEY');
            $this->client = new Client([
                'base_uri' => 'https://api.pexels.com/',
                'headers' => [
                    'Authorization' => $this->pexelsApiKey,
                ],
            ]);

            $response = $this->client->request('GET', 'v1/search', [
                'query' => [
                    'query' => $query,
                    'per_page' => 20,
                ]
            ]);

            $photos_result = json_decode($response->getBody()->getContents(), true)['photos'] ?? [];

            return response()->json([
                'success' => 'success', 
                'generated' => $photos_result
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function compose($data){
        $endpoint = "https://aiwriter.brainpod.ai/api/v1";
        $api_key = "awDEU8qzHlawLFK2AuV0hafz1dnm1dilKWXhXN6q"; // Replace with your own API key

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $api_key,
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
