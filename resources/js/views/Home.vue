<template>
  <div  class="template-cover">
    
	<div class="image-container">
	<div class="slide1 active" data-slide></div>
	<div class="slide2" data-slide></div>
	<div class="slide3" data-slide></div>
	<div class="right-bottom" id="right-bottom"><i class="fa-regular fa-circle-right" style="color: #ffffff;"></i></div>
	<div class="left-bottom" id="left-bottom"><i class="fa-regular fa-circle-left" style="color: #ffffff;"></i></div>
	</div>
	



	<div class="map-cover">
	<div class="map">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3614.621535243362!2d121.51284127520641!3d25.046914777808038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a97263b48c71%3A0x7f964669b3bf255e!2z6Ie65YyX6LuK56uZ!5e0!3m2!1szh-TW!2stw!4v1748289443867!5m2!1szh-TW!2stw" width="100%;" height="100%;" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
	
	
	<div class="information">
	<h1>聯絡資訊</h1>
	<div class="information-content">
	<p>地址: </p><a href="https://www.google.com/maps/place/%E8%87%BA%E5%8C%97%E8%BB%8A%E7%AB%99/@25.0469148,121.5128413,17z/data=!4m10!1m2!2m1!1z5Y-w5YyX54Gr6LuK56uZ!3m6!1s0x3442a97263b48c71:0x7f964669b3bf255e!8m2!3d25.0474428!4d121.5170955!15sCg_lj7DljJfngavou4rnq5laEyIR5Y-w5YyXIOeBq-i7iiDnq5mSARdsb2dpY2FsX3RyYW5zaXRfc3RhdGlvbqoBORABMh4QASIaXOmV_0nlbELn0bn74ZX97u5vVFHDQ5luySAyFRACIhHlj7DljJcg54Gr6LuKIOermeABAA!16zL20vMDN0ZzA2?entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D">台北火車站</a>
	</div>
	<div class="information-content">
	<p>電話:</p><a href="tel:0912345678">📞 撥打電話</a>
	</div>
	<div class="information-content">
	<p>營業時間: </p><p><strong>6~24</strong></p>
	</div>
	</div>
	</div>
  </div>
</template>

<script>

import "../../css/Home.css";
export default {
  name: 'Home',
  
  mounted()
   {
		const slides = document.querySelectorAll('[data-slide]');
		
		const nextButton = document.getElementById('right-bottom');
		const preButton = document.getElementById('left-bottom');
		let index=0;
		
		function showslides(n)
		 {
				slides.forEach(slide=> slide.classList.remove('active'));
				slides[n].classList.add('active');
		 }
		 
		 preButton.addEventListener('click', ()=>{
			 
			 index = (index-1+slides.length)% slides.length;
			 showslides(index);
		 });
		 
		 nextButton.addEventListener('click', ()=>{
			 
			 index = (index+1)% slides.length;
			 showslides(index);
		 });
		 
		 setInterval(()=>{
			 
			 index = (index+1)%slides.length;
			 showslides(index);
			 
		 },5000);  //1000一秒
   } 
}
</script>
