<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\User;

class SigninController extends Controller
{
    //

    public function signin(Request $request){

    	$request->validate([
    		'email' 	 => 'required|email|max:255',
    		'password' 	 => 'required',
    		'remember_me'=> 'boolean'

    	]);
    	$credentials = $request->only(['email', 'password']);

    	if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token'  => $tokenResult->accessToken,
            'token_type' 	=> 'Bearer',
            'expires_at' 	=> Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }
}
