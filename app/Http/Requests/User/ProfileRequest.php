<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            	
				'email'=>[
				'required',
				'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
				Rule::unique('users', 'email')->ignore(auth()->id()),
			],
				
				'firstname'=>[
				'required',
				'regex:/^[A-Za-z\x{4e00}-\x{9fff}]{1,15}$/u',
			],
			
			'lastname'=>[
			    'required',
				'regex:/^[A-Za-z\x{4e00}-\x{9fff}]{1,15}$/u',
			],
			
			'country'=>[
				'regex:/^[A-Za-z\x{4e00}-\x{9fff}]{0,20}$/u',
			],
			
			'tel'=>[
				'regex:/^[0-9]{0,15}$/'
			],
			
			'address'=>[
				'regex:/^[A-Za-z0-9\x{4e00}-\x{9fff}]{0,30}$/u'
			],
			
			'sex'=>[
			'nullable',
			'in:女性,男性,其他',
			],
			
			'birthdate'=>[
			'required',
			'date_format:Y-m-d',
			'before_or_equal:today',
			],
			
			'picture' =>[
				
                   'image',           // 限定為圖片類型（jpg、png、bmp、gif、svg、webp）
                   'max:2048',        // 最大檔案大小為 2048 KB（= 2MB），1024 KB = (1MB)
                   'mimes:jpg,jpeg,png', // 限定檔案副檔名（可選）               
			],
			
        ];
    }
	
	
	public function message():array{
		
		return[
		
		'email.required' => "請輸入email",
		'email.regex' => "請輸入正確的Email格式",
		'email.unique' => "此Email已經被註冊",
		'firstname.required' => "請輸入姓氏",
		'firstname.regex' => "請勿超過15個字",
		'lastname.required' => "請輸入名字",
		'lastname.regex' => "請勿超過15個字",
		'country.regex' =>"請勿超過20個字",
		'tel.regex' =>"請輸入正確的電話格式",
		'address.regex' =>"請勿超過30個字",
		'sex.in' =>"請選擇選項內的字元",
		'birthdate.required' => "請輸入生日",
		'birthdate.date_format' =>"請輸入正確的生日格式Y-m-d",
		'birthdate.before_or_equal' => "請勿選擇未來日期",
		'picture.image' => "請選擇圖片格式的檔案",
		'picture.max' => "最多容量為2MB",
		'picture.mimes' => "格式僅限jpg / jpeg / png",
		
		];
	}
	
	public function failedValidation(Validator $validator){
		
			
			throw new HttpResponseException(response()->json([
							
							'status' =>false,
							'code' => 422,
							'error_type' => "failed_validated",
							"message" => $validator->errors(),
			],422));
		
	}
}
