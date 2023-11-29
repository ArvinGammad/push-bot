<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplatesSetting;

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
        return view('templates.index');
    }
}
