import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import DefaultLayout from './Layouts/DefaultLayout.vue'
import { InertiaProgress } from '@inertiajs/progress'
import Toast from "vue-toastification"
import './tabler-init'
import {queryParams, queryParamsExcept} from "./functions"
import VueCookies from 'vue-cookies'
import axios from 'axios'

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

InertiaProgress.init()

createInertiaApp({
    resolve: (name) => {
        let page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/**/*.vue'))

        page.then((module) => {
            module.default.layout = module.default.layout || DefaultLayout;
        });

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({ methods: {route, queryParams, queryParamsExcept}})
            .use(plugin)
            .use(VueCookies, { expires: '1d'})
            .use(Toast, {
                transition: "Vue-Toastification__bounce",
                maxToasts: 20,
                newestOnTop: true,
                position: "top-right",
                timeout: 3000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: "button",
                icon: true,
                rtl: false
            })
            .mount(el)

        // Hide preloader after app setup
        document.getElementById('preloader-custom').style.display = 'none'
    },
})
