<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
				'unique:users,email',
			],
			
			'checkEmail'=>[				
			    'required',
				'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
				'same:email',
			],
				
			
			'password'=>[
				'required',
				'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[.@_%&$-])(?=.*[0-9])(?=\S{8,15}).{8,15}$/'
			],
			
			'checkPassword'=>[
				'required',
				'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[.@_%&$-])(?=.*[0-9])(?=\S{8,15}).{8,15}$/',
				'same:password',
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
        ];
    }
	
	public function messages():array{
		
		return[
		 'email.required'=>"請輸入email",
		 'email.regex'=>'email格式錯誤',
		 
		 'checkEmail.required'=>'請確認email',
		 'checkEmail.same'=>'請輸入一樣的email',
		 'checkEmail.regex'=>'格式錯誤，請再輸入一次',
		 
		 'password.required'=>'請輸入password',
		 'password.regex'=>'格式錯誤，至少包含一個大寫，一個符號，一個小寫，一個數字，長度限制8~15',
		 'checkPassword.required'=>'請確認password',
		 'checkPassword.regex'=>'格式不正確，請再輸入一次',
		 'checkPassword.same'=>'請輸入一樣的password',
		 
		 'firstname.required'=>'請輸入名',
		 'firstname.regex'=>'格式錯誤，至少一個字，最多15個',
		 
		 'lastname.required'=>'請輸入姓',
		 'lastname.regex'=>'格式錯誤，至少一個字，最多15個',
		 
		 'country.regex'=>'格式錯誤，做多20個字',
		 
		 'tel.regex'=>'格式錯誤，只能是數字，最多15個字',
		 
		 'address.regex'=>'格式錯誤，最多30個字',
		 
		 'sex.in'=>'只能是女性，男性，與其他',
		 
		 'birthdate.required'=>'請填選生日',
		 'birthdate.date_format'=>'格式必須是Y-m-d',
		 'birthdate.before_or_equal'=>'不能是未來時間',
		];
		
	}
	
	public function failedValidation(Validator $validator){
		
		throw new HttpResponseException(response()->json([
			'status' =>false,
			'code'=>422,
			'message'=>'驗證失敗',
			'errors'=>$validator->errors()
		]));
		
	}
}
