<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->windTit = "HOME";
    }

    public function index(){
        return view('Home.main')->with(['windTit' => $this->windTit]);
    }
}
