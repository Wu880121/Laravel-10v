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

    // 直接轉跳，Laravel 才會幫你寫入 email_verified_at
    window.location.href = redirectUrl
  }
    

    try {
      const res = await fetch(redirectUrl, {
        method: 'GET',
        credentials: 'include',
        headers: {
          'Accept': 'application/json'
        }
      })

      const data = await res.json()

      if (res.ok) {
        alert('✅ 恭喜驗證成功!')
		loadingForm.classList.add('hidden')
        setTimeout(() => {
          window.location.href = '/' 
       }, 5000)
      } else {
        alert('❌ 驗證失敗：' + (data?.message || '未知錯誤'))
		loadingForm.classList.add('hidden')
      }
    } catch (err) {
      alert('❌ 發生錯誤，請稍後再試')
	  loadingForm.classList.add('hidden')
      console.error(err)
    }finally{
		loadingForm.classList.add('hidden')
	}
  }
}
</script>
