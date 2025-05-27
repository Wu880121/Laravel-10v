<template>

<div class="template">

<div class="show-login-form" id="show-login-form">
<form action="" method="post" class="login-form" id="login-form">
<div class="title"><h3>Welcome</h3></div>
<div class="username-template">
<label for="username">帳號</label>
<input type="email" placeholder="email" id="username" class="username"  name="email" required>
<div id="username-open-eye" class="username-open-eye none"><i class="fa-regular fa-eye"></i></div>
<div  id="username-close-eye" class="username-close-eye"><i class="fa-regular fa-eye-slash"></i></div>
</div>

<div class="password-template">
<label for="password">密碼</label>
<input type="password" placeholder="password" id="password" class="password" name="password" required>
<div id="password-open-eye" class="password-open-eye"><i class="fa-regular fa-eye"></i></div>
<div id="password-close-eye" class="password-close-eye none"><i class="fa-regular fa-eye-slash"></i></div>
</div>

<div class="notice-area">
<div class="checkbox-container">
<input type="checkbox" class="checkbox" id="checkbox" value="1">
<label for="checkbox" >記住我</label>
</div>
<div class="forgot-password-click"><label id="forgot-password-click">忘記密碼</label></div>
</div>

<div class="button-template">
<button type="submit" class="button">Login</button>
</div>
<div class="register-form">
<router-link to="/register">還沒有帳號嗎? 點擊註冊</router-link>
</div>

</form>
</div>

<div class="show-forgot-password-form none" id="show-forgot-password-form">
<form class="forgot-password-form" id="forgot-password-form">
<div class="email-label"><label for="forgot-password-email">請輸入註冊帳號時的Email</label></div>
<input type="email" id="forgot-password-email" placeholder="EnterEmail" required>
<div class="return-login" id="return-login"><router-link to="/login">返回登入畫面</router-link></div>
<div class="button-template-forgot-password">
<button class="button">Send</button>
</div>
</form>
</div>
</div>

</template>



<script>
import { onMounted } from 'vue'
import '../../css/Login.css'
export default{

name:'Login',

mounted(){

const password = document.getElementById("password");
const passwordOpenEye = document.getElementById("password-open-eye");
const passwordCloseEye =document.getElementById("password-close-eye");
const username = document.getElementById("username");		
const usernameOpenEye = document.getElementById("username-open-eye");
const usernameCloseEye = document.getElementById("username-close-eye");

passwordOpenEye.addEventListener("click",function(){

password.type="text";
passwordOpenEye.classList.add("none");
passwordCloseEye.classList.remove("none");
});

passwordCloseEye.addEventListener("click",function(){

password.type="password";
passwordCloseEye.classList.add("none");
passwordOpenEye.classList.remove("none");

        });

usernameOpenEye.addEventListener("click",function(){

username.type="email";
usernameOpenEye.classList.add("none");
usernameCloseEye.classList.remove("none");
});

usernameCloseEye.addEventListener("click",function(){

username.type="password";
usernameCloseEye.classList.add("none");
usernameOpenEye.classList.remove("none");
});


const showLoginForm = document.getElementById('show-login-form');
const showForgotPasswordForm = document.getElementById('show-forgot-password-form');
const clickForgotPassword = document.getElementById('forgot-password-click');
const clickReturnLoginform= document.getElementById('return-login');

clickForgotPassword.addEventListener('click',()=>{
showLoginForm.classList.add('none');
showForgotPasswordForm.classList.remove('none');
});

clickReturnLoginform.addEventListener('click',()=>{
showLoginForm.classList.remove('none');
showForgotPasswordForm.classList.add('none');
});

//這邊開始是傳送json

const loginForm=document.getElementById('login-form');

loginForm.addEventListener('submit', async (e) =>
{
	e.preventDefault();

	const formData = new FormData(loginForm);
	const data = Object.fromEntries(formData.entries());
	
	
	try
	{
		const response = await fetch('api/login',{
			
			'method':'post',
			'credentials':'include',
			headers:
			{
				'Content-Type':'application/json',
				'Accept':'application/json',
			},
			body:JSON.stringify(data),
		});
		
		const result = await response.json();
		
		if (response.ok)
		{
			alert('登入成功');
			
			const role = result.user.role.toLowerCase();
			
			if(role==='admin')
			{
				window.location.href='/admin/dashboard';
			}else
			{
				window.location.href='/';
			}
			
		}else if(response.status===422)
		{
			const errorMessages = '驗證失敗\n'+
			Object.entries(result.errors)
			.map(([field,messages])=>`${field}:{messages.join(',')}`)
			.join('\n');
			
			alert(errorMessages);
		}else
		{
			alert('發生其他錯誤');
			console.error(result);
		}
		
	}catch(err)
	{
		console.error('發送失敗:' , err);
		alert('網路錯誤，請稍後在試');
	}
});
   
   }
}

</script>