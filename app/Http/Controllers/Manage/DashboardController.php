<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index (Request $request){
		
		try{
			

		$per_page = $request->input('per_page', 10); 
			
		$users = User::select('id', 'lastname' , 'firstname' , 'sex', 'picture')
				->orderby('id', 'asc')  //desc是倒序
				->paginate($per_page);
				
				return response()-> json($users);
				
		}catch (\Throwable $e) {
			
			\Log::error($e->getMessage());
        return response()->json([
            'message' => 'Server error',
            'error' => $e->getMessage(),
        ], 500);
    }
  }
  
  public function profile(Request $requset){
	  
	  try{
		  
			$id = $requset->input('id');
			
			$user = User::findOrFail($id);
			
			return response()->json([
				
				'status'=>true,
				'code' =>200,
				'message' =>"成功",
				'success_type'=>"success_find",
				'user' =>$user,
			]);
			
	  }catch(\Throwable $e){
		  
		  \Log::error($e->getMessage());
		  console.log($e->getMessage);
		  
		  	return response()->json([
				
			'status' => false,
			'code' =>500,
			'message' =>"發生錯誤",
		]);
			}
	  }
	  
	  public function profileUpdate(ProfileRequest $request ,$id){
		  	  
		  try{
		  $data = $request->validated();
		  $user = User::findOrFail($id);
		  
		        if ($request->hasFile('picture')) {
               $file = $request->file('picture');
               $extension = $file->getClientOriginalExtension();
               $fileName = Str::uuid() . "." . $extension;
               $path = $file->storeAs('public/user_photos', $fileName);
               $urlPath = Storage::url($path);
           } else {
               $urlPath = $user->picture; // ✅ 沒上傳新圖就保留原圖
           }           
		  
		  $success= $user->update([
         	'email' => $data['email'],
			'firstname' => $data['firstname'],
			'lastname' => $data['lastname'],
			'country' => $data['country'],
			'birthdate' => $data['birthdate'],
			'tel' => $data['tel'],
			'address' => $data['address'],
			'picture' => $urlPath ?? $user->picture,
			'sex' => $data['sex'],
		  
		  ]);
		  
		  if(!$success){
			  
			  return response()->json([
				
				'status'=>false,
				'code'=>400,
				'message'=>"更新失敗",
				'error_type' => "update_error",
			  ]);
		  }
		  
		  
		  return response()->json([
				'status'=>true,
				'code'=>200,
				'message'=>"更新成功",
				'success_type' => "update_success",
				'user'=>$user,
		  ]);
		  
		  }catch(\Throwable $e){
			  
			  \Log::error($e->getMessage());
			  return response()->json([
			  
				'status'=>false,
				'code' =>500,
				'message'=> "發生錯誤，請稍後嘗試",
			  ],500);
		  }
		  
	  }
	  
	  public function profileDelete($id){
		  
			  $user = User::findOrFail($id);
			  
			  if(!$user){
				  		
						return response()->json([
						'status' =>false,
						'code' =>404,
						'message' => "查無此用戶",
						'error_type' =>"not_found_user",
			  ],404);
				  
			  }
			  
			  try{
						$user->delete();
			            return response()->json([
							'status' =>true,
							'code'=>200,
							'message' =>"刪除成功",
							'success_type' => 'success_delete',
						]);

		  }catch(\Throwable $e){
			  
			  \Log::error($e->getMessage());
			  
			  return response()->json([
						'status' =>false,
						'code' =>500,
						'message' => "發生錯誤",
			  ],500);
		  }
	  }
  }
