<template>

<div class="footer-template">

<div class="footer-first-container">
<h3 style="color:white;" data-text>關於我們 / ABOUT US</h3>
<div class="row">
<img src="/public/images/icons8-coffee-48.png" alt="咖啡" style="width:50px; height:50px;" data-text>
<img src="/public/images/rainbow-flag.png" alt="性別友善" style="width:40px; height:40px;" data-text>
<img src="/public/images/icons8-dog-100.png" alt="寵物友善" style="width:60px; height:60px;" data-text>
</div>
</div>

<div class="footer-second-container">
<h3 style="color:white;" data-text>付款方式 / PAYMENT</h3>
<div class="row">
<img src="/public/images/icons8-cash-48.png" alt="現金" style="width:50px; height:50px;" data-text>
<img src="/public/images/icons8-credit-card-94.png" alt="信用卡" style="width:50px; height:50px;" data-text>
<img src="/public/images/line2.png" alt="LinePay" style="width:40px; height:40px;" data-text>
<i class="fa-brands fa-cc-apple-pay" style="color: #e7eaee; font-size:2.5rem;" data-text></i>
</div>
</div>

<div class="footer-third-container">
<h3 style="color:white;" data-text>社群媒體 / SOCIAL</h3>
<div class="row">
<img src="/public/images/icons8-ig-48.png" alt="IG" style="width:50px; height:50px;" data-text>
<img src="/public/images/line.png" alt="LINE" style="width:38px; height:38px;" data-text>
<i class="fa-brands fa-threads" style="color: #e4e7ec; font-size:2.5rem;" data-text></i>
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