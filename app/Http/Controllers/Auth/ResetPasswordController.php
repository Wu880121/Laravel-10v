<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth;
use App\Models\User;
use App\Models\Auth\Password_reset_tokens;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\sendResetPasswordRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{
    public function sendResetLinkEmail(sendResetPasswordRequest $request)
	{
		 $data = $request -> validated();
		 
		 $user = User::where('email', $data['email'])->first();
		 
		 if (!$user)
			{
				return response()->json
				([
						'status' =>false,
						'message' => "查無此email，請輸入與註冊時一樣的email",
						'code' =>404,
				],404);
			}
			
			$record = DB::table('password_reset_tokens')
			             ->where('email', $data['email'])
						 ->where('created_at','>=', Carbon::now()->subMinutes(20))
						 ->first();
				
				if($record)
				{
						 
                  $createdAt = Carbon::parse($record->created_at);  //類似srttotime()
                  $expireAt = $createdAt->addMinutes(20); // 加20後的時間點
                  $remainingSeconds = Carbon::now()->diffInSeconds($expireAt, false);  //false等於可以是負數
                  
                  if ($remainingSeconds > 0) {
                      $minutes = floor($remainingSeconds / 60);
                      $seconds = $remainingSeconds % 60;
                  
                      return response()->json([
                          'status' => false,
                          'message' => "{$minutes}分{$seconds}秒後可嘗試重新寄信",
                          'code' => 429,
                      ],429);
                  }

				}
				
			
			try{
				
			$status = Password::sendResetLink(['email' => $data['email']]);
			
			
			if($status==Password::RESET_LINK_SENT)
			 {
				return response()->json([
					
					'status' =>true,
					'message' => "信件已經送出囉，請去收送",
					'code' =>200,
				],200);
			 }
			}catch(\Exception $e){
			
			if($status!==Password::RESET_LINK_SENT)
			{
					return response()->json([
					'status' => false,
					'message' => "寄信失敗",
					'code' =>400,
				],400);
			}
			  }
	}
	
	public function reset(ResetPasswordRequest $request)
	{
		$data = $request->validated();
		
		$record = DB::table('password_reset_tokens')->where('email', $data['email'])->first();
		
		 if (!$record || Hash::check($data['token'], $request->token)) {
        return response()->json([
            'status' => false,
            'code' => 404,
			'error_type' =>"NoFoundToken",
            'message' => '此 token 無效或已過期'
        ],404);
    }
		
		 $user = DB::table('users')->where('email', $data['email'])->first();
		 
		 if(!$user){
              return response()->json([
                  'status' => false,
                  'code' => 404,
				  'error_type' =>"NoFoundUser",
                  'message' => '查無此email',
              ],404);
		 }
		 
		if(Hash::check($data['password'],  $user->password))
		{
			return response()->json([
            'status' => false,
            'code' => 403,
			'error_type' => 'password_same',
            'message' => '不可與舊的密碼一樣'
        ],403);
		}
		
		$createdAt = Carbon::parse($record->created_at);
		$diffInMinutes = Carbon::now()->diffInMinutes($createdAt, false);
		
		if($diffInMinutes>20)
		{
			return response()->json([
				'status' =>false,
				'message' =>"更改期限已到期，請重新寄信",
				'code' =>403,
			],403);
		}
		
		$check = 
		[
			'email' => $data['email'],
			'token' => $data['token'],
			'password' => $data['password'],
			'password_confirmation' => $data['password_confirmation'],  //reset方法會自動去對password_confirmation
																											  //但一定要取password_confirmation
		];
		
		$status = Password::reset($check, function($user, $password){
			
			$user->forceFill([
				'password' => Hash::make($password),
			])->save();
			
		});
		
		if($status == Password::PASSWORD_RESET)
		{
			return response()->json
			([
				'status' =>true,
				'message' => "更改成功",
				'code' => 200,
			],200);
		}		
		
		
		if(!$status !== Password::PASSWORD_RESET)
		   {
			return response()->json
			([
				'status' =>false,
				'message' => "更改失敗，請重新嘗試",
				'code' => 400,
			],400);
		    }
	}
}
