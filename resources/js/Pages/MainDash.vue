<template>
    <section class="conoce-nicaragua">
        <!-- Grid de imágenes escalonadas -->
        <div class="image-grid">
            <!-- Texto -->
            <div class="item text-content">
                <h2>Conoce Nicaragua</h2>
                <p>
                    Nicaragua es un país de América Central ubicado entre el
                    océano Pacífico y el mar Caribe, conocido por su
                    espectacular territorio con lagos, volcanes y playas.
                </p>
            </div>
            <div class="item small">
                <img :src="primera" alt="Volcán" />
            </div>
            <div class="item medium">
                <img :src="segunda" alt="Playa" />
            </div>
            <div class="item small">
                <img :src="tercera" alt="Catedral" />
            </div>
            <div class="item small">
                <img :src="primera" alt="Paisaje volcán" />
            </div>
            <div class="item large">
                <img :src="cuarta" alt="Catedral de Granada" />
            </div>
            <div class="item medium">
                <img :src="segunda" alt="Islas del Caribe" />
            </div>
        </div>
    </section>
</template>

<script setup>
import primera from "../Pages/Multimedia/primeraimg.png"; // usa tu imagen real aquí
import segunda from "../Pages/Multimedia/palmera1.png"; // usa tu imagen real aquí
import tercera from "../Pages/Multimedia/catedral.png"; // usa tu imagen real aquí
import cuarta from "../Pages/Multimedia/catedragrande.png"; // usa tu imagen real aquí
</script>

<style lang="scss" scoped>
.conoce-nicaragua {
    padding: 4rem 3rem;
    background: #faf9f3;
    text-align: center;

    .text-content {
        max-width: 680px;

        h2 {
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: #111;
        }

        p {
            font-size: 1.05rem;
            color: #333;
            line-height: 1.7;
        }
    }

    .image-grid {
        display: grid;
        max-height: 95dvh;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: repeat(3, 9.5rem);
        gap: 1rem;
        align-items: stretch;
        justify-items: stretch;
        .item {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            overflow: hidden;
            grid-row: 3 / span 1;
                img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
        }

        .item:nth-child(1) {
            grid-row: 1 / span 1;
            grid-column: 2 / span 3;
            text-align: start;
            width: 90%;
        }
        .item:nth-child(2) {
            grid-row: 3 / span 1;
        }
        .item:nth-child(3),
        .item:nth-child(7) {
            grid-row: span 2 /4;
        }
        .item:nth-child(6) {
            grid-row: span 3 / 4;
        }
    }

    .text-content h2 {
        font-size: 1.8rem;
    }
}
</style>
