<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\ResetPasswordNotification;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
	
	
	//這邊是寄信用的複寫
	public function sendEmailVerificationNotification()
     {
         $this->notify(new CustomVerifyEmail());
     }
	 
	 //這邊是忘記密碼的
	 public function sendPasswordResetNotification($token)
     {
       $this->notify(new ResetPasswordNotification($token)); // ✅ 可自由決定用哪封通知
     }
	 
	 
	//這邊是利用JWT抓id
	public function getJWTIdentifier()
    {
        return $this->getKey();
    }
	
	
	//這邊是JWT可以產生的欄位
    public function getJWTCustomClaims()
    {
        return [
			'role' => $this->role,
			'id' => $this->id,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
		];
    }
	
	//這邊是資料庫的getXxxAttribute方法
	
	public function getPictureAttribute($value){
		
		return $value ?? 'storage/user_photos/default.png';
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
		'lastname',
        'email',
        'password',
		'sex',
		'country',
		'birthdate',
		'tel',
		'address',
		 'picture',
		 'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	//把 email_verified_at 欄位的值，自動轉成 Carbon 類別（也就是 datetime 物件），讓你可以像操作時間一樣使用它。
}
