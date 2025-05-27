<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResendRegisterVerificationEmailRequest extends FormRequest
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
            'email'=>['required', 'email', 'exists:users,email'],
        ];
    }
	
	
	public function messages(): array
	{	
	   return[
		'email.required' => '請填寫email',
		'email.email' => '請填寫正確格式',
		'email.exists' => 'email不存在',
		];
	}

	
	
		public function failedValidation(Validator $validator)
		{
			throw new HttpResponseException(response()->json([
				
				'status' =>false,
				'code' =>422,
				'message' => '驗證失敗',
				'errors' => $validator->errors(),
			]));
		}
}