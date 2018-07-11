<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ApiForgotController extends Controller
{

    public function ResetForm(Request $request, $token)
	{

		$tokencheck = DB::table('password_resets')->where('token',$token)->where('email',$request->get('email'))->first();

		if($tokencheck){
			return view('email.reset',['token'=>$token,'email'=>$request->get('email')]);
		}else{
			return redirect('/');
		}
	}
}
