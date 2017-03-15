<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
        public function index() {
    	// get all popular products from DB

    	// Show the page
    	return view('home');

    }
}
