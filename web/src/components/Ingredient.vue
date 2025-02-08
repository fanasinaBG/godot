<script>
    import axios from 'axios';
    export default {
  name: 'Ingredient', 
  data() {
    return {
      ingredients: []
    };
  },
  async created() {
    const token = localStorage.getItem('token');
    try {
      const response = await axios.get("http://localhost:8000/api/ingredients",{
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
      this.ingredients = response.data;
    }catch(error){
      console.error("Erreur lors du chargement des ingrédients:", error);
    }
  }
};
</script>
<template>
    <div class="table-container">
       <h1>tableau</h1>
     <table>
       <thead>
         <tr>
           <th>ID</th>
           <th>nom</th>
           <th>action</th>
         </tr>
       </thead>
       <tbody>
         <tr v-for="ingredient in ingredients" :key="ingredient.id">
           <td>{{ ingredient.id }}</td>
           <td>{{ ingredient.nom }}</td>
           <td>
            <router-link :to="'/ingredient/' + ingredient.id">+ ajout</router-link>
        </td>
         </tr>
       </tbody>
     </table>
   </div>
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