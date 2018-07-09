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
    		'email' 	 	   => 'required|email|max:255',
    		'token' 	 	   => 'required'
    	]);
		$user = User::where('email',$request->get('email'))->first();

	    if(!$user){
	    	return response()->json(['success' => false, 'message' => 'not a valid email'],404);
	    }
	    DB::table('password_resets')->insert([
	        'email' 	 => $request->get('email'),
	        'token' 	 => str_random(60),
	        'created_at' => Carbon::now()
	    ]);
	    $tokenData = DB::table('password_resets')->where('email',$request->get('email'))->first();
	    $token 	   = $tokenData->token;
	    $email 	   = $request->get('email');
	    $myquery = DB::table('password_resets')->select('token')->get();
          echo "";print_r($myquery);
	    return response()->json(['success' => true, 'message' =>'new token created'], 200);
		// if(!\Hash::check($data['old_password'], $user->password)){
		// 	return response()->json(['success' => false, 'message' => 'the password doesnt match'],404);
		// }
		// else{
		// 	$user = User::find($user['id']);
	 //        $user['password'] = \Hash::make($request->get('new_password'));
	 //        $user->save();
	 //            return response()->json(['success' => true, 'message' => 'password updated'],200);
		// 	// DB::table('oauth_access_tokens')->where('email', $user->email)->delete();
		// }
	}

	public function resetpassword(Request $request)
	{
		$request->validate([
			'email' 	 	   => 'required|email|max:255',
    		'token' 	 	   => 'required',
			'old_password' 	   => 'required',
			'new_password'     => 'required',
			'confirm_password' => 'required|same:new_password'
    	]);
    	// $user = User::where('email',$request->get('email'))->first();
    	
		 $token = DB::table('password_resets')->where('token',$request->get('token'))->where('email',$request->get('email'))->first();
		 if(!$token){
		 	return response()->json(['success' => false, 'message' => 'not a valid email/token'],404);
		 }
    	$data = $request->all();
 
		$user = User::where('email',$request->get('email'))->first();
		if(!\Hash::check($data['old_password'], $user->password)){
			return response()->json(['success' => false, 'message' => 'the password doesnt match'],404);
		}else{
	        $user->password = \Hash::make($request->get('new_password'));
	        $user->save();
	        $token->delete();
	        return response()->json(['success' => true, 'message' => 'password updated'],200);
		}
	}
}