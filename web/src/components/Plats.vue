<script>
import axios from 'axios';

export default {
  data() {
    return {
      plats: [], // Tableau pour stocker les plats récupérés depuis l'API
    };
  },
  methods: {
    // Méthode pour récupérer les plats depuis l'API
    async getPlat() {
      const token = localStorage.getItem('token');
      try {
        const response = await axios.get(`http://localhost:8000/api/plats`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        console.log(response.data);
        this.plats = response.data; // Mettre à jour le tableau `plats` avec les données de l'API
      } catch (error) {
        console.error("Erreur lors du chargement des plats:", error);
      }
    },

    // Méthode pour supprimer un plat
    async deletePlat(id) {
  const token = localStorage.getItem('token');
  try {
    const response = await axios.delete(`http://localhost:8000/api/plats/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    console.log(response.data.message); // Afficher le message de succès
    this.getPlat(); // Recharger la liste des plats après la suppression
  } catch (error) {
    console.error("Erreur lors de la suppression du plat:", error);
    if (error.response) {
      console.error("Réponse du serveur:", error.response.data);
      console.error("Statut de la réponse:", error.response.status);
    } else if (error.request) {
      console.error("Aucune réponse reçue:", error.request);
    } else {
      console.error("Erreur lors de la configuration de la requête:", error.message);
    }
  }
},
  },
  // Appeler la méthode `getPlat` au chargement du composant
  mounted() {
    this.getPlat();
  },
};
</script>

<template>
  <h1>Liste des plats</h1>
  <router-link :to="'/ajoutPlat'" class="btn-add">+ ajout</router-link>
  <table>
    <thead>
      <tr>
        <th>id</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="plat in plats" :key="plat.id">
        <td>{{ plat.id }}</td>
        <td>{{ plat.nom }}</td>
        <td>{{ plat.prix }}</td>
        <td>
          <router-link :to="'/updatePlat/' + plat.id" class="btn-update">Modifier</router-link>
          <button @click="deletePlat(plat.id)" class="btn-delete">Supprimer</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>
.table-container {
    position: absolute;
    top: 110px;
    left: 200px;
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

.btn-add, .btn-update, .btn-delete {
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.btn-add {
    background-color: #4CAF50;
    color: white;
}

.btn-add:hover {
    background-color: #45a049;
}

.btn-update {
    background-color: #2196F3;
    color: white;
}

.btn-update:hover {
    background-color: #1e88e5;
}

.btn-delete {
    background-color: #f44336;
    color: white;
}

.btn-delete:hover {
    background-color: #e53935;
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