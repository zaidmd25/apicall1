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
	    $token 	   = $tokenData->token;
	    $email 	   = $request->email;

	    // echo json_encode($email);exit;
	    return response()->json(['success' => true, 'message' =>'new token created'], 200);

	}

	public function resetpassword(Request $request,$token)
	{

		$val= $request->validate([
			'email' 	 => 'required|email|max:255',
	        'token' 	 => 'required',
	        'new_password'	 => 'required'
		]);
		echo "";print_r($val);exit;

	    $password  = $request->password;
	    $tokenData = DB::table('password_resets')->where('token', $token)->first();

	    $user = User::where('email', $tokenData['email'])->first();
	    // echo "";print_r($user);exit;
	    if (!$user){
	    	return response()->json(['success' => false, 'message' => 'error'],404);
	    }
	     $user->password = Hash::make($password);
	     $user->update();

	     // return response()->json(['success' => true,'message'=>'password updated successfully']);
	}
}

	// if ( $validator->passes() ) {

	// 		$reset = ResetKey::where('key', $input['key'])->first();
	// 		$user = User::where('email', $input['email'])->first();
	// 		if ( !($reset instanceof ResetKey) )
	// 			return ApiResponse::errorUnauthorized("Invalid reset key.");
	// 		if ( $reset->user_id != $user->_id )
	// 			return ApiResponse::errorUnauthorized("Reset key does not belong to this user.");
	// 		if ( $reset->isExpired() ) {
	// 			$reset->delete();
	// 			return ApiResponse::errorUnauthorized("Reset key is expired.");
	// 		}
	// 		$user = $reset->user;
	// 		$user->password = Hash::make($input['password']);
	// 		$user->save();
	// 		$reset->delete();
	// 		return ApiResponse::json('Password reset successfully!');
	// 	}
	// 	else {
	// 		return ApiResponse::validation($validator);
	// 	}
	     
