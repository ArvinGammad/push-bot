<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TemplatesSetting;
use App\Models\Template;
use App\Models\AiOutput;

class TemplateController extends Controller
{
    public function index(){

    }

    public function templateInputs(){
        return view('admin.templates.template-create');
    }

    public function adminTemplates(){
        return view('admin.templates.template-list');
    }

    public function adminTemplateGet(){
        $templates = TemplatesSetting::get();

        return ['data'=>$templates];
    }

    public function getAllTemplate(){
        $templates = Template::get();
        return view('templates.index',compact('templates'));
    }

    public function templateEditor($slug){
        $template = Template::where('slug',$slug)->get()->first();

        $template_inputs = json_decode($template->input_fields);

        return view('templates.editor', compact('template_inputs','template',));
    }

    public function templateEditorHistory(Request $request){
        $template_history = AiOutput::where('ai_id',$request->template_id)->where('type','template')->get();
        return ['data'=>$template_history];
    }

    public function adminTemplateGenerate(Request $request){
        $slug = $request->slug;



        switch ($slug) {
            case 'aida_framework':
                $curl_data = array(
                    "task" => "template",
                    "template_id" => 3,
                    "inputs" => json_encode(array(
                        "company" => $request->company,
                        "description" => $request->description,
                        "tone" => $request->tone
                    ))
                );

                break;
            default:
                break;
        }

        try {

            $response = $this->compose($curl_data);

            $response = json_decode($response, true);
            $generated_text = $response['generated_text'];
            $token = $response['token'];

            $ai_output = AiOutput::create([
                'user_id'=>Auth::user()->id,
                'input'=>json_encode($curl_data),
                'output'=>$generated_text,
                'type'=>'template',
                'charge'=> computTokenCharge($token),
            ]);

            return response()->json([
                'success' => 'success',
                'response' => $generated_text
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => "Can't Generate Content, Please Contact Admin!"], 500);
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
