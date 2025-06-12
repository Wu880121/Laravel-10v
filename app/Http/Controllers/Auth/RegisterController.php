<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
{
    $data = $request->validated();

    $user = User::create([
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'firstname' => $data['firstname'] ?? null,
        'lastname' => $data['lastname'] ?? null,
        'sex' => $data['sex'] ?? null,
        'country' => $data['country'] ?? null,
        'birthdate' => $data['birthdate'] ?? null,
        'tel' => $data['tel'] ?? null,
        'address' => $data['address'] ?? null,
    ]);
	 
	
	if(!$user)
	{
		return response()->json(['message'=>'註冊失敗'],401);
	}
	
	
	$token = JWTAuth::attempt([
		'email'=>$data['email'],
		'password'=>$data['password'],
	]);
	
	if(!$token)
	{
		return response()->json(['message'=>'登入失敗'],401);
	}
	
			try
		{
			$user->sendEmailVerificationNotification();
		}catch(\Throwable $e)
		{
			\Log::error('Email 驗證信寄送失敗：' . $e->getMessage());
		}
	
		

    return response()->json([
        'status' => true,
        'message' => '註冊成功，並且登入',
        'user' => $user->only(['id', 'email', 'firstname', 'lastname']),
    ])->cookie
	(
		 'token',                // cookie 名稱
        $token,                // 寫入 JWT token
        60,                    // 分鐘數（有效時間）
        '/', '.keepgoingpiggy.com',                     // 路徑
        null,                  // 網域（跨網域再設定）
        true,                  // Secure（建議上線環境用）
        true,                  // HttpOnly（最重要！JS 讀不到）
        false,                 // raw
        'Strict'               // SameSite（防 CSRF）
	);
	
}

}
