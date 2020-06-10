require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import { routes }  from './index';


Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'hash',
    routes
})

const app = new Vue({
    el: '#app',
    router
});
