<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class sendResetPasswordRequest extends FormRequest

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
					
        ];
    }
	
	
	public function messages():array
	{
		return[
					'email.required' => '請輸入email',
					'email.email' => "請輸入email格式",
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
