<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Articles;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
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


        if(!isset($article->id)){
            return back();
        }

        return view('articles.editor',compact('article'));
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
                    "description" => "AI Writer",
                    "keyword" => "AI Writer",
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
                if($title_text != ' ' && $title_text != null){
                    $heading = $title_text;
                    break;
                }
            }


            return response()->json([
                'success' => 'success',
                'generated' => $heading
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => "Can't Generate Content, Please Contact Admin!"], 500);
        }
    }

    public function articleTitle(){

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
