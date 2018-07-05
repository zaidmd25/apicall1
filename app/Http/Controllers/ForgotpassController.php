<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Carbon\Carbon;

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
	    // echo "string";print_r($val);exit;

	    $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
	    $token = $tokenData->token;
	    $email = $request->email;

	    // echo json_encode($email);exit;
	    return response()->json(['success' => true, 'message' =>'new token created'], 200);

	}

	public function resetpassword(Request $request)
	{
		// $token;
		$request->validate([
			'password'   =>'required'
		]);

	    $password  = $request->password;
	    $tokenData = DB::table('password_resets')->where('token', $token)->first();

	    $user = User::where('email', $tokenData->email)->first();
	    if ( !$user ){
	    	return response()->json(['success' => false, 'message' => 'error'],404);
	    }
	     $user->password = Hash::make($password);
	     $user->update();
	     
	}
}