<template>
  <div id="app">
   <Nav />
   <main class="page-content">
   <Loading />
	<router-view />
	</main>
	<Footer />
  </div>
</template>

<script>
import '../css/Main.css';
import Nav from './components/nav.vue'
import Loading  from './components/loading.vue'
import Footer  from './components/footer.vue'
export default {
  name: 'App',
  components:{
  Nav,
  Loading,
  Footer,
  }
}
</script>
