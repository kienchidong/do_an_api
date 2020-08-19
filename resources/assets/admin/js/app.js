require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import {routes} from './router';
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated.js';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);
Vue.use(VueInternationalization);
Vue.use(VueSweetalert2);

const i18n = new VueInternationalization({
    locale: document.head.querySelector('meta[name="locale"]').content,
    messages: Locale
});

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: "active"
})
import Begin from './Begin';

Vue.mixin({
    data() {
        return {
            userName: document.head.querySelector('meta[name="userName"]').content,
            userEmail: document.head.querySelector('meta[name="userEmail"]').content,
            userRole: document.head.querySelector('meta[name="userRole"]').content,
            clientLink: 'http://localhost:8080/',
        };
    },
});
const app = new Vue({
    el: '#app',
    i18n,
    router,
    render: h => h(Begin)
});
