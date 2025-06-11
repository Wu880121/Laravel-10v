<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\DashboardRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index (Request $request){
		
		try{
			
           if (!$request->hasCookie('token') || empty($request->cookie('token')) ) {
               
			   return response()->json([
					'status' =>false,
					'code' =>401,
					'message'=> "沒有權限",
					'error_type' => "not_authentication",
			   ]);
           }
		   
		   $role = auth()->user();
		   
		   $role = $role->role;
		   
		   if($role!=="admin"){
			   
			   return response()->json([
			   
				'status' =>false,
				'code' =>401,
				"message"=>"不是管理者請勿進入",
				"error_type"=> "is_not_administrator",
			   ],401);
		   }
			
          $keyword = $request->input('keyword');
        $per_page = $request->input('per_page', 10);

        $users = User::select('id', 'lastname', 'firstname', 'sex', 'picture');

        // 你要搜尋的欄位
        $searchableFields = ['lastname', 'firstname', 'sex','id'];

        if (!empty($keyword)) {
            $users->where(function ($q) use ($keyword, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', "%{$keyword}%");
                }
            });
			
		$users = $users->orderBy('id', 'asc')->paginate($per_page);

        return response()->json($users);
        }
		
			
               $users = $users->orderBy('id', 'asc')->paginate($per_page);
				
				return response()-> json($users);
				
		}catch (\Throwable $e) {
			
			\Log::error($e->getMessage());
        return response()->json([
            'message' => 'Server error',
            'error' => $e->getMessage(),
        ], 500);
    }
  }
  
  public function profile(Request $requset, $id){
	  
	  try{
			
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
	  
	  public function profileUpdate(DashboardRequest $request ,$id){
		  	  
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
