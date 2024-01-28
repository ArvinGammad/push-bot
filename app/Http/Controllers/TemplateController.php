<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplatesSetting;
use App\Models\Template;

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

        return view('templates.editor', compact('template_inputs','template'));
    }
}
