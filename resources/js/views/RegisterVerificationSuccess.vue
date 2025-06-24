<template>

<div class="register_verify_successsuccsee_container">
<div class="register_verify_successsuccsee">
<h1 class="register_success_h1">將在5秒後幫你導向首頁</h1>
<h1 class="register_success_h1">或是點擊下面連結前往首頁</h1>
<router-link to="/" class="register_success_a">返回主畫面</router-link>
  </div>
</div>
</template>


<script>
 import"../../css/RegisterVerificationSuccess.css";
export default {
  name: 'register_verify_success',

  async mounted() {
    const redirectUrl = new URLSearchParams(window.location.search).get('redirect')

    if (!redirectUrl) {
      alert('缺少驗證連結參數')
      return
    }

    window.location.href = redirectUrl
  }
}

</script>
