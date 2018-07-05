<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\User;

class ApiController extends Controller
{
    //
    public function signup(Request $request){

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
}
