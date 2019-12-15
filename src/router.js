import Vue from 'vue'
import Router from 'vue-router'
import Films from './views/Films.vue'
import Film from './views/Film.vue'
import Account from './views/Account.vue'
import About from './views/About.vue'

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
      path: '/account',
      name: 'account',
      component: Account
    },
    {
      path: '/about',
      name: 'about',
      component: About
    }
  ]
})
