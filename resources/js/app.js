    import '../css/app.css';
    import './bootstrap';

    import { createApp, h } from 'vue';
    import { createInertiaApp } from '@inertiajs/vue3';
    import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
    import { ZiggyVue } from 'ziggy-js';


    // FontAwesome
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { faEye, faBars, faBell, faUserCircle, faSearch } from '@fortawesome/free-solid-svg-icons';
    library.add(faEye, faBars, faBell, faUserCircle, faSearch);

    // Inertia Progress (opcional, instalar antes con npm install @inertiajs/progress)
    import { InertiaProgress } from '@inertiajs/progress';
    InertiaProgress.init({ color: '#4B5563' });

    // Map CSS
    import 'leaflet/dist/leaflet.css';

    // Tus estilos SCSS
    import '../js/scss/Principal.scss';
    import '../js/scss/UserStyle/Mapa.scss';
    import '../js/scss/Variables.scss';
    import '../js/scss/UserStyle/location.scss';
    import '../js/scss/ViewProp/CreatePlace.scss';

// jajsjs


    const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: title => `${title} - ${appName}`,
    resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
             .use(ZiggyVue) 
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
});