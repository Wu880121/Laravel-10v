<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
            'email'=>['required', 'email'],
			'password'=>['required', 'min:8', 'max:15'],
			'rememberme'=>['nullable'],
        ];
    }
	
	
	public function messages():array
	{
			return[
			'email.required'=>'請填入email',
			'email.email'=>'請填入正確格式',
			'password.required'=>'請輸入密碼',
			'password.max'=>'請勿超過15個字元',
			];
		
	}
	
	protected function failedValidation(Validator $validator)
	{
			throw new HttpResponseException(response()->json([
				'status'=>false,
				'code'=>422,
				'message'=>'驗證失敗',
				'errors'=>$validator->errors(),
			]));
	}
}
