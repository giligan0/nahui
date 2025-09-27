<script setup>
import Dashboard from "../ViewUser/Dashboard.vue"
import { ref } from "vue"
Dashboard

// procesando las imagenes


const images = ref([]);
const currentIndex = ref(0);

// Convertir archivos seleccionados a URLs locales
const handleFileUpload = (event) => {
  const files = event.target.files;
  for (let i = 0; i < files.length; i++) {
    images.value.push(URL.createObjectURL(files[i]));
  }
};

// Funciones del carrusel
const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
};
const prevSlide = () => {
  currentIndex.value = (currentIndex.value - 1 + images.value.length) % images.value.length;
};

// Datos básicos del formulario (solo maquetación)
const nombre = ref("")
const categoria = ref("")
const descripcion = ref("")
const coordenadas = ref("")
const servicios = ref("")
const habitaciones = ref("")
const capacidad = ref("")
const reglas = ref("")

// Imágenes
const imagenes = ref([])


// calendario inicio
const today = new Date();
const currentMonth = ref(today.getMonth());
const currentYear = ref(today.getFullYear());
const selectedDay = ref(null);

// Lista de días ocupados: { mes: año: [días] }
const ocupados = ref({});

// Función para obtener los días de un mes
const daysInMonth = (month, year) => {
  return Array.from(
    { length: new Date(year, month + 1, 0).getDate() },
    (_, i) => i + 1
  );
};

// Navegar meses
const prevMonth = () => {
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else currentMonth.value--;
};

const nextMonth = () => {
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else currentMonth.value++;
};

// Comprobar si un día está ocupado
const isOcupado = (day) => {
  const key = `${currentYear.value}-${currentMonth.value}`;
  return ocupados.value[key]?.includes(day);
};

// Marcar día como ocupado
const marcarOcupado = () => {
  if (!selectedDay.value) return;
  const key = `${currentYear.value}-${currentMonth.value}`;
  if (!ocupados.value[key]) ocupados.value[key] = [];
  if (!ocupados.value[key].includes(selectedDay.value))
    ocupados.value[key].push(selectedDay.value);
  selectedDay.value = null;
};

// Marcar día como disponible
const marcarDisponible = () => {
  if (!selectedDay.value) return;
  const key = `${currentYear.value}-${currentMonth.value}`;
  if (!ocupados.value[key]) return;
  ocupados.value[key] = ocupados.value[key].filter(d => d !== selectedDay.value);
  selectedDay.value = null;
};


// calendario fin


</script>

<template>
    <Dashboard />
  <section class="publicar-container">
    <h2 class="place_title">Publicar casa / alojamiento</h2>
    <!-- <p class="subtitulo">Subsección</p> -->

    <!-- Información básica -->
    <div class="section">
      <h3 class="sub_title tittle">Información básica</h3>
      <div class="form-grid">
        <input v-model="nombre" placeholder="Nombre del alojamiento" />
        <select v-model="categoria">
          <option value="">Categoría</option>
          <option>Hotel</option>
          <option>Restaurante</option>
          <option>Casa</option>
        </select>
    </div>
    <textarea rows="4" cols="4" class="text_area_description" v-model="descripcion" placeholder="Descripción"></textarea>
    </div>

    <!-- Ubicación -->
    <div class="section">
      <h3 class="sub_title tittle">Ubicación</h3>
      <input v-model="coordenadas" placeholder="Coordenadas: lat, lng" />
      <div class="mapa">[Mapa aquí]</div>
    </div>

    <!-- Características -->
    <div class="section">
      <h3 class="sub_title tittle">Características del alojamiento</h3>
      <div class="form-grid">
        <input v-model="servicios" placeholder="Servicios incluidos" />
        <input v-model="habitaciones" placeholder="Número de habitaciones" />
        <input v-model="capacidad" placeholder="Capacidad de personas" />
      </div>
    </div>

    <!-- Reglas -->
    <div class="section section_reglas">
        <h3 class="sub_title tittle" for="">Reglas y consideraciones</h3>
            <textarea rows="4" cols="4" class="text_area_description" v-model="descripcion" placeholder="Descripción"></textarea>
    </div>

<div class="mi-contenedor-existente">
    <!-- Input de selección de imágenes -->
    <input class="upload-box" type="file" multiple @change="handleFileUpload" />

    <!-- Galería / Carrusel -->
    <div class="carousel" v-if="images.length">
      <div class="carousel-track" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
        <div class="carousel-item" v-for="(img, index) in images" :key="index">
          <img :src="img" alt="Imagen" />
        </div>
      </div>
      <button class="prev" @click="prevSlide">&#10094;</button>
      <button class="next" @click="nextSlide">&#10095;</button>
    </div>
  </div>

    <!-- Precios -->
    <div class="section">
      <h3>Precios</h3>
      <div class="form-grid">
        <input placeholder="Precio por noche ($)" />
        <input placeholder="Descuento o promociones" />
      </div>
    </div>

 <!-- Disponibilidad -->
 <h3 class="sub_title tittle">Disponibilidad</h3>
  <div class="section section_calendar">


        <!-- Botones de estado -->
    <div class="estado">
      <button class="btn" @click="marcarDisponible">Disponible</button>
      <button class="btn" @click="marcarOcupado">Ocupado</button>
    </div>
        <!-- Navegación de meses -->
    <div class="calendario-header">
      <button @click="prevMonth">◀</button>
      <span>{{ currentMonth + 1 }} / {{ currentYear }}</span>
      <button @click="nextMonth">▶</button>
    </div>

    <!-- Calendario -->
    <div class="calendar">
      <div
        v-for="d in daysInMonth(currentMonth, currentYear)"
        :key="d"
        class="day"
        :class="{ ocupado: isOcupado(d), seleccionado: selectedDay === d }"
        @click="selectedDay = d"
      >
        {{ d }}
      </div>
    </div>


  </div>

    <!-- Publicar -->
    <div class="section publicar">
      <h3 class="sub_title tittle">Publicar</h3>
      <p>Al publicar, tu contenido podrá ser visto por los usuarios.</p>
      <button class="btn btn-publicar">Publicar alojamiento</button>
    </div>
  </section>
</template>

