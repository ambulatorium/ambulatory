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
         * Show the local date for today.
         */
        localToday() {
            return moment().local();
        },

        /**
         * Show the local date time.
         */
        localDateTime(dateTime) {
            return moment(dateTime)
                .utc()
                .local();
        },

        /**
         * Show the time ago format for the given time.
         */
        timeAgo(time) {
            return moment(time)
                .utc()
                .local()
                .fromNow();
        },

        /**
         * Show the duration format for the given date.
         */
        dateDuration(date) {
            return moment(date)
                .utc()
                .local()
                .fromNow(true);
        },

        /**
         * Show a success message.
         */
        alertSuccess(message, autoClose) {
            this.$root.alert.mode = 'flash';
            this.$root.alert.type = 'success';
            this.$root.alert.autoClose = autoClose;
            this.$root.alert.message = message;
        },

        /**
         * Show an error message.
         */
        alertError(message) {
            this.$root.alert.mode = 'dialog';
            this.$root.alert.type = 'error';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
        },

        /**
         * Show confirmation message.
         */
        alertConfirm(message, success, failure) {
            this.$root.alert.mode = 'dialog';
            this.$root.alert.type = 'confirmation';
            this.$root.alert.autoClose = false;
            this.$root.alert.message = message;
            this.$root.alert.confirmationProceed = success;
            this.$root.alert.confirmationCancel = failure;
        },

        /**
         * Show a booking dialog.
         */
        bookAppointment(schedule) {
            this.$root.booking.schedule = schedule;
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
    }
};