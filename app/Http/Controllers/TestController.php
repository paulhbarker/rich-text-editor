<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
    	return view('form');
    }

    public function submit(Request $request)
    {
    	return $request->all();
    }
}
