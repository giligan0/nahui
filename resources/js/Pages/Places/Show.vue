<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";

import Dashboard from "../ViewUser/Dashboard.vue";
Dashboard

const route = useRoute();
const alojamiento = ref(null);

onMounted(async () => {
  try {
    const { data } = await axios.get(`/api/alojamientos/${route.params.id}`);
    alojamiento.value = data;
  } catch (error) {
    console.error("Error al cargar alojamiento:", error);
  }
});
</script>

<template>
    <Dashboard />
  <section v-if="alojamiento" class="publicar-container">
    <h2 class="place_title">{{ alojamiento.nombre }}</h2>

    <!-- Información básica -->
    <div class="section">
      <h3 class="sub_title tittle">Información básica</h3>
      <p><strong>Categoría:</strong> {{ alojamiento.categoria }}</p>
      <p>{{ alojamiento.descripcion }}</p>
    </div>

    <!-- Ubicación -->
    <div class="section">
      <h3 class="sub_title tittle">Ubicación</h3>
      <p><strong>Coordenadas:</strong> {{ alojamiento.coordenadas }}</p>
      <div class="mapa">[Mapa aquí]</div>
    </div>

    <!-- Características -->
    <div class="section">
      <h3 class="sub_title tittle">Características</h3>
      <p><strong>Servicios:</strong> {{ alojamiento.servicios }}</p>
      <p><strong>Habitaciones:</strong> {{ alojamiento.habitaciones }}</p>
      <p><strong>Capacidad:</strong> {{ alojamiento.capacidad }}</p>
    </div>

    <!-- Reglas -->
    <div class="section">
      <h3 class="sub_title tittle">Reglas</h3>
      <p>{{ alojamiento.reglas }}</p>
    </div>

    <!-- Imágenes -->
    <div class="mi-contenedor-existente" v-if="alojamiento.imagenes?.length">
      <div class="carousel">
        <div class="carousel-track">
          <div class="carousel-item" v-for="(img, i) in alojamiento.imagenes" :key="i">
            <img :src="img" alt="Imagen" />
          </div>
        </div>
      </div>
    </div>

    <!-- Precios -->
    <div class="section">
      <h3>Precios</h3>
      <p><strong>Precio por noche:</strong> ${{ alojamiento.precio }}</p>
      <p><strong>Promoción:</strong> {{ alojamiento.promocion }}</p>
    </div>
  </section>

  <div v-else>Cargando...</div>
</template>
