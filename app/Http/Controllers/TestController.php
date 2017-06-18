<?php

namespace App\Http\Controllers;

use App\Mail\DebugMail;
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

    public function mail(Request $request)
    {
    	\Mail::to(env('EMAIL'))->send(new DebugMail($request->before, $request->after));
    }

    public function html() {
    	return view('html');
    }
}
