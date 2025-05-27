<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Auth\AuthRequest;

class AuthController extends Controller
{
    public function login(AuthRequest $request){
		
		$data = $request->validated();
		
		$credential=[
			'email' => $data['email'],
			'password' => $data['password'],
		];
		
		$rememberme = isset($data['rememberme']) && $data['rememberme']==1;
		
		if($rememberme){
			
			JWTAuth::factory()->setTTL(60*24*2);
			
		}else{
			
			JWTAuth::factory()->setTTL(60*2);
		}
		
		$token=JWTAuth::attempt($credential);
		
		if(!$token){
			
			return response()->json(['message' => '帳號或是密碼錯誤'],401);
		}
		
		$user = auth()->user();
		
		//if(!$user->hasVerifiedEmail()){
			
			//return response()->json(['message' => '還沒驗證email，請先驗證完成'],403);
	//	}
		
		return response()->json([
			'message' => '登入成功!',
			'user' => $user->only(['id', 'role' , 'firstname' , 'lastname' ]),
		])->cookie(
               'token',                // cookie 名稱
               $token,                // 寫入 JWT token
               $rememberme?60*24*2:60*2,                    // 分鐘數（有效時間）
               '/',                   // 路徑
               null,                  // 網域（跨網域再設定）
               true,                  // Secure（建議上線環境用）
               true,                  // HttpOnly（最重要！JS 讀不到）
               false,                 // raw
               'Strict'               // SameSite（防 CSRF）
		);
	}
}
