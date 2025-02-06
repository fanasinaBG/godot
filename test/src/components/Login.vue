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
  export default {
    data() {
      return {
        email: "",
        password: "",
        errorMessage: "",
      };
    },
    methods: {
      login() {
        const fakeUser = { email: "admin@example.com", password: "123456" };
        
        
    //     const fakeUser = { email: "admin@example.com", password: "123456" };
  
       if (this.email === fakeUser.email && this.password === fakeUser.password) {
          localStorage.setItem("isAuthenticated", "true");
          this.$router.push("/acceuil"); // Redirige vers une page après connexion
        } else {
          this.errorMessage = "Email ou mot de passe incorrect.";
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
  