<script setup>
import { ref } from "vue";
import AlojamientoForm from "./Form.vue";
import Dashboard from "../ViewUser/Dashboard.vue";
import { router } from "@inertiajs/vue3";

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
  is_public: true,
  is_managed: false,
  place_category_id: null,
  address_id: null,
  hours: "",
  accessibility_notes: "",
  entrance_fee: "",
  currency: "USD",
});

const createAlojamiento = (data) => {
  const formData = new FormData();
  const payload = {
    ...data,
    name: data.nombre,
    description: data.descripcion,
    place_category_id: data.place_category_id,
    address_id: data.address_id,
    is_public: data.is_public ? 1 : 0,
    is_managed: data.is_managed ? 1 : 0,
    hours: data.hours,
    accessibility_notes: data.accessibility_notes,
    entrance_fee: data.entrance_fee,
    currency: data.currency
  };

  for (const key in payload) {
    if(key === "imagenes") {
      payload.imagenes.forEach((file, i) => formData.append(`imagenes[${i}]`, file));
    } else {
      formData.append(key, payload[key]);
    }
  }

  router.post("/createpleace", formData, {
    preserveScroll: true,
    onSuccess: () => {
      alert("Lugar creado con éxito");
      alojamiento.value = { ...alojamiento.value, nombre: "", descripcion: "", imagenes: [] };
    },
    onError: (errors) => {
      console.log(errors);
      alert("Error al crear alojamiento. Revisa la consola.");
    }
  });
};
</script>

<template>
  <Dashboard />
  <AlojamientoForm v-model="alojamiento" @submit="createAlojamiento" />
</template>
