import './bootstrap';
import '../css/app.css';

//oruga
import Oruga from '@oruga-ui/oruga-next';
import '@oruga-ui/theme-oruga/dist/oruga.css';

//material design

import '@mdi/font/css/materialdesignicons.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { Ckeditor } from '@ckeditor/ckeditor5-vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Oruga)
            .use(ZiggyVue)
            .use(Ckeditor)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
