import Vue from 'vue';
import Base from './base';
import {Bus} from './bus.js';
import Routes from './routes';
import VueRouter from 'vue-router';

require('bootstrap');

Vue.use(VueRouter);

window.Popper = require('popper.js').default;

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: '/' + Reliqui.path,
});

Vue.component('reliqui-header', require('./layouts/Header.vue').default);
Vue.component('reliqui-sidebar', require('./layouts/Sidebar.vue').default);
Vue.component('index-page', require('./components/IndexPage.vue').default);
Vue.component('alert', require('./components/Alert.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('form-errors', require('./components/FormErrors.vue').default);
Vue.component('date-time-picker', require('./components/DateTimePicker.vue').default);

Vue.mixin(Base);

new Vue({
    el: '#reliqui',

    router,

    data() {
        return {
            alert: {
                type: null,
                autoClose: 0,
                message: '',
                confirmationProceed: null,
                confirmationCancel: null,
            },

            flash: {
                type: null,
                autoClose: 0,
                message: ''
            }
        }
    },

    mounted() {
        Bus.$on('httpError', message => this.alertError(message));
        Bus.$on('httpForbidden', message => this.alertError(message));
    },

    methods: {}
});