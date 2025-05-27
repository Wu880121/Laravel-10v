import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Profile from '../views/Profile.vue'
import Dashboard from '../views/Dashboard.vue'
import RegisterVerificationSuccess from '../views/RegisterVerificationSuccess.vue'
import ResendRegisterVerification from '../views/ResendRegisterVerification.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/login',name:'Login', component: Login },
  { path:'/register', name:'Register' , component: Register},
  { path:'/profile', name:'Profile', component:Profile},
  { path:'/dashboard', name:'Dashboard', component:Dashboard},
  { path:'/register_verify_success', name:'RegisterVerificationSuccess', component:RegisterVerificationSuccess},
  { path:'/resend_register_verification', name:'ResendRegisterVerification', component:ResendRegisterVerification}
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
