<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use DB;

class ForgotpassController extends Controller
{
    //
    public function sendpasswordtoken(Request $request)
	{
		$request->validate([
    		'token' 	 => 'required',
    		'email' 	 => 'required|email|max:255'
    	]);
		$user = User::where('email', $request->email);

	    if(!$user){
	    	return response()->json(['success' => false, 'message' => 'not a valid email'],404);
	    }
	    DB::table('password_resets')->insert([
	        'email' 	 => $request->email,
	        'token' 	 => str_random(60),
	        'created_at' => Carbon::now()
	    ]);

	    $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
	    $token 	   = $tokenData->token;
	    $email 	   = $request->email;
	    return response()->json(['success' => true, 'message' =>'new token created'], 200);
	}
}
	     
