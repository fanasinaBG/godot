import { createRouter, createWebHistory } from 'vue-router';
import Liste1 from './components/Liste1.vue';
import Acceuil from './components/Acceuil.vue';
import Login from './components/Login.vue';
import Ingredient from './components/Ingredient.vue';
import IngredientDetail from './components/IngredientDetail.vue';
import Plats from './components/Plats.vue';
import AjoutPlat from './components/AjoutPlat.vue';
import UpdatePlat from './components/UpdatePlat.vue';

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/acceuil', component: Acceuil,children: [
    { path: '', component: Liste1  },
    { path: '/ingredient', component: Ingredient  },
    { path: '/ingredient/:id', component: IngredientDetail, name: 'ingredientDetail' },
    { path: '/plats', component: Plats  },
    { path: '/ajoutPlat', component: AjoutPlat },
    { path: '/updatePlat/:id', component: UpdatePlat, name: 'updatePlat' },
  ]},

  { path: '/login', component: Login },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem("token");

  console.log("isAuthenticated:", isAuthenticated);
  console.log("Navigating to:", to.path);

  if (to.path === "/acceuil" && !isAuthenticated) {
    console.log("Redirection vers /login");
    next("/"); // 
  } else {
    console.log("navigation autorisez");
    next(); //
  }
});



export default router;
