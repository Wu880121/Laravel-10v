<template>

<div   data-dashboard-container>

<div  data-side-nav>
<div data-info>
<img src="/public/images/notifications.png" style="width80px; height:80px;">
</div>
<div data-info>
<img src="/public/images/notifications.png" style="width80px; height:80px;">
</div>
<div data-info>
<img src="/public/images/notifications.png" style="width80px; height:80px;">
</div>
</div>

<div data-content>

<div data-board>
<div  id="data-notice"  data-notice>
<img src="/public/images/notice.png" style="width:40px; height:40px;">
</div>
<div data-board-label>
<lable data-board-label>公告看板</lable>
</div>
<div data-board-image></div>
</div>

<div data-dashboard-input-area>
<input type="text"  id="search-input" data-dashboard-input>
<img src="/public/images/search.png"  style="width:40px; height:40px;" id="data-dashboard-image">
</div>

<div id="data-member-info" data-member-info>

<div  data-info>
<label data-info-label>會員資料</label>
<img src= '/public/images/rainbow-flag.png'  style="width:40px; height:40px;">
<div>姓名: XXX</div>
<div>性別: XXX</div>
<div data-dashboard-button-area>
<input type="hidden" data-id>
<button type="button" @click="show_profile_container" data-dashboard-button>編輯</button>
<button type="button" @click="show_data_cancel_container" data-dashboard-button>刪除</button>
</div>
</div>
</div>

<div data-number-bar>
	<div data-number>
	<ul id="data-number-ul" data-number-ul>
	<li class="pagination-btn" data-number-li  data-page><i class="fa-regular fa-square-caret-left"></i></li>
	<li class="pagination-btn" data-number-li data-page>2</li>
	<li class="pagination-btn" data-number-li data-page><i class="fa-regular fa-square-caret-right"></i></li>
	</ul>
	</div>
</div>


</div>

<div id="data-mobile-nav" class="hidden"  data-mobile-nav>
<div id="data-mobile-nav-hidden" data-mobile-nav-hidden>
<img src="/public/images/close.png" style="width:40px; height:40px;">
</div>
</div>

<div id="data-grey-area" class="hidden" data-grey-area>
</div>

	<div class="profile-container hidden" id="profile-container" >
	
	<form  id="profile-form" @submit.prevent="updateProfile"  data-form>
	<label data-title>個人資料</label>
	

	
	<div  class="file-div" data-div-row>
	<img src="/public/images/rainbow-flag.png"  id="picture" style="width:80px; height:80px;">
	<label for="pick_picture" data-label>選擇照片</label>
	<input type="file" id="pick_picture"  name="picture"  data-input >
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
	
	<input type="hidden" id="data-id" data-id>
	
	
	<div data-button-row class="button-row" id="button-row">
	<button @click='show_data_check_container' type="button"   id="update_button" data-button>更改資料</button>
	<button  type="button" @click="hidden_profile_container" data-button>確認</button>
	</div>
  
	    </form>
   </div>
			
	<div id="data-check-container" class="hidden" data-check-container>
	<lable  data-check-container-label>確定要更新嗎?</lable>
	<img src="/public/images/exclamation-mark.png" atl="提醒" style="width:70px; height:70px;"> 
	<div data-check-button>
	<button type="button" @click="submitForm"  data-button-click>確定</button>
	<button @click="hidden_data_check_container"  type="button" data-button-click>取消</button>
	</div>
  </div>
  
    <div id="data-cancel-container" class="hidden" data-check-container>
	<lable  data-check-container-label>確定要刪除嗎?</lable>
	<img src="/public/images/exclamation-mark.png" atl="提醒" style="width:70px; height:70px;"> 
	<div data-check-button>
	<button type="button" id="delete_id" @click="deletePfrofile"  data-button-click>確定</button>
	<button type="button" @click="hidden_data_cancel_container"  data-button-click>取消</button>
	</div>
  </div>
			
</div>

</template>

<script>

import '../../css/Dashboard.css';
import {onMounted} from 'vue';


let start = 1;
let end = 1;

