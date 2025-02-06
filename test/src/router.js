import { createRouter, createWebHistory } from 'vue-router';
import Liste1 from './components/Liste1.vue';
import Acceuil from './components/Acceuil.vue';
import Login from './components/Login.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/liste1', component: Liste1 },
  { path: '/acceuil', component: Acceuil, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem("isAuthenticated");
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/login"); // Redirige vers la page de connexion si non authentifié
  } else {
    next(); // Autorise la navigation
  }
});

export default router;
