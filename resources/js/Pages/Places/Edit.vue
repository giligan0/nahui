<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import AlojamientoForm from "./AlojamientoForm.vue";
import axios from "axios";

import Dashboard from "../ViewUser/Dashboard.vue";
Dashboard

const route = useRoute();
const router = useRouter();
const alojamiento = ref(null);

onMounted(async () => {
  try {
    const { data } = await axios.get(`/api/alojamientos/${route.params.id}`);
    alojamiento.value = data;
  } catch (error) {
    console.error("Error al cargar alojamiento:", error);
  }
});

const updateAlojamiento = async (data) => {
  try {
    const formData = new FormData();
    for (const key in data) {
      if (key === "imagenes") {
        data.imagenes.forEach((file, i) => {
          formData.append(`imagenes[${i}]`, file);
        });
      } else {
        formData.append(key, data[key]);
      }
    }

    await axios.post(`/api/alojamientos/${route.params.id}?_method=PUT`, formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    alert("Alojamiento actualizado con éxito");
    router.push({ name: "alojamientos.index" });
  } catch (error) {
    console.error("Error al actualizar alojamiento:", error);
  }
};
</script>

<template>
    <Dashboard />

  <div v-if="alojamiento">
    <AlojamientoForm v-model="alojamiento" @submit="updateAlojamiento" />
  </div>
  <div v-else>Cargando...</div>
</template>
