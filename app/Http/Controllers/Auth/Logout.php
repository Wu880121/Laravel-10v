<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;


class Logout extends Controller
{
    public function logout(Request $request)
	{
		
		try{
		
		$token = $request->cookie('token');
		
		if(!$token){
			
			return response()->json([
			
				'status' => false,
				"code" =>401,
				"message" => "查無此Token",
			],400);
		}
		
			JWTAuth::setToken($token)->invalidate();
			
			$cookie = Cookie::forget('token');
			
			return response()->json([
			
				'status' => true,
				'code' =>200 ,
				'message' => "登出成功",
				'success_type' => "logout_success",
			],200);
		
	}catch(\Exception $e){
		
		//\Log::error($e->getMessage());
		return  response()->json([
			
			'status' =>false,
			'code' =>500,
			'message' =>$e->getMessage(),
		],500);
		
	}
 }
}
