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
<button type="submit" class="button" id="submitButton">Login</button>
</div>
<div class="register-form">
<router-link to="/register">還沒有帳號嗎? 點擊註冊</router-link>
</div>

</form>
</div>

<div class="show-forgot-password-form none" id="show-forgot-password-form">
<form  class="forgot-password-form" id="forgot-password-form">
<div class="email-label"><label for="forgot-password-email">請輸入註冊帳號時的Email</label></div>
<input type="email" id="forgot-password-email" placeholder="EnterEmail" required name="email">
<div class="return-login" id="return-login"><router-link to="/login">返回登入畫面</router-link></div>
<div class="button-template-forgot-password">
<button type="submit" class="button" id="submitButton_forgot">Send</button>
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
const submitButton = document.getElementById("submitButton");

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
const loadingForm = document.getElementById('loading-form');

loginForm.addEventListener('submit', async (e) =>
{
	e.preventDefault();
	loadingForm.classList.remove('hidden');
	submitButton.disabled=true;
	
	const formData = new FormData(loginForm);
	const data = Object.fromEntries(formData.entries());
	
	
	try{
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
			loadingForm.classList.add('hidden');
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
			loadingForm.classList.add('hidden');
		}else
		{
			alert('帳號密碼不正確');
			loadingForm.classList.add('hidden');
			console.error(result);
		}
		
	}catch(err)
	{
		console.error('發送失敗:' , err);
		alert('網路錯誤，請稍後在試');
		loadingForm.classList.add('hidden');
	}finally{
	   submitButton.disabled=false;
	  loadingForm.classList.add('hidden');
	}
});


const forgetpasswordform = document.getElementById('forgot-password-form');
const submitButton_forgot = document.getElementById('submitButton_forgot');

forgetpasswordform.addEventListener('submit', async (e) => {
  e.preventDefault();
   loadingForm.classList.remove('hidden');
   submitButton_forgot.disabled=true;
   
  const email = {
    email: document.getElementById('forgot-password-email').value.trim(),
  };

  try {
    const response = await axios.post('/api/send_reset_email', email, {
      headers: {
        'Accept': 'application/json',
      },
    });

    const { status, code, message } = response.data;

    // ✅ 處理成功
    if (code === 200) {
      alert('✅ 信件已經送出囉，請去信箱查看');
	   loadingForm.classList.add('hidden')
      return;
    }

    // ⚠️ 特定錯誤代碼處理（不包括 422）
    if (status === false && code !== 422) {
      switch (code) {
        case 404:
          alert("❌ 查無此 email，請輸入與註冊時一樣的 email");
		   loadingForm.classList.add('hidden')
          break;
        case 429:
          alert("⏳ 請稍後再試：\n" + message); // 顯示剩餘時間
		   loadingForm.classList.add('hidden')
          break;
        case 400:
          alert("❌ 寄信失敗，請稍後再試");
		   loadingForm.classList.add('hidden')
          break;
        default:
          alert("⚠️ 錯誤：" + message);
		   loadingForm.classList.add('hidden')
      }
    }

  } catch (error) {
    console.log("❗ 捕捉到錯誤:", error);

    if (error.response) {
      const { code, errors, message } = error.response.data;

      if (code === 422 && errors) {
        const errorMessages = Object.values(errors).flat().join('\n');
        alert("🔍 驗證失敗：\n" + errorMessages);
		 loadingForm.classList.add('hidden')
      } else {
        alert("⚠️ API 錯誤：" + (message || '發生未知錯誤'));
		 loadingForm.classList.add('hidden')
      }
    } else {
      alert("🚫 無法連線到伺服器，請檢查網路");
	   loadingForm.classList.add('hidden')
    }
  }finally{
	  submitButton_forgot.disabled=false; 
	  loadingForm.classList.add('hidden')
  }
});

   }
}

</script>