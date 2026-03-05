<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    /*
    public function entrepreneursPre(){
        return view('pages/prerequisite_entrepreneurs');
    }


    public function investorPre(){
        return view('pages/prerequisite_investor');
    }*/
	
	
	public function loans(){
    	return view('loans');
    }

    public function about(){
    	return view('pages/about');
    }
	
	public function terms(){
        return view('pages/terms');
    }

    public function privacy(){
        return view('pages/privacy');
    }

    public function media(){
        return view('pages.media');
    }

    public function faq(){
        return view('pages.faq');
    }

}
