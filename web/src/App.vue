<script >
import Acceuil from './components/Acceuil.vue'
import Login from './components/Login.vue'

export default {
  components: {
    Acceuil,
    Login,
  },
};
</script>

<template>
  <div class="container">
    <header>
    </header>
    <router-view />

    <main>
    </main>
  </div>
</template>

<style scoped>

</style>
