import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '../views/Login.vue'
import Contatos from '../views/Contatos.vue'
import CriarContato from '../views/CriarContato.vue'
import RecuperarSenha from '../views/RecuperarSenha.vue'
import Token from '../views/Token.vue'
import { requireAuth } from '../middleware/auth.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/token',
      name: 'Token',
      component: Token
    },
    {
      path: '/criarcontato',
      name: 'CriarContato',
      component: CriarContato
    },
    {
      path: '/contatos',
      name: 'Contatos',
      component: Contatos,
      beforeEnter: requireAuth
    },
    {
      path: '/recuperar-senha',
      name: 'RecuperarSenha',
      component: RecuperarSenha
    },
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
  ],
})

export default router
