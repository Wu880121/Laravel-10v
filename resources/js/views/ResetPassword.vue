<template>

<div class="reset-password-cover">
	
	
	<div class="reset-password-container">
	<form id="reset-password-form">
	<div class="reset-password-title"><h1>重新設定密碼</h1></div>
	<div class="input-set">
	<label for="reset-password-password">請輸入新密碼</label>
	<input type="password" class="input-set" id="reset-password-password" placeholder="Password">
	</div>
	
	<div  class="input-set">
	<label for="reset-password-check_password">確認密碼</label>
	<input type="password" class="input-set" id="reset-password-check_password" placeholder="CheckPassword">
	</div>
	<button class="reset-password-button" id="submitButton">Reset</button>
	</form>
	</div>
	

</div>

</template>


<script>

import "../../css/ResetPassword.css";
import {onMounted} from 'vue';

export default
 {
	name: 'reset-password',
	mounted()
	{
		
		const urlParams = new URLSearchParams(window.location.search);
		
		const urlToken = urlParams.get('token');
		const urlEmail = urlParams.get('email');
		
		const resetform = document.getElementById('reset-password-form');
	    const loadingForm = document.getElementById('loading-form');
		const submitButton =document.getElementById('submitButton');
		
		resetform.addEventListener('submit', async (e)=>{
			
			e.preventDefault();
			loadingForm.classList.remove('hidden');
			submitButton.disabled=true; 
			
			const passwordInput =  document.getElementById('reset-password-password').value.trim();
			const checkPassword =document.getElementById('reset-password-check_password').value.trim();
			
             const data = {
               token: urlToken, // 👈 改成 token 才能被後端接到
               email: urlEmail,
               password: passwordInput,
               password_confirmation: checkPassword // 👈 Laravel 預設認密碼欄位為 password_confirmation
             };                           
			
			if(passwordInput!==checkPassword)
			{
				alert("請確認輸入一樣的密碼");
				loadingForm.classList.add('hidden');
				return; 
			}
		
		try{
			const response = await axios.post('/api/reset_password',data,{
			header:
			{
				'Accept':'application/json',
			},
		});
		
		const {message, status, code, error_type} =response.data;
		
		if(status===true&&code===200)
		{
			alert(message);
			loadingForm.classList.add('hidden');
			window.location.href = "/login";
		}
		
		if(status===false&&code!==422)
		{
			switch(code){
				
				case 403:
				if(error_type==="password_same"){
				alert(message);
				loadingForm.classList.add('hidden');
				}else{
					alert(message);
					loadingForm.classList.add('hidden');
				}
				break;					

				case 400:
				alert(message);
				loadingForm.classList.add('hidden');
				break;				
				
				case 404:
				if(error_type==="NoFoundToken")
				alert(message);
			    loadingForm.classList.add('hidden');
				break;
				
				
				default:
				alert('發生錯誤');
				loadingForm.classList.add('hidden');
				break;
			}
		}
	  }catch(err)
	  {
		  
		  if(err.response)
		  {
			  const {code , errors} = err.response.data;
			  
			  if(code===422&&errors)
			  {	
				const error_message = Object.values(errors).flat().join('\n');
				  alert(error_message);
				  loadingForm.classList.add('hidden');
			  }else
			  {
				  alert("未知錯誤");
				  loadingForm.classList.add('hidden');
			  }
		  }else
		  {
			  alert("網路發生問題，請稍後嘗試");
			  loadingForm.classList.add('hidden');
		  }
     	  }finally
		  {
			     loadingForm.classList.add('hidden');
		         submitButton.disabled=false;
		  }
		});
	}
 }
</script>