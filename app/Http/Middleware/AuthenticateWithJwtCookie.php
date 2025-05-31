<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class AuthenticateWithJwtCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		
		try{
				
				$token= $request->cookie('token');
				
				if(!$token){
					return response()->json([
							'status' =>false,
							'code' =>401,
							'error_type' =>"not_found_token",
							'message' =>"請先登入",
					],401);
				}
				
				$user = JWTAuth::setToken($token)->authenticate();
				
				if(!$user){
					return response()->json([
							'status' =>false,
							'code' =>401,
							'error_type' =>"not_found_user",
							'message' =>"查無此使用者",
					],401);
				}
				
				auth()->setUser($user);  // controller 裡就可以這樣用 $user = auth()->user();
			
		}catch(Exception $e){
			
			return response()->json([
			
			'status' => false,
			'code' => 401,
			'error_type' =>"not_authentication",
			'message'=>'未授權',
			
			],401);
		}


	   return $next($request);
    }
}
