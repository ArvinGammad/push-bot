<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ImageEditorController extends Controller
{
    public function imageEditor(){
        return view('image.editor');
    }
}
