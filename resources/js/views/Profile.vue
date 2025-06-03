<template>

<div class="profile-cover">
	
	<div class="profile-container">
	
	<form  id="profile-form" @submit.prevent="updateProfile"  data-form>
	<label data-title>個人資料</label>
	

	
	<div  class="file-div" data-div-row>
	<img src="/public/images/rainbow-flag.png"  id="picture" style="width:80px; height:80px;">
	<label for="picture" data-label>選擇照片</label>
	<input type="file"  name="picture"  data-input >
	</div>
	
	<div data-div-row-tow>
	<div data-div>
	<label for="firstname" data-label>姓</label>
	<input type="text" name="firstname" id="firstname" data-input>
	</div>	
	<div data-div>
	<label for="lastname" data-label>名</label>
	<input type="text"  name="lastname" id="lastname" data-input>
	</div>	
	</div>	
	
	
	<div data-div-row-tow>
	<div data-div>
	<label for="sex"  data-label>性別</label>
	<select  name="sex" id="sex"  data-input>
	<option value=""  hidden>性別</option>
	<option value="女性">女性</option>
	<option value="男性">男性</option>
	<option value="其他">其他</option>
	</select>
	</div>	
	
	<div data-div>
	<label for="birthdate" data-label>生日</label>
	<input type="date"  name="birthdate" id="birthdate" data-input >
	</div>	
	</div>	
	
	<div data-div-row-tow>
	<div data-div>
	<label for="email" data-label>帳號</label>
	<input type="email"  name="email" id="email"  data-input >
	</div>	
	<div  data-div>
	<label for="address" data-label>地址</label>
	<input type="text"   name="address" id="address" data-input>
	</div>	
	</div>	
	

	
	<div data-div-row-tow>
	<div data-div>
	<label for="country" data-label>國家</label>
	<input type="text" name="country" id="country" data-input>
	</div>	
	<div data-div>
	<label for="tel" data-label>電話</label>
	<input type="tel"  name="tel" id="tel" data-input>
	</div>	
	</div>	
	
	
	
	
	<div data-button-row class="button-row">
	<button @click='showCheck' type="button"   id="update_button" data-button>更改資料</button>
	<button @click="goToHome" data-button>確認</button>
	</div>
	
	<div data-button-row class="register-button">
	<button onclick="/delete" data-button>刪除</button>
	<button @click="goToResendVerification" data-button>補發驗證信</button>
  </div>
  
    <div id="data-check-container" class="hidden" data-check-container>
	<lable  data-check-container-label>確定要更新嗎?</lable>
	<img src="/public/images/exclamation-mark.png" atl="提醒" style="width:70px; height:70px;"> 
	<div data-check-button>
	<button type="submit" data-button-click>確定</button>
	<button @click="cancelCheck"  type="button" data-button-click>取消</button>
	</div>
  </div>

  </form>
  

  
</div>
</div>

</template>

