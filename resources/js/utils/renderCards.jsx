export  function renderCards(users){
	
	console.log('✅ renderCards 進來了', users);
	const container = document.getElementById('data-member-info');
	
	container.innerHTML=" ";
	
	
	users.forEach(user =>{
		
		const html = `
		<div  data-info>
		<label data-info-label>會員資料</label>
        <img src= '${user.picture}' style="width:40px; height:40px;">
        <div>姓名: ${user.name}</div>
        <div>性別: ${user.sex}</div>
        <div data-dashboard-button-area>
        <input type="hidden" data-id= ${user.id}>
        <button type="button" @click="show_profile_container" data-dashboard-button>編輯</button>
        <button type="button" @click="show_data_cancel_container" data-dashboard-button>刪除</button>
        </div>	
		</div>
	`;
		
		container.insertAdjacentHTML('beforeend', html);
		
	});
}