<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
	
    public function login(AuthRequest $request){
		
		
		try{
		$data = $request->validated();
		
		$userData = User::where('email',$data['email'])->first();
		
		$login_attempts = $userData->login_attempts;
		
		$locked_until = Carbon::parse($userData->locked_until);
		
		if(!empty($locked_until) && $locked_until>now()){
			
			$remaining = $locked_until->diffInSeconds(now());
			$minutes = floor($remaining/60);
			$seconds = $remaining%60;
			
			return response()->json([
				
				'status' =>false,
				'code' =>401,
				'message' => "還剩下".$minutes."分".$seconds."秒",
				'error_type' => 'still_locked',
			],401);
		}
		
		if(!empty($locked_until) &&$locked_until<now()){
			
		$userData->locked_until=null;
        $userData->login_attempts=0;
        $userData->save();
		}
	
		
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
			
			
			$login_attempts++;
			$userData->login_attempts = $login_attempts; 
			$userData->save();
			
			if($login_attempts<5){
				
				return response()->json([
				
				'status' =>false,
				'code' =>401,
				'message' => "還剩下". 5-$login_attempts."次機會",
				'error_type' => 'remaining_attempts',
				],401);
			}
			
			if($login_attempts>=5){
				
				$locked_until = now()->addMinutes(15);
				$remaining = $locked_until->diffInSeconds(now());
				$minutes = floor($remaining/60);
				$seconds = $remaining%60;
				
				$userData->locked_until =$locked_until;
				$userData->save();
				
				return response()->json([
				
				'status' =>false,
				'code' =>401,
				'message' => "請".$minutes."分".$seconds."秒後再嘗試",
				'error_type' => 'locked_attempts',
				],401);
			}
		}
		
		$userData->locked_until=null;
        $userData->login_attempts=0;
        $userData->save();
		
		$user = auth()->user();
		
		//if(!$user->hasVerifiedEmail()){
			
			//return response()->json(['message' => '還沒驗證email，請先驗證完成'],403);
	//	}
		
		return response()->json([
			'code' =>200,
			'message' => '登入成功!',
			'user' => $user->only(['id', 'role' , 'firstname' , 'lastname' ]),
		])->cookie(
               'token',                // cookie 名稱
               $token,                // 寫入 JWT token
               $rememberme?60*24*2:60*2,                    // 分鐘數（有效時間）
               '/', '.keepgoingpiggy.com',                  // 路徑
               null,                  // 網域（跨網域再設定）
               false,                  // Secure（建議上線環境用）
               true,                  // HttpOnly（最重要！JS 讀不到）
               false,                 // raw
               'Strict'               // SameSite（防 CSRF）
		);
	
	}catch(\Throwable $e){
		
		\Log::error($e->getMessage());
		
	}
  }
}
