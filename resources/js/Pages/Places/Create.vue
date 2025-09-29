<script setup>
import { ref } from "vue";
import AlojamientoForm from "./Form.vue";
import axios from "axios";
import Dashboard from "../ViewUser/Dashboard.vue";
Dashboard

const alojamiento = ref({
  nombre: "",
  categoria: "",
  descripcion: "",
  coordenadas: "",
  servicios: "",
  habitaciones: "",
  capacidad: "",
  reglas: "",
  precio: "",
  promocion: "",
  imagenes: []
});

const createAlojamiento = async (data) => {
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

    await axios.post("/api/alojamientos", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    alert("Alojamiento creado con éxito");
    // redirección si quieres
  } catch (error) {
    console.error("Error al crear alojamiento:", error);
  }
};
</script>

<template>
    <Dashboard />
  <AlojamientoForm v-model="alojamiento" @submit="createAlojamiento" />
</template>
