<template>
    <Dashboard />

    <!-- Envuelve todo el contenido del template en este div (solo agregar este wrapper) -->
    <div class="mapa-interactivo">
        <!-- Info de ruta seleccionada -->

        <div class="top-row">
            <div>
                <h2 class="titulo">Mapa Interactivo</h2>
                <div class="subtitulo">Categorías</div>
            </div>
            <div v-if="routeInfo" class="route-summary">
  <div class="summary-item">
    <i class="fas fa-road"></i>
    <span><strong>{{ (routeInfo.distance / 1000).toFixed(2) }}</strong> km</span>
  </div>
  <div class="summary-item">
    <i class="fas fa-clock"></i>
    <span><strong>{{ Math.round(routeInfo.duration / 60) }}</strong> min</span>
  </div>
</div>
        </div>

        <div class="map-layout">
            <!-- Panel izquierdo: filtros + tarjetas -->

            <aside class="panel">
                <!-- buscador general arriba -->
                <div class="health-search">
                    <input v-model="searchTerm" class="search-input" placeholder="Buscar por nombre o tipo..." />
                    <p v-if="filteredHealthCenters.length > 0"></p>
                    <p v-else class="no-results">No se encontraron resultados.</p>
                </div>
                <div class="filters">
                    <button class="filter-btn" :class="{ active: selectedType === '' }" @click="selectedType = ''">
                        Todos
                    </button>
                    <button class="filter-btn" :class="{ active: selectedType === 'restaurantes' }"
                        @click="selectedType = 'restaurantes'">
                        Restaurantes
                    </button>
                    <button class="filter-btn" :class="{ active: selectedType === 'hoteles' }"
                        @click="selectedType = 'hoteles'">
                        Hoteles
                    </button>
                    <button class="filter-btn" :class="{ active: selectedType === 'fincas' }"
                        @click="selectedType = 'fincas'">
                        Fincas
                    </button>
                </div>

                <div class="cards-list">
                    <div v-for="(place, idx) in filteredHealthCenters" :key="idx" class="card"
                        @click="showRoute(place)">
<img
  v-if="place.image"
  :src="place.image"
  :alt="`Imagen de ${place.name}`"
  style="width: 100%; max-width: 100px; margin-top: 8px; border-radius: 8px"
/>                        <div v-else class="card-img"></div>

                        <div class="card-info">
                            <h3 class="card-title">{{ place.name }}</h3>
                            <div class="card-stars">3.5 ★★★☆☆</div>
                            <p class="card-desc">{{ place.description }}</p>
                            <div class="card-status open">Abierto · Cierra a las 2:00pm</div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Mapa a la derecha: usa tu <LMap> tal como está dentro de #map -->
            <div id="map">
                <!-- MAPA -->
                <LMap :zoom="zoom" :center="center" style="height: 100%; width: 100%">
                    <LTileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                        attribution="&copy; OpenStreetMap contributors" />

                    <LMarker v-if="userLocation" :lat-lng="userLocation" :icon="userIcon">
                        <LPopup>Tu ubicación actual</LPopup>
                    </LMarker>

                    <LMarker v-for="(place, index) in filteredHealthCenters" :key="index" :lat-lng="place.coords"
                        :icon="getIcon(place.type)" @click="showRoute(place)">
                        <LPopup>
                            <strong>{{ place.name }}</strong><br />
                            <strong>Tipo:</strong> {{ place.type }}<br />
                            {{ place.description }}<br />
    <img
  v-if="place.image"
  :src="place.image"
  :alt="`Imagen de ${place.name}`"
  style="width: 100%; max-width: 300px; margin-top: 8px; border-radius: 8px"
/>
                        </LPopup>
                    </LMarker>

                    <LPolyline v-if="route.length" :lat-lngs="route" color="blue" :weight="4" />
                </LMap>
            </div>
        </div>
    </div>
</template>

<script setup>
// BUSCADOR
// import { ref, computed } from 'vue'
// center.value = place.coords;

// importamos header
Dashboard;
const searchTerm = ref("");

const filteredCenters = computed(() => {
    const term = searchTerm.value.toLowerCase();
    return healthCenters.value.filter(
        (center) =>
            center.name.toLowerCase().includes(term) ||
            center.type.toLowerCase().includes(term)
    );
});

