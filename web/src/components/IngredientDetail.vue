<template>
    <!-- <div class="ingredient-detail">
      <!-- <h1>Détails de l'ingredient</h1>
      <div v-if="ingredient">
        <p>ID: {{ ingredient.id }}</p>
        <p>Nom: {{ ingredient.nom }}</p>
        <!-- Ajoutez plus de détails si nécessaire -->
      <!-- </div> -->
      <!-- <div v-else> -->
        <!-- <p>Chargement...</p> -->
      <!-- </div> --> -->
    <!-- </div> --> -->

    <div class="login-container">
    <h2>entrer le quantiter</h2>
    <form @submit.prevent="enregistrer">
      <div class="input-group">
        <label for="entrer">entrer</label>
        <input type="number" v-model="entrer" required />
      </div>
      <button type="submit">Valider</button>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </form>
  </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        ingredient: null,  
        entrer: 0,
        message:"",
      };
    },
    async created() {
      const id = this.$route.params.id; 
      const token = localStorage.getItem('token');
      try {
        const response = await axios.get(`http://localhost:8000/api/ingredients/${id}`, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
        this.ingredient = response.data;  // Stocke l'ingredient récupéré dans la donnée
      } catch (error) {
        console.error("Erreur lors du chargement de l'ingredient:", error);
      }
    },
    methods: {
    async enregistrer() {
      if (!this.ingredient || this.entre <= 0) {
        this.message = "Veuillez saisir une quantité valide.";
        return;
      }

      const token = localStorage.getItem('token');

      try {
        const response = await axios.post(
          "http://localhost:8000/api/stocks/entre",
          { idIngredient: this.ingredient.id, entre: this.entrer },
          { headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' } }
        );

        this.message = response.data.message;
        this.entrer = 0; // Réinitialiser le champ après succès
        this.$router.push('/acceuil');
      } catch (error) {
        this.message = "Erreur lors de l'ajout du stock.";
        console.error(error);
      }
     }
    }
  };
  </script>

<style scoped>
/* Conteneur principal centré */
.login-container {
  max-width: 400px;
  margin: 0 auto; /* Centrage horizontal */
  padding: 40px;
  background: #ffffff;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: absolute; /* Pour centrer verticalement */
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); /* Centrage parfait */
}

/* Effet de survol sur le conteneur */
.login-container:hover {
  transform: translate(-50%, -52%); /* Légère élévation */
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* Titre du formulaire */
h2 {
  text-align: center;
  color: #333;
  font-size: 28px;
  margin-bottom: 25px;
  font-weight: 700;
  letter-spacing: -0.5px;
}

/* Groupe de champs de saisie */
.input-group {
  margin-bottom: 20px;
}

/* Labels des champs */
label {
  display: block;
  font-weight: 600;
  margin-bottom: 8px;
  color: #555;
  font-size: 14px;
}

/* Champs de saisie */
input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Effet de focus sur les champs */
input:focus {
  border-color: #28a745;
  box-shadow: 0 0 8px rgba(40, 167, 69, 0.2);
  outline: none;
}

/* Bouton de connexion */
button {
  width: 100%;
  padding: 14px;
  background: #28a745;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Effet de survol sur le bouton */
button:hover {
  background: #218838;
  transform: translateY(-2px);
}

/* Effet de clic sur le bouton */
button:active {
  transform: translateY(0);
}

/* Message d'erreur */
.error {
  color: #dc3545;
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
  font-weight: 500;
  animation: fadeIn 0.5s ease-in-out;
}

/* Animation pour le message d'erreur */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Fond de la page (optionnel) */
body {
  background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
  height: 100vh;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
  