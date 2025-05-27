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
				JWTAuth::setToken($token)->authenticate();
				
			
		}catch(Exception $e){
			
			return response()->json(['message'=>'未授權'],401);
		}


	   return $next($request);
    }
}
