<script setup>
import { ref } from "vue";
import AlojamientoForm from "./Form.vue";
import Dashboard from "../ViewUser/Dashboard.vue";
import { router } from "@inertiajs/vue3";

// Solo para renderizar el dashboard
Dashboard;

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
  imagenes: [],
  // Campos extra del modelo Place
  is_public: true,
  is_managed: false,
  place_category_id: null,
  address_id: null,
  hours: "",
  accessibility_notes: "",
  entrance_fee: "",
  currency: "USD",
});

// Función para crear alojamiento
const createAlojamiento = (data) => {
  const formData = new FormData();

  // Convertimos nombre a name y agregamos todos los campos
  const payload = {
    ...data,
    name: data.nombre,
    // mapear categoría a place_category_id si tienes lógica
    place_category_id: data.place_category_id,
    address_id: data.address_id,
    description: data.descripcion,
    is_public: data.is_public ? 1 : 0,
    is_managed: data.is_managed ? 1 : 0,
    hours: data.hours,
    accessibility_notes: data.accessibility_notes,
    entrance_fee: data.entrance_fee,
    currency: data.currency,
  };

  // Agregar todos los campos al FormData
  for (const key in payload) {
    if (key === "imagenes") {
      payload.imagenes.forEach((file, i) => formData.append(`imagenes[${i}]`, file));
    } else {
      formData.append(key, payload[key]);
    }
  }

  // Enviar con Inertia
  router.post("/places", formData, {
    preserveScroll: true,
    onSuccess: () => {
      alert("Lugar creado con éxito");
      // Limpiar formulario
      alojamiento.value = { ...alojamiento.value, nombre: "", descripcion: "", imagenes: [] };
    },
    onError: (errors) => {
      console.log(errors);
      alert("Error al crear alojamiento. Revisa la consola.");
    },
  });
};
</script>

<template>
  <Dashboard />
  <AlojamientoForm v-model="alojamiento" @submit="createAlojamiento" />
</template>
