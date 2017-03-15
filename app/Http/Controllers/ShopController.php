<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;

class ShopController extends Controller
{
	// the normal shop page with no filters etc
    public function index() {
    	
    	// get all popular products from DB
    	$allProducts = Product::all();
    	// Show the page
    	return view('shop', compact('allProducts'));

    }
}
