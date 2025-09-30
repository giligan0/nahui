<script setup>
import Form from "./Form.vue";
import axios from "axios";
import { ref } from "vue";
import { useRouter, usePage } from "vue-router";

const router = useRouter();
const page = usePage();

const place = ref(page.props.place);

const updatePlace = async (data) => {
  const formData = new FormData();
  for (const key in data) {
    if (key === "imagenes") {
      data.imagenes.forEach((file, i) => formData.append(`imagenes[${i}]`, file));
    } else {
      formData.append(key, data[key]);
    }
  }

  await axios.post(`/places/${place.value.id}?_method=PUT`, formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });

  alert("Lugar actualizado con éxito");
  router.push({ name: "places.index" });
};
</script>

<template>
  <Form v-model="place" @submit="updatePlace" />
</template>
