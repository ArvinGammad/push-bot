<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Articles;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(){
        return view('articles.index');
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
            
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
