<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light full-width">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img :src="logoSrc" class="logo" alt="Bootstrap Logo">
            </a>

            <!-- Bouton menu burger (mobile) -->
            <button class="navbar-toggler" type="button" @click="toggleMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenu du menu -->
            <div class="collapse navbar-collapse custom-menu" :class="{ show: isOpen }">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
            logoSrc: "../assets/cuisine.jpg", // Remplace avec ton chemin d'image
        };
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },
    },
};
</script>

<style scoped>
/* Supprime les marges et assure un affichage pleine largeur */
.full-width {
    width: 100%;
    margin: 0;
    padding: 0;
}

/* Permet à la navbar d'occuper toute la largeur */
.navbar {
    width: 100%;
    padding: 0;
}

/* Supprime les marges par défaut de .container-fluid */
.container-fluid {
    width: 100%;
    padding: 0 15px; /* Ajoute un léger padding pour éviter que le menu touche les bords */
}

/* Ajuste la taille du logo */
.logo {
    width: 70px; /* Taille plus grande pour desktop */
    height: auto;
}

/* Assure que le menu occupe toute la largeur */
.custom-menu {
    width: 100%;
}

/* Ajuste le menu et centre en mode mobile */
.navbar-nav {
    width: 100%;
    display: flex;
    justify-content: flex-end;
}

/* Responsive : ajustement du logo et du menu */
@media (max-width: 992px) {
    .logo {
        width: 60px; /* Réduit la taille du logo sur tablette */
    }

    .navbar-nav {
        text-align: center;
        width: 100%;
    }
}

@media (max-width: 768px) {
    .logo {
        width: 50px; /* Encore plus petit sur mobile */
    }

    .navbar {
        text-align: center;
    }

    .navbar-nav {
        flex-direction: column; /* Affichage vertical du menu */
        align-items: center;
    }
}
</style>
