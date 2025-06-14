<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ResendRegisterVerificationEmailRequest as ResendRequest;


class ResendRegisterVerificationEmailController extends Controller
{
    public function resendVerification(ResendRequest $request)
	{
			
			
			$user = auth()->user();
			
			if(!$user)
			   {
				   return response()->json([
						
						'status'=>false,
						'code' =>401,
						'message'=>'請先登入',
				   ],401);
			   }
			
			if($user->hasVerifiedEmail())
			{
				return response()->json
				([
					'status' =>false,
					'message' => '已經驗證過',
					'code' =>400,
				],400);
			}
			
			if($user->verification_sent_at)
			{
				$seconedsPassed = now()->diffInSeconds($user->verification_sent_at);
				$cooldown = 600; //10分鐘
				
				if($seconedsPassed<$cooldown)
				{
					$remaining = $cooldown - $seconedsPassed;
					$minutes = floor($remaining/60);
					$seconds = $remaining%60;
					
					return response()->json([
						'status' =>false,
						'code' =>429,
						'message' => "還剩下{$minutes}分{$seconds}秒，請稍後再嘗試",
					],429);
				}
				
			}
			
			try
			{
				

             $user->sendEmailVerificationNotification();
             //\Log::info('寄信成功');

			$user->verification_sent_at = now();
			$user->save();
			return response()->json([
				'status' =>true,
				'message'=>"寄信成功",
			],200);
			
			}catch(\Exception $e)
			 {
				 
			\Log::error('驗證信寄送失敗：' . $e->getMessage());
			
			return response()->json([
			
				'status' => true,
				'code' =>500,
				'message' =>'寄信時發生錯誤',
				'errors'=> $e->getMessage()
			],500);
			 }
	}
}
