import _ from 'lodash';
import axios from 'axios';
import moment from 'moment';
import {Bus} from './bus.js';

export default {
    computed: {
        Ambulatory() {
            return Ambulatory;
        }
    },

    methods: {
        /**
         * Show the time in local time.
         */
        localTime(time) {
            return moment(time + ' Z')
                .utc()
                .local()
                .format('h:mm:ss A');
        },

        /**
         * Show the date in local date.
         */
        localDate(date) {
            return moment(date + ' Z')
                .utc()
                .local()
                .format('MMMM Do YYYY');
        },

        /**
         * Show the date time in local date time.
         */
        localDateTime(dateTime) {
            return moment(dateTime + ' Z')
                .utc()
                .local()
                .format('MMMM Do YYYY, h:mm:ss A');
        },

        /**
         * Show the time ago format for the given time.
         */
        timeAgo(time) {
            return moment(time + ' Z')
                .utc()
                .local()
                .fromNow();
        },

        /**
         * Truncate the given string.
         */
        truncate(string, length = 70) {
            return _.truncate(string, {
                'length': length,
                'separator': /,? +/
            });
        },

        /**
         * Creates a debounced function that delays invoking a callback.
         */
        debouncer: _.debounce(callback => callback(), 500),

        /**
         * Create an instance of axios.
         */
        http() {
            let instance = axios.create();

            instance.defaults.baseURL = '/' + Ambulatory.path;

            instance.interceptors.response.use(
                response => response,
                error => {
                    switch (error.response.status) {
                        case 500:
                            Bus.$emit('httpError', error.response.data.message);
                            break;
                        case 403:
                            Bus.$emit('httpForbidden', error.response.data.message);
                            break;
                        case 401:
                            window.location.href = '/' + Ambulatory.path + '/logout';
                            break;
                    }

                    return Promise.reject(error);
                }
            );

            return instance;
        },

        /**
         * Show a success message.
         */
        flashSuccess(message, autoClose) {
            this.$root.flash.type = 'success';
            this.$root.flash.autoClose = autoClose;
            this.$root.flash.message = message;
        },

        /**
         * Show an error message.
         */
        alertError(message) {
            this.$root.alert.type = 'error';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
        },


        /**
         * Show confirmation message.
         */
        alertConfirm(message, success, failure) {
            this.$root.alert.type = 'confirmation';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
            this.$root.alert.confirmationProceed = success;
            this.$root.alert.confirmationCancel = failure;
        },
    }
};