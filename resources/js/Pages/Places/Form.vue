<script setup>
import { ref, watch } from "vue";

// Props: recibe los datos iniciales si es edición
const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({
      nombre: "",
      categoria: "",
      descripcion: "",
      coordenadas: "",
      servicios: "",
      habitaciones: "",
      capacidad: "",
      reglas: "",
      imagenes: []
    }),
  },
});

const emit = defineEmits(["update:modelValue", "submit"]);

// Estado local del form
const form = ref({ ...props.modelValue });

// Si cambian props, actualizamos
watch(
  () => props.modelValue,
  (val) => {
    form.value = { ...val };
  }
);

// Emitir cambios al padre
watch(
  form,
  (val) => {
    emit("update:modelValue", val);
  },
  { deep: true }
);

// Manejo de imágenes
const images = ref([]);
const currentIndex = ref(0);

const handleFileUpload = (event) => {
  const files = event.target.files;
  for (let i = 0; i < files.length; i++) {
    const url = URL.createObjectURL(files[i]);
    images.value.push(url);
    form.value.imagenes.push(files[i]); // guardamos el archivo real para enviar
  }
};

const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
};
const prevSlide = () => {
  currentIndex.value =
    (currentIndex.value - 1 + images.value.length) % images.value.length;
};

// Calendario
const today = new Date();
const currentMonth = ref(today.getMonth());
const currentYear = ref(today.getFullYear());
const selectedDay = ref(null);
const ocupados = ref({});

const daysInMonth = (month, year) => {
  return Array.from(
    { length: new Date(year, month + 1, 0).getDate() },
    (_, i) => i + 1
  );
};

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

const isOcupado = (day) => {
  const key = `${currentYear.value}-${currentMonth.value}`;
  return ocupados.value[key]?.includes(day);
};

const marcarOcupado = () => {
  if (!selectedDay.value) return;
  const key = `${currentYear.value}-${currentMonth.value}`;
  if (!ocupados.value[key]) ocupados.value[key] = [];
  if (!ocupados.value[key].includes(selectedDay.value))
    ocupados.value[key].push(selectedDay.value);
  selectedDay.value = null;
};

const marcarDisponible = () => {
  if (!selectedDay.value) return;
  const key = `${currentYear.value}-${currentMonth.value}`;
  if (!ocupados.value[key]) return;
  ocupados.value[key] = ocupados.value[key].filter(
    (d) => d !== selectedDay.value
  );
  selectedDay.value = null;
};

// Guardar
const handleSubmit = () => {
  emit("submit", form.value);
};
</script>

<template>
  <section class="publicar-container">
    <h2 class="place_title">Publicar casa / alojamiento</h2>

    <!-- Información básica -->
    <div class="section">
      <h3 class="sub_title tittle">Información básica</h3>
      <div class="form-grid">
        <input v-model="form.nombre" placeholder="Nombre del alojamiento" />
        <select v-model="form.categoria">
          <option value="">Categoría</option>
          <option>Hotel</option>
          <option>Restaurante</option>
          <option>Casa</option>
        </select>
      </div>
      <textarea
        rows="4"
        cols="4"
        class="text_area_description"
        v-model="form.descripcion"
        placeholder="Descripción"
      ></textarea>
    </div>

    <!-- Ubicación -->
    <div class="section">
      <h3 class="sub_title tittle">Ubicación</h3>
      <input v-model="form.coordenadas" placeholder="Coordenadas: lat, lng" />
      <div class="mapa">[Mapa aquí]</div>
    </div>

    <!-- Características -->
    <div class="section">
      <h3 class="sub_title tittle">Características del alojamiento</h3>
      <div class="form-grid">
        <input v-model="form.servicios" placeholder="Servicios incluidos" />
        <input v-model="form.habitaciones" placeholder="Número de habitaciones" />
        <input v-model="form.capacidad" placeholder="Capacidad de personas" />
      </div>
    </div>

    <!-- Reglas -->
    <div class="section section_reglas">
      <h3 class="sub_title tittle" for="">Reglas y consideraciones</h3>
      <textarea
        rows="4"
        cols="4"
        class="text_area_description"
        v-model="form.reglas"
        placeholder="Descripción"
      ></textarea>
    </div>

    <!-- Input de imágenes -->
    <div class="mi-contenedor-existente">
      <input class="upload-box" type="file" multiple @change="handleFileUpload" />

      <!-- Carrusel -->
      <div class="carousel" v-if="images.length">
        <div
          class="carousel-track"
          :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
        >
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
        <input v-model="form.precio" placeholder="Precio por noche ($)" />
        <input v-model="form.promocion" placeholder="Descuento o promociones" />
      </div>
    </div>

    <!-- Disponibilidad -->
    <h3 class="sub_title tittle">Disponibilidad</h3>
    <div class="section section_calendar">
      <div class="estado">
        <button class="btn" @click="marcarDisponible">Disponible</button>
        <button class="btn" @click="marcarOcupado">Ocupado</button>
      </div>

      <div class="calendario-header">
        <button @click="prevMonth">◀</button>
        <span>{{ currentMonth + 1 }} / {{ currentYear }}</span>
        <button @click="nextMonth">▶</button>
      </div>

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
      <button type="button" class="btn btn-publicar" @click="handleSubmit">
        Guardar
      </button>
    </div>
  </section>
</template>
