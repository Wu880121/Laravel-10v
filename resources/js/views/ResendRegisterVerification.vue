<template>

<div class="resend_register_verification_wall">
<div  class="show-resend-verification-form">
<form class="resend-verification-form" id="resend-verification-form">
<div class="email-label"><label for="resend-verification-form-input">請輸入註冊帳號時的Email</label></div>
<input type="email" name="email" id="resend-verification-form-input" placeholder="EnterEmail" required>
<div class="resend_register_verification_return-login"><router-link to="/login">返回登入畫面</router-link></div>
<div class="button-template-resend-verification">
<button id="button" class="button">Send</button>
</div>
</form>
</div>
</div>

</template>

<script>
import {onMounted} from 'vue'
import axios from 'axios'
import "../../css/ResendRegisterVerification.css";
export default{

	name:'resend_register_verification',
	
	mounted()
	{
		const form = document.getElementById('resend-verification-form')
		const button = document.getElementById('button')
		const loadingForm = document.getElementById('loading-form');

		
		 form.addEventListener('submit', async (e)=>{
		
		e.preventDefault()

		loadingForm.classList.remove('hidden');
		button.disabled = true;
		
		const formData = new FormData(form);
		const data = Object.fromEntries(formData.entries());
		
		console.log("送出前");
		try{
			  console.log("發送中");
		const response = await axios.post('/api/resend_register_verification',data,{
			withCredentials:true,
			  headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                              },
		});
		
		
		if(response.data.status === true)
		{
		alert("信件已經送出，請去信箱收信")
		loadingForm.classList.add('hidden');
		}
		}catch(err)
		{
			if(err.response)
			{
				const code = err.response.data.code;
				
				switch(code)
				{
					case 500:
					alert('寄信時發生錯誤');
					loadingForm.classList.add('hidden');
					console.log(err)
					break;					
					
					case 401:
					alert(err.response.data.message);
					loadingForm.classList.add('hidden');
					console.log(err)
					break;
					
					case 400:
					alert('已經驗證過囉');
					loadingForm.classList.add('hidden');
					break;
					
					case 429:
					alert(err.response.data.message);
					loadingForm.classList.add('hidden');
					break;
					
					default:
					alert('發生錯誤');
					loadingForm.classList.add('hidden');
					break;
				}
			}else
		       {
			alert("無法連到伺服器，請檢查網路");
			loadingForm.classList.add('hidden');
		       }
		}finally
		{
			button.disabled = false;
			loadingForm.classList.add('hidden');
		}
	});
 }
}

</script>