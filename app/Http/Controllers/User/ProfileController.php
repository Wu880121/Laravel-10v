<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\ProfileRequest;
use App\Http\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function profile(Request $request){
		
	try{
		$user = auth()->user();
		
		if($user){
		
		return response()->json([
				
				'status' =>true,
				'code' =>200,
				"message" =>"成功取得資料",
				'success_type' => "success_get_user",
				'user' => new UserResource($user),
		],200);
		
	  }else{
		  
		  return response()->json([
				
				'status' =>false,
				'code' => 401,
				'message' =>"查無此用戶",
				'error_type'=>'profile_not_found_user',
		  ],401);
		  
	   }
	 }catch(\Exception $e){
		 
			\Log::error("發生錯誤".$e->getMessage());
	 }
	}
	
	
	public function updateProfile(ProfileRequest $request){
		
	try{   
			
				
		     $data = $request->validated();
			   
			$user = auth()->user();
			
			if(empty($user->email_verified_at)){
				
				return response()->json([
			
				'status' =>false,
				'code' =>403,
				"error_type" =>"not_verification_email",
				"message" =>"請先完成email驗證!",
				
			],403);	
			}
			
			if ($request->hasFile('picture')) {
			if ($request->file('picture') && $user->picture !== '/storage/user_photos/default.png') {
              Storage::delete(str_replace('/storage/', 'public/', $user->picture));   //這邊會換成public是因為真正的資料在storage\app\public\user_photos
            }
		}
			
			if($request->file('picture')){
				
				 $file = $request->file('picture');
				
				$extension =  $file->getClientOriginalExtension();
				
				$filename = Str::uuid() . "." . $extension; // 自訂唯一名稱：uuid.jpg
				
				$path = $file->storeAs('/public/user_photos', $filename); // 儲存在 storage/app/public/user_photos/uuid.jpg
				
				$urlApth = Storage::url($path); // => /storage/user_photos/uuid.jpg
			}
		
		$user->update([
		
			'email' => $data['email'],
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'country' => $data['country'],
			'birthdate' => $data['birthdate'],
			'tel' => $data['tel'],
			'address' => $data['address'],
			'picture' => $urlApth ?? $user->picture,
			'sex' => $data['sex'],
		
		]);
		
		if(!$user){
			
			return response()->json([
			
				'status' =>false,
				'code' =>400,
				"error_type" =>"updat_failed",
				"message" =>"更新失敗，請重新嘗試",
			]);	
		
		}else{
				
				$user->save();
				return response()->json([
			
				'status' =>true,
				'code' =>200,
				"success_type" =>"updat_success",
				"message" =>"更新成功!",
				
			],200);	
			
		}
		
		
		
	  }catch(\Exception $e){
		  
			\Log::error("錯誤訊息".$e->getMessage());
			
				return response()->json([
			
				'status' =>false,
				'code' =>500,
				"error_type" =>"updat_errors",
				"message" =>"發生錯誤",
			],500);
			
	  }
	}
}