import { ref, computed, onMounted } from "vue";
import {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    LPolyline,
} from "@vue-leaflet/vue-leaflet";
import * as L from "leaflet";
import "leaflet/dist/leaflet.css";
import "@fortawesome/fontawesome-free/css/all.css";
import Dashboard from "../Dashboard.vue";

const zoom = ref(14);
const center = ref([13.093895708499756, -86.35622920183793]);
const userLocation = ref([13.093895708499756, -86.35622920183793]);
const route = ref([]);
const routeInfo = ref(null);
const selectedType = ref("");

// Icono personalizado para el usuario
const userIcon = L.divIcon({
    className: "custom-div-icon",
    html: '<i class="fas fa-location-arrow" style="color: blue; font-size: 24px;"></i>',
    iconSize: [24, 24],
    iconAnchor: [12, 24],
});

onMounted(() => {
    // Ubicación fija manual
    const fixedLocation = [13.093767184489636, -86.3561765107282];
    userLocation.value = fixedLocation;
    center.value = fixedLocation;
    console.log("Usando ubicación fija:", fixedLocation);
});

// Lugales turisticos
const healthCenters = ref([
  {
    name: "Hotel el uyuyui",
    type: "hoteles",
    description: "El mejor hotel para el uyuyuy.",
    coords: [13.092342505542677, -86.36620962999297],
    image: "/imagenes/lugarTuristic.jfif",
  },

  {
    name: "Hotel el uyuyui",
    type: "hoteles",
    description: "El mejor hotel para el uyuyuy.",
    coords: [13.092342505542644, -86.36620962999298],
    image: "/imagenes/lugarTuristic.jfif",
  },
]);




const filteredHealthCenters = computed(() => {
    const term = searchTerm.value.toLowerCase();
    return healthCenters.value.filter((center) => {
        const matchesSearch =
            center.name.toLowerCase().includes(term) ||
            center.type.toLowerCase().includes(term);
        const matchesType =
            selectedType.value === "" || center.type === selectedType.value;
        return matchesSearch && matchesType;
    });
});

function getIcon(type) {
    let iconClass = "";
    let color = "";

    switch (type) {
        case "hoteles":
            iconClass = "fas fa-location-dot";
            color = "red";
            break;
        case "fincas":
            iconClass = "fas fa-location-dot";
            color = "green";
            break;
        case "restaurantes":
            iconClass = "fas fa-location-dot";
            color = "purple";
            break;
    }

    return L.divIcon({
        className: "custom-div-icon",
        html: `<i class="${iconClass}" style="color: ${color}; font-size: 22px;"></i>`,
        iconSize: [22, 22],
        iconAnchor: [11, 22],
    });
}

function highlightMatch(text) {
    const term = searchTerm.value.trim();
    if (!term) return text;
    const regex = new RegExp(`(${term})`, "gi");
    return text.replace(regex, "<mark>$1</mark>");
}

async function showRoute(place) {
    if (!userLocation.value || !place?.coords) {
        alert("Ubicación no disponible o destino inválido.");
        return;
    }

    const origin = userLocation.value;
    const destination = place.coords;

    // API espera formato: lng,lat
    const url = `https://router.project-osrm.org/route/v1/driving/${origin[1]},${origin[0]};${destination[1]},${destination[0]}?overview=full&geometries=geojson&steps=true`;

    console.log("📍Origen:", origin);
    console.log("🎯Destino:", destination);
    console.log("🔗URL:", url);

    try {
        const res = await fetch(url);
        const data = await res.json();

        if (data.routes && data.routes.length > 0) {
            const coords = data.routes[0].geometry.coordinates.map(([lng, lat]) => [
                lat,
                lng,
            ]);
            route.value = coords;

            const leg = data.routes[0].legs[0];
            routeInfo.value = {
                distance: leg.distance,
                duration: leg.duration,
            };

            const synth = window.speechSynthesis;
            const message = new SpeechSynthesisUtterance(
                `Iniciando ruta hacia ${place.name}`
            );
            message.lang = "es-NI";
            synth.speak(message);

            leg.steps.forEach((step, i) => {
                setTimeout(() => {
                    const stepMsg = new SpeechSynthesisUtterance(
                        step.maneuver.instruction
                    );
                    stepMsg.lang = "es-NI";
                    synth.speak(stepMsg);
                }, i * 5000);
            });
        } else {
            alert("No se pudo calcular la ruta.");
        }
    } catch (error) {
        console.error("❌ Error al obtener la ruta:", error);
    }
}
</script>
