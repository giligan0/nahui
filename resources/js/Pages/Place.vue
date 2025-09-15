<template>
  <Dashboard />
  <div class="places-page">
    <!-- Buscador -->
    <div class="search-box">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Buscador..."
      />
      <font-awesome-icon icon="search" class="search-icon" />
    </div>

    <!-- Categorías -->
    <div
      v-for="(categoria, index) in categorias"
      :key="index"
      class="category"
    >
      <h2>{{ categoria.nombre }} ›</h2>

      <div class="grid">
        <div
          v-for="(lugar, i) in filteredPlaces(categoria.lugares)"
          :key="i"
          class="card"
          @click="goToPlace(lugar)"
        >
          <img :src="lugar.imagen" :alt="lugar.titulo" />
          <div class="card-body">
            <h3>{{ lugar.titulo }}</h3>
            <p>{{ lugar.descripcion }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faSearch } from "@fortawesome/free-solid-svg-icons";
import Dashboard from '@/Pages/Dashboard.vue';

Dashboard

// query del buscador
const searchQuery = ref("");

// Datos de ejemplo (puedes cargarlos desde la API o backend Laravel)
const categorias = ref([
  {
    nombre: "Hoteles",
    lugares: [
      { titulo: "Hotel Granada", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?1" },
      { titulo: "Hotel Colonial", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?2" },
      { titulo: "Hotel Plaza", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?3" },
      { titulo: "Hotel Plaza", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?3" },
      { titulo: "Hotel Nahuí", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?4" }
    ]
  },
  {
    nombre: "Restaurantes",
    lugares: [
      { titulo: "Restaurante El Sabor", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?5" },
      { titulo: "La Cocina Típica", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?6" },
      { titulo: "Comedor Doña Ana", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?7" }
    ]
  },
  {
    nombre: "Otros lugares",
    lugares: [
      { titulo: "Museo Nacional", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?8" },
      { titulo: "Teatro Municipal", descripcion: "Texto base", imagen: "https://picsum.photos/300/200?9" }
    ]
  }
]);

// Filtro para buscador
const filteredPlaces = (lugares) => {
  if (!searchQuery.value) return lugares;
  return lugares.filter((lugar) =>
    lugar.titulo.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
};

// Acción al dar click en un lugar (puedes usar Vue Router aquí)
const goToPlace = (lugar) => {
  console.log("Ir al lugar:", lugar.titulo);
  // Ejemplo con router:
  // router.push({ name: "detalle-lugar", params: { id: lugar.id } })
};
</script>

<style lang="scss" scoped>
.places-page {
  padding: 2rem;
  background: #fefdf6;
  color: #222;

  .search-box {
    position: relative;
    max-width: 900px;
    margin: 0 auto 2rem auto;

    input {
      width: 100%;
      padding: 0.8rem 2.5rem 0.8rem 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      outline: none;
    }

    .search-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
    }
  }

  .category {
    margin-bottom: 2rem;
    padding: 2rem;


    h2 {
      font-size: 1.3rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 2px 2px 2px #696969;
      &:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }

      img {
        width: 100%;
        height: 150px;
        object-fit: cover;
      }

      .card-body {
        padding: 0.8rem;

        h3 {
          font-size: 1rem;
          margin-bottom: 0.3rem;
        }

        p {
          font-size: 0.9rem;
          color: #666;
        }
      }
    }
  }
}
</style>