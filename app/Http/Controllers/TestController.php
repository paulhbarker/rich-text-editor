<?php

namespace App\Http\Controllers;

use App\Mail\DebugMail;
use App\Services\Purifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function upload(Request $request) {

    	$file = $request->file('file');

    	try
	    {
		    $path = Storage::putFileAs('/', $file, $file->getClientOriginalName());

	    } catch (\Exception $e)
	    {
		    return json_encode([
			    'uploaded' => 0,
			    'error' => [
				    'message' => $e->getMessage()
			    ],
		    ]);
	    }

	    return json_encode([
		    'uploaded' => 1,
            'fileName' => $file->getClientOriginalName(),
            'url' => Storage::url($file->getClientOriginalName())
	    ]);
    }
}
