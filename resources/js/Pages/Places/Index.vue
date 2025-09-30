<script setup>
import { ref, watch } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import Dashboard from "../ViewUser/Dashboard.vue"; // Ajusta la ruta según tu estructura

// Obtener los lugares desde Inertia
const page = usePage();
const places = ref(page.props.places?.data || []);

// Actualizar lugares si cambian dinámicamente
watch(() => page.props.places?.data, (val) => { places.value = val; });

// Función para editar lugar
const editPlace = (id) => {
  Inertia.get(`/places/${id}/edit`);
};

// Función para eliminar lugar
const deletePlace = (id) => {
  if (confirm('¿Deseas eliminar este lugar?')) {
    Inertia.delete(`/places/${id}`, {
      onSuccess: () => alert('Lugar eliminado con éxito'),
    });
  }
};
</script>

<template>
  <Dashboard />
  <div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Mis Lugares</h1>
      <Link
        href="/createpleace"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
      >
        Crear nuevo lugar
      </Link>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Publicado</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="place in places" :key="place.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 text-sm text-gray-900">{{ place.name }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ place.place_category?.name ?? '—' }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ place.entrance_fee ?? '—' }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ place.is_public ? 'Sí' : 'No' }}</td>
            <td class="px-6 py-4 text-center text-sm font-medium space-x-2">
              <button @click="editPlace(place.id)" class="text-yellow-500 hover:text-yellow-700">Editar</button>
              <button @click="deletePlace(place.id)" class="text-red-500 hover:text-red-700">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
