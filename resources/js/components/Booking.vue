<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            'multi-select': Multiselect,
        },

        props: ['schedule'],

        data() {
            return {
                today: this.localToday(),
                ready: false,
                timeSlots: [],
                loadMedicalForms: false,
                medicalForms: [],
                selectedMedicalForm: null,

                formErrors: [],
                formEntry: {
                    medical_form_id: '',
                    preferred_date_time: '',
                    description: '',
                },
            }
        },

        mounted() {
            document.title = "Booking - Ambulatory";

            this.getTimeSlots();
        },

        methods: {
            getTimeSlots() {
                this.http().get('/api/schedules/' + this.schedule + '/availabilities').then(response => {
                    this.timeSlots = response.data.entries;

                    this.ready = true;
                });
            },

            getMedicalForms() {
                this.loadMedicalForms = true;

                this.http().get('/api/medical-forms').then(response => {
                    this.medicalForms = response.data.entries.data;

                    this.loadMedicalForms = false;
                })
            },

            medicalFormId() {
                this.formEntry.medical_form_id = this.selectedMedicalForm.id;
            },

            selectedTimeSlot(value) {
                this.formEntry.preferred_date_time = this.today.format('YYYY-MM-DD') + ' ' + value;
            },

            booking() {
                this.http().post('/api/schedules/' + this.schedule + '/bookings', this.formEntry).then(response => {
                    this.close();

                    this.$router.push({name: 'inbox'});

                    this.alertSuccess('Successfully!', 3000);
                }).catch(error => {
                    this.formErrors = error.response.data.errors;
                });
            },

            close() {
                this.$root.booking.schedule = null;
            },
        }
    }
</script>

<template>
    <modal v-show="$root.booking.schedule">
        <div id="modal-dialog">
            <div class="row justify-content-center mt-5">
                <div class="col-sm-4 my-3 p-4 bg-white rounded-xl">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="medicalForm" class="font-weight-bold">Medical form</label>

                            <multi-select
                                v-model="selectedMedicalForm"
                                id="medicalForm"
                                label="form_name"
                                track-by="id"
                                placeholder="Select one your medical form"
                                :options="medicalForms"
                                :loading="loadMedicalForms"
                                :allow-empty="false"
                                @search-change="getMedicalForms"
                                @input="medicalFormId">
                            </multi-select>

                            <form-errors :errors="formErrors.medical_form_id"></form-errors>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Today {{ today.format('MMMM Do YYYY') }}</label>

                            <div v-if="!ready" class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <div v-if="ready && timeSlots.length == 0" class="p-5">
                                <p class="text-center">No time slots available</p>
                            </div>

                            <div v-else class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-primary m-1" v-for="slot in timeSlots" :key="slot" @click.prevent="selectedTimeSlot(slot)">
                                    <input type="radio" autocomplete="off" :id="slot"> {{slot}}
                                </label>
                            </div>

                            <form-errors :errors="formErrors.preferred_date_time"></form-errors>
                        </div>

                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Reason for visit</label>

                            <textarea v-model="formEntry.description" id="description" class="form-control bg-light border-0" cols="10" rows="5"></textarea>

                            <form-errors :errors="formErrors.description"></form-errors>
                        </div>

                        <div class="form-group d-flex d-inline">
                            <a href="#" class="btn btn-block btn-light rounded-full mt-2 ml-1 font-weight-bold" @click.prevent="close">
                                CANCEL
                            </a>

                            <button type="submit" class="btn btn-block btn-primary rounded-full ml-1 font-weight-bold" @click.prevent="booking">
                                BOOK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </modal>
</template>
