<template>

<div class="container">
<form action="" method="POST" class="register-form-container" id="register-form">
<div class="Logo">
<h1>會員註冊</h1>
</div>

<div class="flex-wrap">
<label for="email" class="set-width">帳號(email)</label>
<input type="email" class="set-width" id="email" placeholder="Email" required name="email">
</div>

<div class="flex-wrap">
<label for="checkEmail" class="set-width">確認帳號(email)</label>
<input type="email" class="set-width" id="checkEmail"  name="checkEmail" placeholder="CheckEmail" required>
</div>

<div class="flex-wrap">
<label for="password" class="set-width">密碼</label>
<input type="password" class="set-width" id="password" placeholder="Password" name="password" required>
<p style="color:red;" class="set-width">請輸入至少一個大寫跟一個特殊符號</p>
</div>
<div class="flex-wrap">
<label for="checkPassword" class="set-width">確認密碼</label>
<input type="password" class="set-width" id="checkPassword"  name="checkPassword" placeholder="CheckPassword" required>
</div>

<div class="flex-wrap" id="firstname-container">
<label for="name" class="set-width">名</label>
<input type="text" class="set-width" id="name"  placeholder="FirstName"  name="firstname" required>
</div>

<div class="flex-wrap" id="lastname-container">
<label for="lastname" class="set-width">姓</label>
<input type="text" class="set-width" id="lastname" placeholder="LastName"  name="lastname" required>
</div>

<div class="flex-wrap">
<label for="sex" class="set-width">性別</label>
<select id="sex" class="set-width" name="sex">
<option value=" " disabled selected hidden>Select</option>
<option value="女性">女性</option>
<option value="男性">男性</option>
<option value="其他">其他</option>
</select>
</div>

<div class="flex-wrap">
<label for="country" class="set-width">國家</label>
<input type="text" class="set-width" id="country" placeholder="Country" name="country">
</div>

<div class="flex-wrap">
<label for="birthdate" class="set-width">生日</label>
<input type="date" class="set-width" id="birthdate"  name="birthdate" required>
</div>

<div class="flex-wrap">
<label for="tel" class="set-width">電話</label>
<input type="tel" class="set-width" id="tel" placeholder="Phone" name="tel">
</div>

<div class="flex-wrap" id="address">
<label for="address" class="set-width">住址</label>
<input type="text" class="set-width" id="address" placeholder="Address" name="address">
</div>

<div class="register-button-template">
<button class="button" type="submit" id="button">Register</button>
</div>

</form>
</div>

</template>

<script>
import {onMounted} from 'vue'
import '../../css/Register.css';
export default{

name:'Register',

mounted(){

const date =document.getElementById("birthdate"); 

date.addEventListener('click',function(){

	this.showPicker && this.showPicker();

  });

	const form= document.getElementById('register-form');
	const loadingForm = document.getElementById('loading-form');
	const submitButton = document.querySelector('#button');
	
	form.addEventListener('submit', async (e) =>{
	e.preventDefault();
	
	loadingForm.classList.remove('hidden');
	submitButton.disabled=true;
	
		  // 取得欄位值
  const email = document.getElementById('email').value.trim();
  const checkEmail = document.getElementById('checkEmail').value.trim();
  const password = document.getElementById('password').value;
  const checkPassword = document.getElementById('checkPassword').value;
  
    // 前端驗證
  if (email !== checkEmail) {
    alert('帳號與確認帳號不一致');
	loadingForm.classList.add('hidden');
    return;
  }

  if (password !== checkPassword) {
    alert('密碼與確認密碼不一致');
	loadingForm.classList.add('hidden');
    return;
  }
	
	const formData = new FormData(form);
	const data = Object.fromEntries(formData.entries());
	
	try{
	
	const response = await fetch('/api/register', {
		method: 'post',
		credentials: 'include',
		headers:{
			'Content-Type': 'application/json',
			'Accept': 'application/json',
		},
		body: JSON.stringify(data),
	});
	
	const result = await response.json();
	
	if(response.ok){
	 alert('註冊成功，請前往信箱驗證');
	 console.log(result);
	 loadingForm.classList.add('hidden');
	 window.location.href="/"
	}else if(response .status ===422){
	const errorMessage = '註冊失敗\n' + 
		Object.entries(result.errors)
		.map(([field, messages]) => `${field}: ${messages.join(', ')}`)
		.join('\n');

	     alert(errorMessage);
		 loadingForm.classList.add('hidden');
	}else{
	alert('發生其他錯誤');
	loadingForm.classList.add('hidden');
	console.error(result);
	}
	
	}catch(err){
		console.error('發送失敗:',err);
		alert('網路錯誤，請稍後在試');
		loadingForm.classList.add('hidden');
	  }finally{
		loadingForm.classList.add('hidden');
		submitButton.disabled=false;
	  }
	});
 }
}
</script>