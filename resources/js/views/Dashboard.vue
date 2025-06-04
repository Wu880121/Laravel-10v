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
<input type="text" data-dashboard-input id="search-input">
<label for="search-input">
<img src="/public/images/search.png"  style="width:40px; height:40px;" id="data-dashboard-image">
</label>
</div>

<div data-member-info>

<div data-info>
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

<div data-info>
</div>

<div data-info>
</div>

<div data-info>
</div>

<div data-info>
</div>

<div data-info>
</div>

<div data-info>
</div>

</div>

<div data-number-bar>
	<div data-number>
	<ul data-number-ul>
	<li data-number-li><i class="fa-regular fa-square-caret-left"></i></li>
	<li data-number-li>2</li>
	<li data-number-li>3</li>
	<li data-number-li>3</li>
	<li data-number-li>3</li>
	<li data-number-li><i class="fa-regular fa-square-caret-right"></i></li>
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
	
	<form  id="profile-form" @submit.prevent="handleSubmit"  data-form>
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
	
	
	
	
	<div data-button-row class="button-row" id="button-row">
	<button @click='show_data_check_container' type="button"   id="update_button" data-button>更改資料</button>
	<button  type="button "@click="hidden_profile_container" data-button>確認</button>
	</div>
  
	    </form>
   </div>
			
	<div id="data-check-container" class="hidden" data-check-container>
	<lable  data-check-container-label>確定要更新嗎?</lable>
	<img src="/public/images/exclamation-mark.png" atl="提醒" style="width:70px; height:70px;"> 
	<div data-check-button>
	<button type="submit" data-button-click>確定</button>
	<button @click="hidden_data_check_container"  type="button" data-button-click>取消</button>
	</div>
  </div>
  
    <div id="data-cancel-container" class="hidden" data-check-container>
	<lable  data-check-container-label>確定要刪除嗎?</lable>
	<img src="/public/images/exclamation-mark.png" atl="提醒" style="width:70px; height:70px;"> 
	<div data-check-button>
	<button type="button" @click="deleteProfile"  data-button-click>確定</button>
	<button type="button" @click="hidden_data_cancel_container"  data-button-click>取消</button>
	</div>
  </div>
			
</div>

</template>

<script>

import '../../css/Dashboard.css';
import {onMounted} from 'vue';

export default{

	name:'dashboard',
	
      mounted(){
		
			this.show_data_mobile_nav();
      },

      methods:{

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
					
				}

      },
	
}


</script>