<?php

namespace App\Http\Controllers;

use App\Services\Purifier;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
    	return view('form');
    }

    public function submit(Request $request)
    {
    	$purifier = new Purifier();
	    $body = $purifier->clean($request->body);
    	return json_encode([
    		'data' => [
    			'title' => $request->title,
		        'body' => $body,
		    ],
	        'success' => true,
	        'status' => 200
	    ]);
    }
}