export default{

	name:'dashboard',

	
      mounted(){
		
			this.show_data_mobile_nav();
			this.fetchUsers(1);
			document.getElementById('data-dashboard-image').addEventListener('click', ()=>{
				this.fetchUsers();
				this.show_loading_form();
				console.log("有觸發");
			});
             const searchInput = document.getElementById('search-input');

             searchInput.addEventListener('keydown', (e) => {
               if (e.key === 'Enter') {
                 this.fetchUsers(); // 正常觸發
				 this.show_loading_form();
                 } 
			 });
	  },
      methods:{
		  
		            submitForm() {
                      document.getElementById('profile-form').requestSubmit(); // ✅ 強制觸發 submit
                    },                  
		  
				async show_loading_form(){
					
					const loadingForm = document.getElementById('loading-form');
					loadingForm.classList.remove("hidden");
				},
					async hidden_loading_form(){
					
					const loadingForm = document.getElementById('loading-form');
					loadingForm.classList.add("hidden");
				},

				async show_profile_container(){
				
					document.getElementById('profile-container').classList.remove('hidden');
					
				},
				
				async hidden_profile_container(){
					
					document.getElementById('profile-container').classList.add('hidden');
				},
				
				
				async show_data_check_container(){
					
					document.getElementById('data-check-container').classList.remove('hidden');
					
				},				
				
				
				async hidden_data_check_container(){
					
					document.getElementById('data-check-container').classList.add('hidden');
					
				},
				
				async show_data_cancel_container(){
					
					document.getElementById('data-cancel-container').classList.remove('hidden');
				},
				
					async hidden_data_cancel_container(){
					
					document.getElementById('data-cancel-container').classList.add('hidden');
				},
				
				async show_data_mobile_nav(){
					
					const mobile_nav = document.getElementById('data-mobile-nav');
					const mobile_nav_hidden = document.getElementById('data-mobile-nav-hidden');
					const mobile_grey_area = document.getElementById('data-grey-area');
					const mobile_notice_button = document.getElementById('data-notice');
					
					   await mobile_notice_button.addEventListener('click', ()=>{
						
						mobile_grey_area.classList.remove('hidden');
						mobile_nav.classList.remove('hidden');
					});
					
					 await mobile_nav_hidden.addEventListener('click', ()=>{
						
						mobile_grey_area.classList.add('hidden');
						mobile_nav.classList.add('hidden');
						
					});
					
						await mobile_grey_area.addEventListener('click', ()=>{
						
						mobile_grey_area.classList.add('hidden');
						mobile_nav.classList.add('hidden');
						
					});
					
				},
				
				 async  renderCards(users){
	
	                
	                const container = document.getElementById('data-member-info');
	                
	                container.innerHTML="";
	                
					let html = '';
	                
	                users.forEach(user =>{
		
	                	  html += 
						`<div  data-info>
	                	<label data-info-label>會員資料</label>
                        <img src= '${user.picture}'  id="user_picture" style="width:40px; height:40px;">
                        <div id="user_name">姓名: ${user.firstname+user.lastname}</div>
                        <div id="user_sex">性別: ${user.sex}</div>
						<div id="user_id">ID: ${user.id}</div>
                        <div data-dashboard-button-area>
                        <button type="button" class="edit-btn" data-dashboard-button data-id= ${user.id}>編輯</button>
                        <button type="button" class="delete-btn" data-dashboard-button data-id= ${user.id}>刪除</button>
                        </div>	
						</div>
	                `;
					 });
					
	                	
	                	container.innerHTML = html;
						
					  container.querySelectorAll('.edit-btn').forEach(btn => {
                      btn.addEventListener('click', () => {
						
                        const id = parseInt(btn.dataset.id);
						  console.log("有點擊到"+id);
                        this.show_profile_container();
						this.editeProfile(id);
                      });
                    });					 

					container.querySelectorAll('.delete-btn').forEach(btn => {
                      btn.addEventListener('click', () => {
                        const id = parseInt(btn.dataset.id);
						document.getElementById('delete_id').value = id;
                        this.show_data_cancel_container(); // 或直接呼叫你要的函式
                      });
                    });
                },             
						
						async renderPagination({ currentPage, totalPages }){
	
								
	                            const pagination = document.getElementById('data-number-ul');
	
	                            pagination.innerHTML = "";
	
	                            let html = '';
	
	                            const maxVisible =  6;
	
	                            const half = Math.floor(maxVisible/2);   //floor等於無條件捨去
	
	                            let start = Math.max(1, currentPage-half);
	
	                            let end = Math.min(totalPages, currentPage+half);
	
	                            if ( currentPage-half <= half){
	
	                            end = Math.min(totalPages, maxVisible);
                            }

                               if(currentPage+half > totalPages){
	   
	                             start = Math.max(1, totalPages - maxVisible + 1);
	                             end = totalPages;
                               }
   
   
                               html += ` <li class="pagination-btn" data-number-li  data-page=${currentPage-1} ${currentPage===1? 'active' : ' '}><i class="fa-regular fa-square-caret-left"></i></li>`;
   
                               for(let i = start ; i<=end;  i++){
	   
	                            html += `<li class="pagination-btn" data-number-li data-page=${i} ${currentPage===i? 'active' : ' '}>${i}</li>` ; 
	   
                               }
   
                               html += `<li class="pagination-btn" data-number-li data-page=${currentPage+1} ${currentPage===totalPages? 'active' : ' '}><i class="fa-regular fa-square-caret-right"></i></li>`;
   
   
                               pagination.innerHTML = html;
                               
                               document. querySelectorAll('.pagination-btn').forEach(btn=>{
	   
	                               btn.addEventListener('click', (e)=>{
		   
		                              const page = parseInt(e.target.dataset.page);
		   
		                               if (!isNaN(page)){
			   
			                              this.fetchUsers(page); 
		                               }
	                               });
                               });
   
                        },
				
				async fetchUsers(page=1){
						               
			const keyword = document.getElementById('search-input').value;
            console.log("目前輸入的關鍵字：", keyword);			
					 
					try{
						
						const res = await axios.get(`api/index?page=${page}&keyword=${keyword}` ,{
							withCredentials:true,
						});
						
						const data =  res.data;
						        let currentPage = data.current_page;
                                let totalPages = data.last_page;
                                this.renderCards(data.data);      
                                this.renderPagination({ currentPage, totalPages });                      
						
					}catch(err){
						
						if(err.response){
							
							const {code, status, message, error_type}= err.response.data;
							
							console.log("回傳錯誤內容：", err.response.data);
                              if (code === 401 && status === false) {
                                alert(message);
                                window.location.href = "/";
                              }
						}
					}finally{
						
						 this.hidden_loading_form();
					}
				},
	  
						async editeProfile(id){
							
							try{
							const res = await axios.get(`/api/manage_profile/${id}`,{
								withCredentials:true,
							});
								
								const {code, user, success_type}=res.data;
								
								console.log("有抓到"+id);
								console.log(code);
								
								if( success_type==="success_find"){
								
								console.log("有近來");
								document.getElementById('firstname').value = user.firstname;
                                document.getElementById('lastname').value = user.lastname;
                                document.getElementById('email').value = user.email;
                                document.getElementById('address').value = user.address;
                                document.getElementById('sex').value =user.sex;
                                document.getElementById('birthdate').value = user.birthdate;
                                document.getElementById('country').value = user.country;
                                document.getElementById('tel').value = user.tel;
                                document.getElementById('picture').src = user.picture;
                                document.getElementById('data-id').value = user.id;
									
								}
							
							}catch(err){
								
								if(!err.response){
									
									alert("網路發生問題，請稍後嘗試");
								}
							}
						},
						
						async updateProfile(){
							
							this.show_loading_form();
							const form =document.getElementById('profile-form');
							const id =document.getElementById('data-id').value;
							const formData = new FormData(form);
							
															//for (let [key, val] of formData.entries()) {
                                                              //console.log(key, val);
                                                           // }
							
							try{
							const res = await axios.post(`/api/manage_profile_update/${id}` ,formData,{
								
								withCredentials:true,
								});
								      
								
								 if(!res){
									 
									 alert("連線有問題");
								 }
								
								const {status, code, message, success_type, user}=res.data
								
								if(code===200 && success_type==="update_success"){
									
									
								  document.getElementById('firstname').value = user.firstname;
                                  document.getElementById('lastname').value = user.lastname;
									document.getElementById('user_sex').value=user.sex
									document.getElementById('user_id').value=user.id
									document.getElementById('picture').src = user.picture;
									location.reload();
									alert("更新成功");
									console.log(user.picture);
									this.hidden_loading_form()
								}
								
							
						 }catch(err){
							 
							 if(err.response){
								 
								 const {code, status , message, error_type} = err.response.data;
								 
								 if(status===false && code===500 ){
									 
									 alert(message); 
									 this.hidden_loading_form();
								 }
								 
								 if(status===false && code===400 && error_type==="update_error"){
									 
									 alert(message); 
									 this.hidden_loading_form();
									 
								 }
								 
								 	if(code===422 && error_type==="failed_validated"){
									 
									 alert(Object.values(message).flat().join('\n')); 
									 this.hidden_loading_form();
									 
								 }
							 }else{
								 
								 alert("網路發生問題，請稍後在嘗試");
								  this.hidden_loading_form();
							 }
						 }finally{
							 
							  this.hidden_loading_form();
							  this.hidden_data_check_container();
							  console.log("取消");
						 }
							
						},
						
						async deletePfrofile(){
							
							this.show_loading_form();
							this.hidden_data_cancel_container();
							
							try{
							
                             const id = document.getElementById('delete_id').value;
							
							console.log("有抓到刪除ID"+id);
							
							const res = await axios.delete(`/api/manage_profile_delete/${id}`,{
								
								withCredentials:true,
							});
							
							const {status, code, success_type, message} = res.data;
							
							
							if(status===true && code===200 && success_type==="success_delete"){

								this.show_loading_form();
								alert(message);
								await this.fetchUsers(); 
							}
							
							}catch(err){
								
								if(err.response){
									
									const {status, code, meaage, error_type}=err.response;
										
										switch(error_type){
											
											case 'not_found_user':
											alert(message);


											default:
											alert("發生未知錯誤");
											break;
										}
								    }
								}finally{
									
									this.hidden_loading_form();
									this.hidden_data_cancel_container();
								}
								
							},
	  
	  }
}


</script>