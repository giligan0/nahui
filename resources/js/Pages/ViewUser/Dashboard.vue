<template>
    <header class="header">
        <!-- Logo -->
        <section class="section_header">
            <div class="logo">
                <img :src="logo" alt="Logo" class="img_logo" />
            </div>

            <!-- Menú de navegación -->
            <nav class="nav" :class="{ open: isMenuOpen }">
                <ul>
                    <li>
                        <Link
                            :href="route('home')"
                            :class="{ active: $page.url.startsWith('/home') }"
                            preserve-state
                            preserve-scroll
                            prefetch
                        >
                            Inicio
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('place')"
                            :class="{ active: $page.url.startsWith('/place') }"
                            preserve-state
                            preserve-scroll
                            prefetch
                        >
                            Lugares
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('transporte')"
                            :class="{ active: $page.url.startsWith('/transporte') }"
                            preserve-state
                            preserve-scroll
                            prefetch
                        >
                            Transporte
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('mapa')"
                            :class="{ active: $page.url.startsWith('/mapa') }"
                            preserve-state
                            preserve-scroll
                            prefetch
                        >
                            Mapa Interactivo
                        </Link>
                    </li>
                </ul>
            </nav>
        </section>

        <!-- Íconos a la derecha -->
        <div class="icons">
            <font-awesome-icon icon="bell" />
            <font-awesome-icon icon="user-circle" />
        </div>

        <!-- Botón hamburguesa (solo en móvil) -->
        <button class="menu-toggle" @click="toggleMenu">
            <font-awesome-icon :icon="isMenuOpen ? 'times' : 'bars'" />
        </button>
    </header>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";



import {
    faBars,
    faTimes,
    faBell,
    faUserCircle,
} from "@fortawesome/free-solid-svg-icons";
import logo from "../Multimedia/Recurso 3.png";

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>
