<template>

<div class="reset-password-cover">

	<div class="reset-password-container">
	<div class="reset-password-title"><h1>重新設定密碼</h1></div>
	<div class="input-set">
	<label for="reset-password-password">請輸入新密碼</label>
	<input type="password" class="input-set" id="reset-password-password" placeholder="Password">
	</div>
	
	<div  class="input-set">
	<label for="reset-password-check_password">確認密碼</label>
	<input type="password" class="input-set" id="reset-password-check_password" placeholder="CheckPassword">
	</div>
	<button class="reset-password-button">Reset</button>
	</div>

</div>

</template>


<script>

import "../../css/ResetPassword.css";
import {onMounted} from 'vue';

export default
 {
	name: 'reset-password',
 }
</script>