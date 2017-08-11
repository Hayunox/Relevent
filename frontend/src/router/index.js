import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home.vue'
import Register from '@/components/User/Register.vue'
import Login from '@/components/User/Login.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    }
  ]
})
