<script>
import axios from 'axios';
export default {
    data() {
    return {
      client: [],
    };
  },
  async created() {
    const token = localStorage.getItem('token');
    try {
      const response = await axios.get("http://localhost:8000/api/client/commande",{
        headers: {
          'Authorization': `Bearer ${token}`}
        });
      console.log(response.data);
      this.client = response.data;
    }catch(error){
      console.error("Erreur lors du chargement des ingrédients:", error);
    }
  }
}
</script>
<template>
    
    <div class="table-container"> 
        <h1>Liste client</h1> 
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Nom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr  v-for="clients in client" :key="clients.id">
                <th>{{ clients.id }}</th>
                <th>{{ clients.nom }}</th>
                <th>{{ clients.email }}</th>
            </tr>
        </tbody>
    </table> 
</div> 
</template>
<style scoped>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    color: #333;
    margin-top: 20px;
}

.table-container {
    width: 85%; /* Augmenté à 90% */
    margin: 20px ;
    margin-left: auto ;
    overflow-x: auto;
}

table {
    width: 100%; /* Le tableau occupe toute la largeur du conteneur */
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f8f8;
    font-weight: bold;
    color: #333;
}

tr:hover {
    background-color: #f1f1f1;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

@media (max-width: 768px) {
    .table-container {
        width: 95%; /* Ajusté pour les petits écrans */
    }

    th, td {
        padding: 8px 10px;
    }
}
</style>