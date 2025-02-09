<script>
import axios from 'axios';
import Liste1 from './Liste1.vue';
import Ingredient from './Ingredient.vue';
import IngredientListe from './IngredientListe.vue';
export default {
  name: 'Liste1',// Nom du composant
  data() {
    return {
      ingredients: [],
      showListe1: false,
      showListe2: false,
    };
  },
  components: { // Enregistrement du composant ici
    Ingredient,
    IngredientListe,
  },
  methods: {
      toggleListe1() {
        this.showListe1 = !this.showListe1;
        console.log(this.showListe1); // Pour vérifier l'état
      },
      toggleListe2() {
        this.$router.push('/ingredientListe'); // Pour vérifier l'état
      },
    },
  async created() {
    const token = localStorage.getItem('token');
    try {
      const response = await axios.get("http://localhost:8000/api/stocks/all",{
        headers: {
          'Authorization': `Bearer ${token}`}
        });
      console.log(response.data);
      this.ingredients = response.data;
    }catch(error){
      console.error("Erreur lors du chargement des ingrédients:", error);
    }
  },
};
</script>

<template>
     <div class="table-container">
        <h1>tableau</h1>
        <li @click="toggleListe1">
          <a href="#"> ajout entrer ingredients</a> 
        </li>

        <li @click="toggleListe2">
          <a href="#"> ajout ingredients</a> 
        </li>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>entre</th>
            <th>sortie</th>
            <th>nom</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ingredient in ingredients" :key="ingredient.id">
            <td>{{ ingredient.id }}</td>
            <td>{{ ingredient.Entre }}</td>
            <td>{{ ingredient.Sortie }}</td>
            <td>{{ ingredient.ingredient.nom }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <Ingredient v-if="showListe1" />
</template>

<style scoped>
.table-container {
    position: absolute;
    top: 110px; /* Ajuste la position sous la barre de recherche */
    left: 200px; /* Aligné avec la liste */
    width: calc(100% - 220px);
    padding: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    overflow: hidden;
  }
  
  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  th {
    background-color: #333;
    color: white;
  }
  
  tr:hover {
    background-color: #f5f5f5;
  }
  @media (max-width: 768px) {
  .table-container {
      left: 0;
      width: 100%;
      padding: 10px;
    }
}

@media (max-width: 1024px) {
.table-container {
      left: 160px;
      width: calc(100% - 180px);
    }
}
@media (max-width: 480px) {
    .table-container {
      width: 100%;
      left: 0;
      padding: 5px;
    }
  
    th, td {
      padding: 8px;
    }
}
</style>