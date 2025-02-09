<script>
  import axios from 'axios';
  export default {
    data() {
      return {
        nom:"",
      };
    },
    methods: {
        async insert() {
            const token = localStorage.getItem('token');
            try {
                const response = await axios.post(
                "http://localhost:8000/api/ingredients",
                { nom: this.nom},
                { headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' } }
                );

               this.message = response.data.message;
               this.$router.push('/ingredient');
            } catch (error) {
                this.message = "Erreur lors de l'ajout du stock.";
                console.error(error);  
            }
        }
    }
}
</script>
<template>
    <h1>hello</h1>
    <form @submit.prevent="insert">
      <div class="input-group">
        <label for="nom">nom</label>
        <input type="text" v-model="nom" required />
      </div>
      <button type="submit">Valider</button>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </form>
</template>
<style>
</style>