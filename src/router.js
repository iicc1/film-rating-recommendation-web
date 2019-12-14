import Vue from 'vue'
import Router from 'vue-router'
import Films from './views/Films.vue'
import Film from './views/Film.vue'
import Login from './views/Login.vue'
import Account from './views/Account.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'films',
      component: Films
    },
    {
      path: '/film',
      name: 'film',
      component: Film
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/account',
      name: 'account',
      component: Account
    }
  ]
})
