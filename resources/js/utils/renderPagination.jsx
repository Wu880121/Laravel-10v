export function renderPagination({ currentPage, totalPages }){
	
	
	const pagination = document.getElementById('data-number-ul');
	
	pagination.innerHTML = " ";
	
	let html = ' ';
	
	const maxVisible =  6;
	
	const half = Math.floor(maxVisible/2);   //floor等於無條件捨去
	
	let start = Math.max(1, currentPage-half);
	
	let end = Math.min(totalPages, currentPage+half);
	
	if ( currentPage-half <= half){
	
	end = Math.min(totalPages, maxVisible);
}

   if(currentPage+half > totalPages){
	   
	   start = totalPages - maxVisible + 1;
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
			   
			   fetchUsers(page); // ✅ 外部函式
		   }
	   });
   });
   
}