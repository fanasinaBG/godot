import { createRouter, createWebHistory } from 'vue-router';
import Liste1 from './components/Liste1.vue';
import Acceuil from './components/Acceuil.vue';
import Login from './components/Login.vue';
import Ingredient from './components/Ingredient.vue';
import IngredientDetail from './components/IngredientDetail.vue';
import Plats from './components/Plats.vue';
import AjoutPlat from './components/AjoutPlat.vue';
import UpdatePlat from './components/UpdatePlat.vue';
import IngredientListe from './components/IngredientListe.vue';
import LogFront from './components/LogFront.vue';
import AcceuilFront from './components/AcceuilFront.vue';
import ListeClient from './components/ListeClient.vue';
import Commande from './components/Commande.vue';
import Statistique from './components/Statistique.vue';




const routes = [
  { path: '/', redirect: '/logFront' },
  { path: '/acceuil', component: Acceuil,children: [
    { path: '', component: Liste1  },
    { path: '/ingredient', component: Ingredient  },
    { path: '/ingredient/:id', component: IngredientDetail, name: 'ingredientDetail' },
    { path: '/plats', component: Plats  },
    { path: '/ajoutPlat', component: AjoutPlat },
    { path: '/updatePlat/:id', component: UpdatePlat, name: 'updatePlat' },
    { path: '/ingredientListe', component: IngredientListe },
    { path: '/statistique', component: Statistique },
  ]},
  { path: '/acceuilFront', component: AcceuilFront,children: [
    { path: '', component: ListeClient  },
    { path: '/Commande', component: Commande },
   ]},
  { path: '/login', component: Login },
  { path: '/listeClient', component: ListeClient },
  { path: '/logFront', component: LogFront },
  

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
