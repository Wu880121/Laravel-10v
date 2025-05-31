<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_reset_tokens extends Model
{
    use HasFactory;
	
	protected $table = 'password_reset_tokens'; // ← 指定正確資料表名稱
	
	protected $fillable=
	 [ 
		 'email',
		 'token',
		 'created_at',
	 ];
	 
	   public $timestamps = false; // ✅ 告訴 Laravel：不要自動處理時間欄位
	   
	   //因為laravel預設會在你有更新資料表的時候自動更新時間，會需要created_at 跟 updated_at 
	   //如果只有created_at ，沒有 updated_at ，那就會報錯。
	   
	   protected $casts=
		[
				'created_at' => 'datetime',
		];
}
