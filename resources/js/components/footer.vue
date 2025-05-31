<template>

<div class="footer-template">

<div class="footer-first-container">
<h3 style="color:white;" data-text>咖啡 / COFFEE</h3>
<div class="row">
<i class="fa-solid fa-mug-hot" style="color: #e9ecf1; font-size:2rem;" data-text></i>
</div>
</div>

<div class="footer-second-container">
<h3 style="color:white;" data-text>付款方式 / PAYMENT</h3>
<div class="row">
<i class="fa-solid fa-sack-dollar" style="color: #e8eaed; font-size:2rem;" data-text></i>
<i class="fa-solid fa-credit-card" style="color: #e4e7ec; font-size:2rem;" data-text></i>
<i class="fa-brands fa-cc-apple-pay" style="color: #e7eaee; font-size:2rem;" data-text></i>
</div>
</div>

<div class="footer-third-container">
<h3 style="color:white;" data-text>社群媒體 / SOCIAL</h3>
<div class="row">
<i class="fa-brands fa-instagram" style="color: #eeece8; font-size:2rem;" data-text></i>
<i class="fa-brands fa-threads" style="color: #e4e7ec; font-size:2rem;" data-text></i>
<i class="fa-brands fa-line" style="color: #eceff3; font-size:2rem;" data-text></i>
</div>
</div>


</div>

</template>


<script>

import  "../../css/Footer.css";
import  {onMounted} from 'vue';

export default
 {
    name: 'footer',
	
	mounted()
	 {
			
	 }

 }

</script>