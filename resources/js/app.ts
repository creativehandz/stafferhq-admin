import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();  // Create Pinia instance
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin)
           .use(ZiggyVue)
           .use(pinia)  // Use Pinia
           .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
