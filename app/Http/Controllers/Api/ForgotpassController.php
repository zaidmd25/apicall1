<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use DB;

class ForgotpassController extends Controller
{

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
	    $myquery   = DB::table('password_resets')->select('token')->get();
          echo "";print_r($myquery);exit;
	    return response()->json(['success' => true, 'message' =>'new token created'], 200);
	}

	public function resetpassword(Request $request)
	{
		$request->validate([
			'email' 	 	  	    => 'required|email|max:255',
    		'token' 	 	   		=> 'required',
			'password'     			=> 'required',
			'password_confirmation' => 'required|same:password'
    	]);
    	
		 $token = DB::table('password_resets')->where('token',$request->get('token'))->where('email',$request->get('email'))->first();
		 if(!$token){
		 	return response()->json(['success' => false, 'message' => 'not a valid email/token'],404);
		 }
    	$data = $request->all();
 
		$user = User::where('email',$request->get('email'))->first();
		if($user){
	        $user->password = \Hash::make($request->get('password'));
	        $user->save();
	        $token = DB::table('password_resets')->where('token',$request->get('token'))->where('email',$request->get('email'))->delete();
	        return response()->json(['success' => true, 'message' => 'password updated'],200);
		}
	}

	public function SentResetLink(Request $request)
	{

		$request->validate([
			'email'			=> 'required|email|max:255'
		]);
		$user = User::where('email', $request->email)->first();
		if ($user)
		{
			DB::table('password_resets')->insert([
				'email' 	 => $request->get('email'),
				'token' 	 => str_random(60),
				'created_at' => Carbon::now()
			]);
		    $tokenData = DB::table('password_resets')->where('email',$request->get('email'))->first();
		    $token 	   = $tokenData->token;
		    $email 	   = $request->get('email');
    	}
    		$user = User::where('email',$request->get('email'))->first();
			\Mail::send('email.reminder',['token'=>$token,'email'=>$request->get('email')] ,function ($m) use($user) {
				$m->to($user->email)->subject('Your Reminder!');
			});
	}

	public function ResetForm(Request $request, $token)
	{

		$tokencheck = DB::table('password_resets')->where('token',$token)->where('email',$request->get('email'))->first();

		if($tokencheck){

			return view('email.reset',['token'=>$token,'email'=>$request->get('email')]);
		}else{

			return view('/home');
		}
	}
}