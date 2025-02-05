<script setup>
import HelloWorld from './components/HelloWorld.vue'
import Acceuil from './components/Acceuil.vue'
</script>

<template>
  <div class="container">
    <header>
      <!-- Tu peux mettre ici du contenu pour le header si nécessaire -->
    </header>

    <!-- Affichage du composant Acceuil -->
    <Acceuil />

    <main>
      <!-- Ton contenu principal ici -->
    </main>
  </div>
</template>

<style scoped>
/* S'assure que tout occupe 100% de la largeur */
.container {
  width: 100%;
  margin: 0;
  padding: 0;
}

header, main {
  width: 100%; /* Assure que le header et le main occupent toute la largeur */
  padding: 0;
  margin: 0;
}
</style>
