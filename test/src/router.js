import { createRouter, createWebHistory } from 'vue-router';
import Liste1 from './components/Liste1.vue';
import Acceuil from './components/Acceuil.vue';

const routes = [
  { path: '/liste1', component: Liste1 },
  { path: '/acceuil', component: Acceuil },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
