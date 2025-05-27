<template>

<nav id="Nav" class="nav">
<div class="icon">
<h1>Coffee</h1>
</div>
<div class="middle-link">
<router-link to="/">Home</router-link>
<router-link to="profile">Profile</router-link>
</div>
<div class="right-link">
<router-link to="/login">Login</router-link>
<router-link to="/register">Register</router-link>
<div>
<router-link to="/resend_register_verification">補發驗證信</router-link>
</div>
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
<li><router-link to="profile">Profile</router-link></li>
<li><router-link to="/login">Login</router-link></li>
<li><router-link to="/register">Register</router-link></li>
<li><router-link to="/resend_register_verification">補發驗證信</router-link></li>
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
	
  }
}

</script>