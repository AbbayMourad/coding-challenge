import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../pages/Home.vue')
  },
  {
    path: '/products',
    name: 'products',
    component: () => import('../pages/Products.vue')
  },
  {
    path: '/products/create',
    name: 'products-create',
    component: () => import('../pages/ProductsCreate.vue')
  },
  {
    path: '*',
    component: () => import('../pages/404.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
