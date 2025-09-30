<template>
<Dashboard />
  <div class="detalle-container">
    <!-- ENCABEZADO -->
    <section class="encabezado">
      <h2 class="titulo">Sección principal</h2>
      <h3 class="subtitulo">Subsección</h3>
    </section>

    <!-- GALERÍA (imagen central con borde resaltado como en mock) -->
    <div class="galeria">
      <img
        v-for="(foto, i) in lugar.imagenes"
        :key="i"
        :src="foto"
        :alt="`Foto ${i+1}`"
        :class="{ active: i === 1 }"
      />
    </div>

    <!-- DESCRIPCIÓN -->
    <p class="descripcion">
      {{ lugar.descripcion }}
    </p>

    <!-- CALENDARIO + TEXTOS DESTACADOS -->
    <div class="info-grid">
      <!-- Calendario -->
      <div class="calendario-box">
        <div class="cal-header">
          <h4>Reservaciones</h4>
          <div class="month-nav">
            <button @click="prevMonth" aria-label="Mes anterior">‹</button>
            <div class="month-title">{{ monthName }} {{ displayedYear }}</div>
            <button @click="nextMonth" aria-label="Siguiente mes">›</button>
          </div>
        </div>

        <div class="weekdays">
          <div v-for="d in weekdays" :key="d" class="wd">{{ d }}</div>
        </div>

        <div class="calendario">
          <div
            v-for="cell in calendarGrid"
            :key="cell.key"
            :class="[
              'day',
              { placeholder: cell.placeholder },
              { ocupado: cell.placeholder ? false : !isAvailable(cell.dateStr) },
              { seleccionado: cell.placeholder ? false : isSelected(cell.dateStr) },
              { 'start-day': cell.placeholder ? false : isStart(cell.dateStr) },
              { 'end-day': cell.placeholder ? false : isEnd(cell.dateStr) }
            ]"
            @click="onDayClick(cell)"
          >
            <span v-if="!cell.placeholder">{{ cell.day }}</span>
          </div>
        </div>
      </div>

      <!-- Lista de textos -->
      <div class="textos-box">
        <h4>Subsección</h4>
        <ul>
          <li v-for="i in 6" :key="i">Texto destacado {{ i }}</li>
        </ul>
      </div>
    </div>

    <!-- CAJA DE RESERVA (Desde - Hasta - Total) -->
    <section class="reserva-box">
        <!-- <h3></h3> -->
      <div class="fechas">
        <div class="fcol">
          <p class="label">Desde</p>
          <h3 class="fecha-valor">{{ fechaInicio ? formatDate(fechaInicio) : '---' }}</h3>
        </div>

        <div class="swap-icon">⇄</div>

        <div class="fcol">
          <p class="label">Hasta</p>
          <h3 class="fecha-valor">{{ fechaFin ? formatDate(fechaFin) : '---' }}</h3>
        </div>
      </div>

      <div class="total">
        <div class="precio-line">
          <small>{{ lugar.precio }} USD x Noche</small>
          <small>{{ noches }} Noche{{ noches > 1 ? 's' : '' }} × {{ lugar.precio }} USD</small>
        </div>
        <button class="btn-total" :disabled="noches === 0">
            
          {{ noches > 0 ? total + ' USD' : 'Total' }}
        </button>
      </div>
    </section>

    <!-- RESEÑAS -->
    <section class="resenas-box">
      <h4>Reseñas</h4>

      <div class="resenas-grid">
        <!-- Barras -->
        <div class="barras">
          <div v-for="n in [5,4,3,2,1]" :key="n" class="barra">
            <span class="num">{{ n }}</span>
            <div class="linea">
              <div class="relleno" :style="{ width: getBarWidth(n) }"></div>
            </div>
          </div>
        </div>

        <!-- Promedio -->
        <div class="promedio">
          <h2>{{ promedio }}</h2>
          <div class="stars">★ ★ ★ ★ ☆</div>
          <p class="small">{{ lugar.resenas.length }} Comentarios</p>
        </div>
      </div>

      <!-- Comentarios: respetando posición y estilo (3 columnas en desktop) -->
      <div class="comentarios-grid">
        <article v-for="(r, i) in lugar.resenas" :key="i" class="comentario-card">
          <div class="coment-top">
            <div class="avatar"></div>
            <div class="meta">
              <div class="autor">{{ r.autor }}</div>
              <div class="tiempo">Hace {{ r.tiempo }}</div>
            </div>
            <div class="puntos">
              <!-- <span class="stars-small">★ ★ ★ ★ ☆</span> -->
            </div>
          </div>
          <p class="coment-text">{{ r.texto }}</p>
          <div class="stars-row"> 
            <span v-for="n in 5" :key="n" class="star" :class="{ filled: n <= r.puntaje }">★</span>
          </div>
        </article>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import Dashboard from "../ViewUser/Dashboard.vue";

