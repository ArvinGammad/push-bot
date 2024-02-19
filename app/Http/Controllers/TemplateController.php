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

    public function getTemplateInputs(Request $request){
        

        try {
            $template = Template::where('id',$request->template_id)->get()->first();
            $template_inputs = json_decode($template->input_fields);

            return response()->json([
                'success' => 'success',
                'inputs' => $template_inputs,
                'template' =>  $template]
            , 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function templateEditorHistory(Request $request){
        $template = Template::where('slug',$request->slug)->get()->first();
        $template_history = AiOutput::where('ai_id',$template->id)->where('type','template')->orderBy("created_at",'DESC')->get();
        return ['data'=>$template_history];
    }

    public function adminTemplateGenerate(Request $request){
        $slug = $request->slug;
        $template = Template::where('slug',$request->slug)->get()->first();

         try {
            switch ($slug) {
                case 'aida_framework':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 3,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;
                case 'pas_framework':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 4,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;
                case 'content_improver':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 5,
                        'inputs' => json_encode(array(
                            'content'=>$request->content,
                            'tone'=>$request->tone
                        ))
                    );
                    break;
                case 'product_description':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 6,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;
                case 'blog_post_topic_ideas':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 7,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'audience'=>$request->audience,
                            'tone'=>$request->tone
                        ))
                    );
                    break;
                case 'blog_post_outline':
                    $curl_data = array(
                    'task' => 'template',
                    'template_id' => 8,
                    'inputs' => json_encode(array(
                    'topic'=>$request->topic,
                    'tone'=>$request->tone
                    ))
                    );
                    break;
                case 'blog_post_intro_paragraph':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 9,
                        'inputs' => json_encode(array(
                            'title'=>$request->title,
                            'audience'=>$request->audience,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'blog_post_conclusion_paragraph':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 10,
                        'inputs' => json_encode(array(
                            'content'=>$request->content,
                            'action'=>$request->action,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'creative_story':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 11,
                        'inputs' => json_encode(array(
                            'plot'=>$request->plot,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'explain_it_to_a_child':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 12,
                        'inputs' => json_encode(array(
                            'text'=>$request->text,
                            'grade'=>$request->grade,
                        ))
                    );
                    break;

                case 'sentence_expander':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 13,
                        'inputs' => json_encode(array(
                            'text'=>$request->text,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'facebook_ads_headline':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 14,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'facebook_ads_primary_text':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 15,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'google_ads_headline':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 16,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'google_ads_description':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 17,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'google_my_business_whats_new_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 18,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'company'=>$request->company,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'google_my_business_event_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 19,
                        'inputs' => json_encode(array(
                            'event'=>$request->event,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'google_my_business_product_description':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 20,
                        'inputs' => json_encode(array(
                            'product'=>$request->product,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'ridiculous_marketing_ideas':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 21,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'google_my_business_offer_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 22,
                        'inputs' => json_encode(array(
                            'offer'=>$request->offer,
                            'company'=>$request->company,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'amazon_product_features_bullets':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 23,
                        'inputs' => json_encode(array(
                            'product'=>$request->product,
                            'description'=>$request->description,
                            'benefits'=>$request->benefits,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'amazon_product_description_paragraph':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 24,
                        'inputs' => json_encode(array(
                            'product'=>$request->product,
                            'benefits'=>$request->benefits,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'perfect_headline':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 25,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'company'=>$request->company,
                            'avatar'=>$request->avatar,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'website_sub_headline':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 26,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'headline'=>$request->headline,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'photo_post_captions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 27,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'marketing_angles':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 28,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'persuasive_bullet_points':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 29,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'video_topic_ideas':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 30,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'video_script_outline':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 31,
                        'inputs' => json_encode(array(
                            'title'=>$request->title,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'video_titles':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 32,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'video_script_hook_and_introduction':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 33,
                        'inputs' => json_encode(array(
                            'title'=>$request->title,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'video_description_youtube':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 34,
                        'inputs' => json_encode(array(
                            'title'=>$request->title,
                            'keyword'=>$request->keyword,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'review_responder':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 35,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'customer'=>$request->customer,
                            'rating'=>$request->rating,
                            'tone'=>$request->tone,
                            'review'=>$request->review,
                        ))
                    );
                    break;

                case 'personalized_cold_emails':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 36,
                        'inputs' => json_encode(array(
                            'product'=>$request->product,
                            'company'=>$request->company,
                            'context'=>$request->context,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'email_subject_lines':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 37,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'tone'=>$request->tone,
                            'description'=>$request->description,
                        ))
                    );
                    break;

                case 'seo_blog_posts_title_and_meta_descriptions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 38,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'title'=>$request->title,
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                        ))
                    );
                    break;

                case 'seo_homepage_title_and_meta_descriptions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 39,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                        ))
                    );
                    break;

                case 'seo_product_page_title_and_meta_descriptions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 40,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'product'=>$request->product,
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                        ))
                    );
                    break;

                case 'seo_services_pages_title_and_meta_descriptions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 41,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                        ))
                    );
                    break;

                case 'company_bio':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 42,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'personal_bio':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 43,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'tone'=>$request->tone,
                            'view'=>$request->view,
                        ))
                    );
                    break;

                case 'feature_to_benefit':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 44,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'before_after_bridge_framework':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 45,
                        'inputs' => json_encode(array(
                            'company'=>$request->company,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'unique_value_propositions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 46,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'real_estate_listing_residential':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 47,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                        ))
                    );
                    break;

                case 'pinterest_pin_title_description':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 48,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'keyword'=>$request->keyword,
                            'company'=>$request->company,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'press_release_title_intro':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 49,
                        'inputs' => json_encode(array(
                            'description'=>$request->description,
                            'company'=>$request->company,
                            'keyword'=>$request->keyword,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'engaging_questions':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 50,
                        'inputs' => json_encode(array(
                            'topic'=>$request->topic,
                            'audience'=>$request->audience,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'quora_answers':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 51,
                        'inputs' => json_encode(array(
                            'question'=>$request->question,
                            'description'=>$request->description,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'text_summarizer':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 52,
                        'inputs' => json_encode(array(
                            'text'=>$request->text,
                        ))
                    );
                    break;

                case 'business_or_product_name':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 53,
                        'inputs' => json_encode(array(
                            'product'=>$request->product,
                            'keyword'=>$request->keyword,
                        ))
                    );
                    break;

                case 'poll_questions_multiple_choice_answers':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 54,
                        'inputs' => json_encode(array(
                            'topic'=>$request->topic,
                            'audience'=>$request->audience,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'facebook_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 55,
                        'inputs' => json_encode(array(
                            'about'=>$request->about,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'twitter_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 56,
                        'inputs' => json_encode(array(
                            'about'=>$request->about,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'linkedin_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 57,
                        'inputs' => json_encode(array(
                            'about'=>$request->about,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'instagram_post':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 58,
                        'inputs' => json_encode(array(
                            'about'=>$request->about,
                            'tone'=>$request->tone
                        ))
                    );
                    break;

                case 'cover_letter':
                    $curl_data = array(
                        'task' => 'template',
                        'template_id' => 59,
                        'inputs' => json_encode(array(
                            'position'=>$request->position,
                            'name'=>$request->name,
                            'bio'=>$request->bio
                        ))
                    );
                    break;
            }

       

            $response = $this->compose($curl_data);

            $response = json_decode($response, true);
            $generated_text = $response['generated_text'];
            $token = $response['token'];

            $ai_output = AiOutput::create([
                'ai_id'=>$template->id,
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

    public function templateGetGenerated($generated_id){
        try {
            $template_history = AiOutput::where('user_id',Auth::user()->id)->where('id',$generated_id)->get()->first();

            $template_inputs = json_decode($template_history->input);
            $template_user_inputs = json_decode($template_inputs->inputs);

            return response()->json([
                'success' => 'success',
                'input' => $template_user_inputs,
                'output' =>  $template_history->output]
            , 200);

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
