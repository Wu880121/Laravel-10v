<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\ResendRegisterVerificationEmailController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\Logout;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//註冊的
Route::post('/register', [RegisterController::class, 'register']);

//登入的
Route::post('/login', [AuthController::class,'login']);


//驗證register時送出email
Route::get('/verify-email', function (Request $request) {
    $user = User::findOrFail($request->query('id'));

    if (!URL::hasValidSignature($request)) {
        return response()->json(['message' => '驗證連結無效或已過期'], 403);
    }

    if (!hash_equals(sha1($user->email), $request->query('hash'))) {
        return response()->json(['message' => '驗證碼錯誤'], 403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return response()->json(['message' => 'Email 驗證成功']);
})->name('api.verify.email');


//重新寄送註冊驗證的

Route::middleware('jwt.cookie')->post('/resend_register_verification',[ResendRegisterVerificationEmailController::class, 'resendVerification']);

Route::middleware('jwt.cookie')->group(function(){
		//這邊放要經過jwt.cookie 驗證的路由群組
		Route::get('/me', function(Request $request){
			return response()->json([
				'status' => true,
				'message' => "登入成功",
				'code' =>200 ,
				'user' => auth()->user(),
			],200);
		});
		
		//登出的post
		Route::post('/logout',[Logout::class, 'logout']);
});


Route::post('send_reset_email',[ResetPasswordController::class, 'sendResetLinkEmail']);



Route::post('reset_password',[ResetPasswordController::class,'reset']);