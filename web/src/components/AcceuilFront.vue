<template>
    <nav class="navbar">
      <div class="navbar-brand">Mon Site</div>
    
    </nav>
  
    <div class="fixed-list">
      <ul>
        <li @click="toggleListe1"><a href="#">liste des clients</a></li>
        <li @click="togglePlat"><a href="#">commandes en cours</a></li>
      </ul>
    </div>
  
    <div class="search-navbar">
      <input type="text" placeholder="Rechercher..." class="search-input">
    </div>
  
    <!-- RouterView pour afficher les composants en fonction de la route -->
    <router-view />
  </template>
  
  <script>
  import { useRoute } from 'vue-router';
  
  export default {
    data() {
      return {
        showListe1: false,
        showPlat: false,
      };
    },
    methods: {
      // Toggle pour afficher/masquer Liste1
      toggleListe1() {
        this.showListe1 = !this.showListe1;
        this.showPlat = false; // Masquer Plats si on affiche Liste1
        if (this.showListe1) {
          this.$router.push('/acceuilFront'); // Naviguer vers la route /ingredient
        }
      },
      // Toggle pour afficher/masquer Plats
      togglePlat() {
        this.showPlat = !this.showPlat;
        this.showListe1 = false; // Masquer Liste1 si on affiche Plats
        if (this.showPlat) {
          this.$router.push('/Commande'); // Naviguer vers la route /plats
        }
      },
      // Gérer le changement de route et ajuster l'affichage de Liste1 et Plats
      handleRouteChange() {
        const route = this.$route;
        this.showListe1 = route.path.startsWith('/listeClient');
        this.showPlat = route.path.startsWith('/Commande');
      }
    },
    watch: {
      // Regarder les changements de route pour ajuster l'affichage
      '$route': 'handleRouteChange'
    },
    mounted() {
      // Appel de la méthode handleRouteChange au montage du composant
      this.handleRouteChange();
    }
  };
  </script>
  
    
    <style scoped>
    /* NAVBAR PRINCIPAL */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #333;
      padding: 10px 20px;
      z-index: 1000;
    }
    
    /* STYLE DE LA MARQUE */
    .navbar-brand {
      color: white;
      font-size: 1.5rem;
    }
    
    /* MENU PRINCIPAL */
    .navbar-menu {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
    }
    
    .navbar-item {
      margin-left: 20px;
    }
    
    .navbar-item a {
      color: white;
      text-decoration: none;
      font-size: 1rem;
    }
    
    /* LISTE FIXE À GAUCHE */
    .fixed-list {
      position: fixed;
      top: 57px;
      bottom: 0;
      left: 0;
      background-color: #444;
      width: 200px;
      border-top-right-radius: 5px;
      padding-top: 10px;
      transition: width 0.3s ease;
    }
    
    .fixed-list ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .fixed-list li {
      padding: 10px;
    }
    
    .fixed-list a {
      color: white;
      text-decoration: none;
      font-size: 1rem;
      display: block;
    }
    
    .fixed-list a:hover {
      background-color: #555;
    }
    
    /* MINI-NAVBAR AVEC RECHERCHE */
    .search-navbar {
      position: fixed;
      top: 57px; /* Juste sous le navbar principal */
      left: 200px; /* Aligné à droite de la liste fixe */
      width: calc(100% - 200px);
      background-color: #222;
      padding: 10px;
      display: flex;
      justify-content: flex-end;
      transition: all 0.3s ease;
    }
    
    .search-input {
      width: 250px;
      padding: 7px;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      outline: none;
      margin-top: 5px;
    }
    
    /* TABLEAU SOUS LE SEARCH NAVBAR */
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
    
    /* RESPONSIVE */
    @media (max-width: 1024px) {
      .fixed-list {
        width: 160px; /* Réduction de la liste sur tablette */
      }
    
      .search-navbar {
        left: 160px;
        width: calc(100% - 160px);
      }
    
      .table-container {
        left: 160px;
        width: calc(100% - 180px);
      }
    }
    
    @media (max-width: 768px) {
      .navbar {
        padding: 10px;
      }
    
      .fixed-list {
        width: 130px; /* Encore plus réduit sur mobile */
      }
    
      .fixed-list li {
        padding: 8px;
      }
    
      .fixed-list a {
        font-size: 0.9rem;
      }
    
      .search-navbar {
        left: 0;
        width: 100%;
        justify-content: center;
        padding: 10px;
      }
    
      .search-input {
        width: 90%;
        max-width: 300px;
      }
    
      .table-container {
        left: 0;
        width: 100%;
        padding: 10px;
      }
    }
    
    @media (max-width: 480px) {
      .fixed-list {
        display: none; /* Cache la liste sur très petits écrans */
      }
    
      .search-navbar {
        width: 100%;
        left: 0;
        justify-content: center;
      }
    
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
    