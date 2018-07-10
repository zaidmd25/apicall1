<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Carbon\carbon;
use App\User;
use Auth;

class ApiController extends Controller
{

    public function signup(Request $request)
    {
       	$validator = Validator::make($request->all(),[ 
            'firstname' 		=> 'required',
            'surname' 			=> 'required',
            'dob' 				=> 'required',
            'email' 			=> 'required|email|max:255|unique:users,email',
            'address' 			=> 'required',
            // 'additional_address_information' => '',
            'postcode' 			=> 'required',
            'town' 				=> 'required',
            'country' 			=> 'required',
            'currency' 			=> 'required',
            'telephone' 		=> 'required',
            'username' 			=> 'required|max:255|unique:users,username',
            'password' 			=> 'required',
            'security_question' => 'required',
            // 'referal_username' => ''
            // 'promotional_code' => '',
        ]);
       	if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' =>$validator->getMessageBag()->toArray()], 400);
        }
	        $data = $request->only(['firstname','surname','dob','email','address','additional_address_information','postcode','town','country','currency','telephone','username','password','security_question','referal_username','promotional_code']);
	        $data['password'] = \Hash::make($data['password']);
	        $val = User::create($data);
        if($val) {
     	   return response()->json(['success' => true, 'message' =>'created successfully'], 200);
    	}else{
    		return response()->json(['success' => false, 'message' => 'Error in creating data'],404);
    	}
    }
    public function signin(Request $request)
    {
        $request->validate([
            'email'      => 'required|email|max:255',
            'password'   => 'required',
            'remember_me'=> 'boolean'
        ]);
        $credentials = $request->only(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Token');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token'  => $tokenResult->accessToken,
            'token_type'    => 'Bearer',
            'expires_at'    => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }
}
