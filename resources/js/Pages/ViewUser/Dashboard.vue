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
              href="/home"
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
              href="/place"
              :class="{ active: $page.url.startsWith('/place') }"
              preserve-state
              preserve-scroll
              prefetch
            >
              Mis Lugares
            </Link>
          </li>
          <li>
            <Link
              href="/transporte"
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
              href="/mapa"
              :class="{ active: $page.url.startsWith('/mapa') }"
              preserve-state
              preserve-scroll
              prefetch
            >
              Mapa Interactivo
            </Link>
          </li>

          <!-- Solo para propietarios -->
          <li v-if="$page.props.auth.user && $page.props.auth.user.role === 'host'">
            <Link href="/my-hosting">Mi Hospedaje</Link>
          </li>
        </ul>
      </nav>
    </section>

    <!-- Íconos a la derecha -->
    <div class="icons relative">
      <font-awesome-icon :icon="faBell" class="mr-4" />

      <!-- Ícono de usuario -->
      <div @click.stop="toggleDropdown" class="cursor-pointer relative">
        <font-awesome-icon :icon="faUserCircle" />

        <!-- Dropdown -->
        <div
          v-if="isDropdownOpen"
          class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-50"
        >
          <button
            @click.prevent="logout"
            class="w-full text-left px-4 py-2 hover:bg-gray-100"
          >
            Cerrar sesión
          </button>
        </div>
      </div>
    </div>

    <!-- Botón hamburguesa (solo en móvil) -->
    <button class="menu-toggle" @click="toggleMenu">
      <font-awesome-icon :icon="isMenuOpen ? faTimes : faBars" />
    </button>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faBars, faTimes, faBell, faUserCircle } from "@fortawesome/free-solid-svg-icons";
import logo from "../Multimedia/Recurso 3.png";

const isMenuOpen = ref(false);
const isDropdownOpen = ref(false);

const toggleMenu = () => { isMenuOpen.value = !isMenuOpen.value; };
const toggleDropdown = () => { isDropdownOpen.value = !isDropdownOpen.value; };

const logout = () => {
  Inertia.post('/logout'); // ❌ Rutas normales
};

const handleClickOutside = (e) => {
  const dropdown = document.querySelector(".icons .relative");
  if (dropdown && !dropdown.contains(e.target)) isDropdownOpen.value = false;
};

onMounted(() => document.addEventListener("click", handleClickOutside));
onBeforeUnmount(() => document.removeEventListener("click", handleClickOutside));
</script>
