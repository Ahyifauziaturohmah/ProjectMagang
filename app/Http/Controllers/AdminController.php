<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index (){
        echo "yuhu min";
    }
    function mentor (){
        return view('mentordash');
    }
    function magang (){
        return view('magangdash');
    }
}
