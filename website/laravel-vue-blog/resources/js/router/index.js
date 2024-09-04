import { createWebHistory,  createRouter} from "vue-router";
import DefaultLayout from '@/layouts/default.vue'
import Home from '@/views/home.vue'

export default createRouter({
  history: createWebHistory(),
  linkActiveClass:'active',
  linkExactActiveClass: 'active',
  routes: [
    {
      path: '/',
      name: 'default',
      component: DefaultLayout,
      children: [
        {
          path: '/',
          name: 'home',
          component: Home,
          meta: {title:'Home'}
        },
      ]
    },
    {
      path: '/:catchAll(.*)',
      name: 'notfound',
      component: () => import('@/views/notfound.vue')
    }
  ]
})