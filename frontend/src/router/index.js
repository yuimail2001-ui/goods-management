import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
    {
      path: '/tours',
      name: 'tours',
      component: () => import('../views/TourListView.vue'),
    },
    {
      path: '/tours/manage',
      name: 'goods-form',
      component: () => import('../views/GoodsFormView.vue'),
    },
    {
      path: '/goods/:id/edit',
      name: 'goods-edit',
      component: () => import('../views/GoodsFormView.vue'),
    },
    {
      path: '/tours/:id',
      name: 'tour-detail',
      component: () => import('../views/TourDetailView.vue'),
    },
  ],
})

export default router
