import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye, faBars, faBell, faUserCircle, faSearch } from '@fortawesome/free-solid-svg-icons'; 

//TODO DECLARAMOS NUESTROS ESTILOS 

import '../js/scss/Principal.scss'
import '../js/scss/Variables.scss'
import '../js/scss/UserStyle/location.scss'
import '../js/scss/ViewProp/CreatePlace.scss'



//TODO FIN DE DECLARAMOS NUESTROS ESTILOS 
library.add(faEye, faBars, faBell, faUserCircle, faSearch); // agrega todos los íconos que quieras

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin)
           .use(ZiggyVue)
           .component('font-awesome-icon', FontAwesomeIcon) 
           .mount(el);

        return app;
    },
    progress: {
        color: '#4B5563',
    },
});
