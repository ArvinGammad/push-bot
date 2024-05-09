<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(){
        return view('admin.packages.index');
    }

    public function createPage(){
        return view('admin.packages.create');
    }
}
