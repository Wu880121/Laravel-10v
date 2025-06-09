<template>

<nav id="Nav" class="nav">
<div class="icon">
<h1>EasePleasure</h1>
</div>
<div class="middle-link">
<router-link to="/">Home</router-link>
<router-link to="/profile" id="profile" >Profile</router-link>
</div>
<div class="right-link">
<router-link to="/login"   id="login_button" >Login</router-link>
<button id="logout_button" class="hidden">Logout</button>
<router-link to="/register"  id="register">Register</router-link>
</div>
</nav>

<nav class="moblie-nav">

<div class="icon">
<h1>Coffee</h1>
</div>

<div class="ul-container"   id="ul-container">
<ul class="ul-form">
<li  id="one"></li>
<li id="two"></li>
<li id="three"></li>
</ul>
</div>
</nav>

<div class="gery-block" id="gery-block">
</div>

<div class="mobile-content-menu" id="mobile-content-menu">
<div class="mobile-content-container">
<ul>
<li><router-link to="/">Home</router-link></li>
<li id="mobile_profile" ><router-link to="/profile">Profile</router-link></li>
<li  id="li_login_button"><router-link to="/login">Login</router-link></li>
<li id="li_logout_button" class="hidden">Logout</li>
<li id="mobile_register"><router-link to="/register">Register</router-link></li>
</ul>
</div>
</div>

</template>

<script>
import {onMounted} from 'vue'
import '../../css/Nav.css';
export default{

name:'Nav',

mounted()
{
	  this.mobilNav();
	  this.showLoginAndLogout();
	  this.Logout();
	   login_button.classList.add('hidden');
	  li_login_button.classList.add('hidden');
	  profile.classList.add('hidden');
	  mobile_profile.classList.add('hidden');
	  register.classList.add('hidden');
	  mobile_register.classList.add('hidden');
},

 methods:{
 
 		async showLoading(){
			
					const loadingForm = document.getElementById('loading-form');
					
					loadingForm.classList.remove('hidden');
		},		
		
		
		async hiddenLoading(){
			
					const loadingForm = document.getElementById('loading-form');
					
					loadingForm.classList.add('hidden');
		},

	async  mobilNav(){
	const one = document.getElementById('one');
	const two = document.getElementById('two');
	const three = document.getElementById('three');
	const container = document.getElementById('ul-container');
	const mobileMenu = document.getElementById('mobile-content-menu');
	const greyarea = document.getElementById('gery-block');
	
	container.addEventListener('click', ()=>{
		
		one.classList.toggle('ul-one');
		two.classList.toggle('ul-two');
		three.classList.toggle('ul-three');
		mobileMenu.classList.toggle('block');
		greyarea.classList.toggle('block');
	});
	
		greyarea.addEventListener('click', ()=>{
		
		one.classList.toggle('ul-one');
		two.classList.toggle('ul-two');
		three.classList.toggle('ul-three');
		mobileMenu.classList.toggle('block');
		greyarea.classList.toggle('block');
	});
	
	},
	
	
	async showLoginAndLogout(){
		
		const login_button = document.getElementById('login_button');
		const logout_button = document.getElementById('logout_button');
		const li_login_button = document.getElementById('li_login_button');
		const profile= document.getElementById('profile');
		const mobile_profile = document.getElementById('mobile_profile');
		const register = document.getElementById('register');
		const mobile_register = document.getElementById('mobile_register');
		
		
		try{
		const response = await axios.get('/api/me',{
			
			'withCredentials': true,
			'headers':{
				
				'Accept': 'application/json',
			},
					});
					
			
			
			if(response.data.code===200 && response.data.status===true)
			{	
				login_button.classList.add('hidden');
				register.classList.add('hidden');
				logout_button.classList.remove('hidden');
				li_logout_button.classList.remove('hidden');
				profile.classList.remove('hidden');
				mobile_profile.classList.remove('hidden');
				
			}
		}catch(err){
			
				login_button.classList.remove('hidden');
				li_login_button.classList.remove('hidden');
				logout_button.classList.add('hidden');
				li_logout_button.classList.add('hidden');
	            register.classList.remove('hidden');
	            mobile_register.classList.remove('hidden');          
			
	   }	
	},
	
	
		async Logout(){
		
		document.querySelectorAll('#logout_button, #li_logout_button').forEach(btn => {
          

		  btn.addEventListener('click', async (e) =>{
			
			this.showLoading()
		  
			e.preventDefault();
			
			try{
					
					const response = await axios.post('/api/logout',{}, {
						
						'withCredentials':true,
						'headers':{
							
							'Accept':'application/json',
						},
						
					});
					


				const {status, code, message, success_type}=response.data;
				
				if(status===true && code===200 &&success_type==="logout_success" ){
					
					alert(message);
					this.hiddenLoading()
					window.location.href ="/";
				}
				
				
			}catch(error){
				
				const {status, code, message}=error.response.data;
				
				if(status===false){
					
					switch(code){
						
						case 401:
						alert(message);
						this.hiddenLoading()
						break;						
						
						case 500:
						alert(message);
						this.hiddenLoading()
						break;
						
						
						default:
						alert("發生未知錯誤");
						this.hiddenLoading()
						break;
					}
				}
			}finally{
			
				this.hiddenLoading();
				login_button.disabled=false;
			}
			
		});

	 });
	}
  }
 }


</script>