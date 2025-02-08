<template>
  <div class="login-container">
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" v-model="email" required />
      </div>

      <div class="input-group">
        <label for="password">Mot de passe</label>
        <input type="password" v-model="password" required />
      </div>

      <button type="submit">Se connecter</button>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    async login() {
      // const fakeUser = { email: "admin@example.com", password: "123456" };

      try {

        const response = await axios.post('http://localhost:8000/api/admins/login', 
          {email: this.email,mdp: this.password},
          { headers: { "Authorization": `Bearer ${localStorage.getItem("token")}` } }
          
        );
        if (response.data.token) {
          console.log("resussit");

          localStorage.setItem("token", response.data.token);
          console.log("this.$router",this.$router);
          console.log("Token enregistré :", localStorage.getItem("token"));

          this.$router.push("/acceuil");
        } else {

          this.errorMessage = response.data.message || "Email ou mot de passe incorrect.";
        }
      } catch (error) {
        console.error("Erreur lors de la connexion :", error);
        this.errorMessage = "Erreur lors de la connexion.";
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background: #f8f8f8;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

h2 {
  text-align: center;
  color: #333;
}

.input-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-weight: bold;
}

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  width: 100%;
  padding: 10px;
  background: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background: #218838;
}

.error {
  color: red;
  text-align: center;
}
</style>
