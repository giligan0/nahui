<script setup>
import { ref } from "vue";
import { Inertia } from '@inertiajs/inertia';
import AlojamientoForm from "./Form.vue";
import Dashboard from "../ViewUser/Dashboard.vue";

Dashboard;

const props = defineProps({
  place: Object
});

const alojamiento = ref({ ...props.place });

const updateAlojamiento = (data) => {
  const formData = new FormData();

  for (const key in data) {
    if (key === "imagenes") {
      data.imagenes.forEach((file, i) => formData.append(`imagenes[${i}]`, file));
    } else {
      formData.append(key, data[key]);
    }
  }

  Inertia.post(`/places/${alojamiento.value.id}`, formData, {
    method: 'put',
    preserveScroll: true,
    onSuccess: () => {
      alert("Lugar actualizado con éxito");
      Inertia.get('/my-hosting');
    },
    onError: (errors) => {
      console.error(errors);
      alert("Error al actualizar alojamiento");
    }
  });
};
</script>

<template>
  <Dashboard />
  <AlojamientoForm v-model="alojamiento" @submit="updateAlojamiento" />
</template>
