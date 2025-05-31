<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest

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
            'email' =>[
			'required',
			'email',
			],
			
			'password' =>[
			'required',
			'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[.@_%&$-])(?=.*[0-9])(?=\S{8,15}).{8,15}$/',
			'confirmed',
			],
			
			'password_confirmation'=>[
			'required',
			],
			
			
			'token' =>[
				'required', 
				'string',
			],
        ];
    }
	
	
	public function messages():array
	{
		return[
					'email.required' => '請輸入email',
					'email.email' => "請輸入email格式",
					'password.required' => "請輸入密碼",
					'password.regex' => "請輸入正確格式，要有一個大寫，一個小寫，任選一個符號.@_%&$-，一個數字，8~15個字，不可以有空格",
					'password_confirmation.required' => '請輸入密碼',
					'password.confirmed' => "輸入的密碼不一致",
		];
	}
	
		public function failedValidation(Validator $validator)
		{
			throw new HttpResponseException(response()->json([
						
						'status' =>false,
						'messages' => "驗證錯誤",
						'code' => 422,
						'errors' =>$validator->errors(),
			],422));
		}
	
}