Dashboard

const lugar = {
  titulo: "Hotel Nahuí",
  descripcion:
    "Nicaragua es un país de América Central ubicado entre el océano Pacífico y el mar Caribe, conocido por su espectacular territorio con lagos, volcanes y playas. Hotel de lujo en Estelí, perfecto para relajarse y disfrutar con la familia. jiijija jajajjaajjjasjdajaskdjasidjasidjkasjds askdhaskd laksuhdkashdkjsadkjasdhksa y disfrutar con la familia. jiijija jajajjaajjjasjdajaskdjasidjasidjkasjds askdhaskd laksuhdkashdkjsadkjasdhksa",
  precio: 200,
  imagenes: [
    "https://picsum.photos/520/320?1",
    "https://picsum.photos/520/320?2",
    "https://picsum.photos/520/320?3"
  ],
  resenas: [
    { autor: "Fernando María", texto: "Muy buen lugar, recomendable.", puntaje: 4, tiempo: "1 Año" },
    { autor: "Valentina Moncada", texto: "El servicio fue excelente.", puntaje: 5, tiempo: "1 Año" },
    { autor: "Yeiby Gutierrez", texto: "Cómodo y limpio.", puntaje: 4, tiempo: "1 Año" },
    { autor: "Usuario X", texto: "Buena ubicación y atención.", puntaje: 5, tiempo: "6 Meses" },
    { autor: "Cliente Y", texto: "Volvería sin duda.", puntaje: 5, tiempo: "3 Meses" }
  ]
};

/* ---------------------------
   Estado del calendario y selección
   --------------------------- */
const fechaInicio = ref(null); // 'YYYY-MM-DD'
const fechaFin = ref(null);

// mostrar mes/ano actual por defecto
const today = new Date();
const displayedMonth = ref(today.getMonth()); // 0..11
const displayedYear = ref(today.getFullYear());

const weekdays = ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"];

/* Helpers de fecha (Y-M-D) */
const pad = (n) => String(n).padStart(2, "0");
const dateToYMD = (d) => {
  const y = d.getFullYear();
  const m = pad(d.getMonth() + 1);
  const day = pad(d.getDate());
  return `${y}-${m}-${day}`;
};

/* Hash para disponibilidad reproducible */
function hashString(s) {
  let h = 0;
  for (let i = 0; i < s.length; i++) {
    h = (h << 5) - h + s.charCodeAt(i);
    h |= 0;
  }
  return Math.abs(h);
}
function isAvailable(dateStr) {
  // Simula disponibilidad: ~80% disponibles, reproducible por fecha
  const h = hashString(dateStr);
  return (h % 10) > 1; // 0-1 -> ocupado (20%); resto disponible
}

/* Construye la grilla del mes (incluye placeholders para alinear) */
const calendarGrid = computed(() => {
  const month = displayedMonth.value;
  const year = displayedYear.value;
  const first = new Date(year, month, 1);
  // getDay(): 0 (Sun) ... 6 (Sat). Queremos lunes como inicio.
  const offset = (first.getDay() + 6) % 7; // 0=Lu, ..., 6=Do
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const cells = [];
  // placeholders
  for (let i = 0; i < offset; i++) {
    cells.push({ placeholder: true, key: `ph-${i}-${month}-${year}` });
  }
  // days
  for (let d = 1; d <= daysInMonth; d++) {
    const dt = new Date(year, month, d);
    const dateStr = dateToYMD(dt);
    cells.push({
      placeholder: false,
      day: d,
      dateObj: dt,
      dateStr,
      key: dateStr
    });
  }
  // optionally fill trailing placeholders to complete last week (nice for layout)
  while (cells.length % 7 !== 0) {
    cells.push({ placeholder: true, key: `ph-tail-${cells.length}-${month}-${year}` });
  }
  return cells;
});