<script>
import {onMounted} from 'vue';
import "../../css/Profile.css";
export default{
	
	name:'profile',
	
	mounted()
	{	
	
		this.showPicker()
		this.loadProfile();
	
    },

	methods:{
		
		  async goToResendVerification() {
                
			  this.$router.push('/resend_register_verification');
              
			  },		  
			  
			  async goToHome() {
                
			  this.$router.push('/');
              
			  },
	
			  
		async showLoading(){
			
					const loadingForm = document.getElementById('loading-form');
					
					loadingForm.classList.remove('hidden');
		},		
		
		
		async hiddenLoading(){
			
					const loadingForm = document.getElementById('loading-form');
					
					loadingForm.classList.add('hidden');
		},
		
		async cancelCheck(){
			
			const data_check_container = document.getElementById('data-check-container');
			
			data_check_container.classList.add('hidden');
		},
		
			
			async showCheck(){
			
			const data_check_container = document.getElementById('data-check-container');
			
			data_check_container.classList.remove('hidden');
		},
	
	
		async showPicker(){
			
			const birthdate = document.getElementById('birthdate');
			
			birthdate.addEventListener('click', ()=>{
				
			birthdate.showPicker && birthdate.showPicker();
		});
		
		},
	
		async loadProfile(){
					
					const profile_form =document.getElementById('profile-form');
					profile_form.classList.add('hidden');
					this.showLoading()
					
				try{
				
					const urlResponse = await axios.get('/api/profile',  {
                        withCredentials: true,
                        headers: {
                          Accept: 'application/json'
                        }                      
					});
					
					if(!urlResponse){
						
						alert('網路發生錯誤');
					};
					
					
					const { status, code, message, success_type, user } = urlResponse.data;
					
					if(status===true && code===200 && success_type ==="success_get_user"){
								
								this.hiddenLoading()
								profile_form.classList.remove('hidden');
						        document.getElementById('firstname').value = user.firstname;
                                document.getElementById('lastname').value = user.lastname;
                                document.getElementById('email').value = user.email;
                                document.getElementById('address').value = user.address;
                                document.getElementById('sex').value =user.sex;
                                document.getElementById('birthdate').value = user.birthdate;
                                document.getElementById('country').value = user.country;
                                document.getElementById('tel').value = user.tel;
                                document.getElementById('picture').src = user.picture;
							
					};
				
				}catch(error){
				
						if(error.response){
						
							const { status , code, message, error_type} = error.response.data;
							
                                  switch (error_type) {
                                   
                                      case "not_found_token":
                                        alert("⚠️ " + message);
										this.hiddenLoading()
										window.location.href="/login";
                                        break;                                     
										
										case "profile_not_found_user":
                                        alert("⚠️ " + message);
									    this.hiddenLoading()
										window.location.href="/login";
                                        break;
										
                                      case "not_found_user":
                                        alert("⛔️ " + message);
										this.hiddenLoading()
										window.location.href="/login";
                                        break;
                                      case "not_authenticated":
                                        alert("🔐 " + message);
										this.hiddenLoading()
										window.location.href="/login";
                                        break;                                
									  
                                    default:
                                      alert("發生未知錯誤，請稍後");
									  this.hiddenLoading()
                                      break;
                                  }

							
						}else{
						
							alert("網路發生問題");
							this.hiddenLoading()
						}
				}finally{
					
					this.hiddenLoading()
				
				}
			},
			
			async updateProfile(){
				
				this.cancelCheck();
				const update_button = document.getElementById('update_button');
			    const form = document.getElementById('profile-form');
				
					this.showLoading();
					update_button.disabled = true;
					
					try{
						
						const formData = new FormData(form);
						
							
						const updateResponse = await axios.post('/api/update_profile',formData,{
							
							withCredentials:true,
							headers:{
								'Content-Type' : 'multipart/form-data',
								'Accept' : 'application/json',
							}
					});


								if(!updateResponse){
									
									alert('連線發生錯誤');
									this.hiddenLoading()
								}
								
								const {message , status , code , success_type} = updateResponse.data;
								
								if(status===true && code===200 && success_type==="updat_success"){
									
									alert(message);	
                                    this.hiddenLoading()	
                                    location.reload();									
								}
						
					}catch(error){
						
						if(error.response){
						
						const { status, code, message, error_type} =error.response.data;
						

						
						switch(error_type){
							
							case "updat_failed":
							alert(message);
							this.hiddenLoading()
							break;											
							
							case "not_verification_email":
							alert(message);
							this.hiddenLoading()
							break;							
							
							case "updat_errors":
							alert(message);
							this.hiddenLoading()
							break;							
							
							case "failed_validated":
							alert(Object.values(message).flat().join('\n'));
							this.hiddenLoading()
							break;
							
							default:
							alert("發生未知錯誤");
							this.hiddenLoading()
							break;
						}	
						
					}else{
						
						alert('網路發生問題');
						this.hiddenLoading()
					}
				}finally{
					
					this.hiddenLoading()
					update_button.disabled = false;
				}
		},		
	}
}	
</script>