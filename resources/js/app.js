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
    base: '/' + Ambulatory.path,
});

Vue.component('sidebar-menu', require('./components/SidebarMenu.vue').default);
Vue.component('index-view', require('./components/IndexView.vue').default);
Vue.component('form-entry', require('./components/FormEntry.vue').default);
Vue.component('alert', require('./components/Alert.vue').default);
Vue.component('form-errors', require('./components/FormErrors.vue').default);

Vue.mixin(Base);

new Vue({
    el: '#ambulatory',

    router,

    data() {
        return {
            alert: {
                mode: null,
                type: null,
                autoClose: 0,
                message: '',
                confirmationProceed: null,
                confirmationCancel: null,
            }
        }
    },

    mounted() {
        Bus.$on('httpError', message => this.alertError(message));
        Bus.$on('httpForbidden', message => this.alertError(message));
    }
});