/* Navegación de meses */
const monthNames = [
  "Enero","Febrero","Marzo","Abril","Mayo","Junio",
  "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
];
const monthName = computed(() => monthNames[displayedMonth.value]);

function prevMonth() {
  if (displayedMonth.value === 0) {
    displayedMonth.value = 11;
    displayedYear.value--;
  } else {
    displayedMonth.value--;
  }
}
function nextMonth() {
  if (displayedMonth.value === 11) {
    displayedMonth.value = 0;
    displayedYear.value++;
  } else {
    displayedMonth.value++;
  }
}

/* Selección de fechas (permite rango sobre meses diferentes) */
function onDayClick(cell) {
  if (cell.placeholder) return;
  const dateStr = cell.dateStr;
  if (!isAvailable(dateStr)) return; // no hace nada si está ocupado

  // lógica de selección:
  if (!fechaInicio.value || (fechaInicio.value && fechaFin.value)) {
    // comienza nueva selección
    fechaInicio.value = dateStr;
    fechaFin.value = null;
    return;
  }

  // si solo inicio está establecido
  if (!fechaFin.value) {
    // si el user clickea una fecha anterior al inicio -> reinicia inicio
    if (new Date(dateStr) <= new Date(fechaInicio.value)) {
      fechaInicio.value = dateStr;
      fechaFin.value = null;
    } else {
      // set final
      // Además: validar que todas las fechas entre inicio y fin estén disponibles:
      const start = new Date(fechaInicio.value);
      const end = new Date(dateStr);
      let ok = true;
      for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
        if (!isAvailable(dateToYMD(d))) {
          ok = false;
          break;
        }
      }
      if (ok) {
        fechaFin.value = dateStr;
      } else {
        // si hay un día no disponible entre medias: reinicia inicio acá
        fechaInicio.value = dateStr;
        fechaFin.value = null;
      }
    }
  }
}

/* Utilitarios para estado de celda (start/end/selected) */
const isStart = (dateStr) => fechaInicio.value && dateStr === fechaInicio.value;
const isEnd = (dateStr) => fechaFin.value && dateStr === fechaFin.value;
const isSelected = (dateStr) => {
  if (!fechaInicio.value) return false;
  if (fechaInicio.value && !fechaFin.value) return dateStr === fechaInicio.value;
  const start = new Date(fechaInicio.value);
  const end = new Date(fechaFin.value);
  const cur = new Date(dateStr);
  return cur >= start && cur <= end;
};

/* Cálculo de noches / total - usando UTC para evitar edges con huso horario */
const noches = computed(() => {
  if (!fechaInicio.value || !fechaFin.value) return 0;
  // use UTC difference to avoid DST issues
  const [y1, m1, d1] = fechaInicio.value.split("-").map(Number);
  const [y2, m2, d2] = fechaFin.value.split("-").map(Number);
  const startUTC = Date.UTC(y1, m1 - 1, d1);
  const endUTC = Date.UTC(y2, m2 - 1, d2);
  const diffDays = Math.floor((endUTC - startUTC) / (1000 * 60 * 60 * 24));
  return diffDays;
});
const total = computed(() => noches.value * lugar.precio);

/* Formato fecha largo en español */
function formatDate(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleDateString("es-ES", {
    weekday: "long",
    day: "numeric",
    month: "long"
  });
}

/* Reseñas: promedio y barras */
const promedio = computed(() => {
  if (!lugar.resenas.length) return "0.0";
  const sum = lugar.resenas.reduce((a, b) => a + b.puntaje, 0);
  return (sum / lugar.resenas.length).toFixed(1);
});
function getBarWidth(n) {
  const total = lugar.resenas.length || 1;
  const count = lugar.resenas.filter((r) => r.puntaje === n).length;
  return `${(count / total) * 100}%`;
}
</script>

