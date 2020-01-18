import Vue from 'vue'
import Router from 'vue-router'
import Films from './views/Films.vue'
import Film from './views/Film.vue'
import Profile from './views/Profile.vue'
import About from './views/About.vue'
import Recommended from './views/Recommended.vue'

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
      path: '/profile',
      name: 'profile',
      component: Profile
    },
    {
      path: '/about',
      name: 'about',
      component: About
    },
    {
      path: '/recommended',
      name: 'recommended',
      component: Recommended
    }
  ]
})
