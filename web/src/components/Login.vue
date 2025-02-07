<template>
    <div class="login-container">
      <h2>Connexion</h2>
      <form @submit.prevent="login">
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" autocomplete="email" required />
        </div>

        <div class="input-group">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" v-model="password" autocomplete="current-password" required />
        </div>
        <button type="submit">Se connecter</button>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      </form>
    </div>
  </template>
  
  <script>
  import apiService from './../services/apiService';
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
        try {
          const response = await apiService.login(this.email, this.password);
          this.token = response.data.token;
          console.log(response.data);
          console.log(`Navigating to: ${to.path}, Authenticated: ${!!token}`);
          this.$router.push('/acceuil');
          localStorage.setItem('token', this.token);
          if (to.meta.requiresAuth && !token) {
            next("/login"); // Redirection si non authentifié
          } else {
            next(); // Autorise la navigation
          }
        } catch (error) {
          console.error('Erreur lors de la connexion :', error);
          this.errorMessage = 'Email ou mot de passe incorrect.';
        }
      }
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
  