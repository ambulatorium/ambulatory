<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                entry: null,
                locations: [],
                ready: false,
                id: this.$route.params.id || 'new',
                form: {
                    errors: [],
                    id: '',
                    location: '',
                    start_date_time: '',
                    end_date_time: '',
                    service_time: ''
                }
            };
        },

        mounted() {
            document.title = "Schedule — Reliqui Ambulatory";

            this.loadSchedule();
            this.loadResource();
        },

        methods: {
            loadResource() {
                this.http().get('/api/health-facilities').then(response => {
                    this.locations = response.data.entries.data;
                });
            },

            loadSchedule() {
                this.ready = false;

                this.http().get('/api/schedules/' + this.id).then(response => {
                    this.entry = response.data.entry;

                    this.form.id = response.data.entry.id;
                    this.form.start_date_time = response.data.entry.start_date_time;
                    this.form.end_date_time = response.data.entry.end_date_time;

                    if (this.id != 'new') {
                        this.form.location = response.data.entry.health_facility_id;
                        this.form.service_time = response.data.entry.estimated_service_time_in_minutes;
                    }

                    this.ready = true;
                }).catch(error => {
                    this.ready = true;
                });
            },

            saveResource() {
                this.form.errors = [];

                this.http().post('/api/schedules/' + this.id, this.form).then(response => {
                    this.$router.push({name: 'schedules'});

                    this.flashSuccess('Schedule saved successfully!', 2000);
                }).catch(error => {
                    this.form.errors = error.response.data.errors;
                });
            }
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header">
            <h1>Schedule</h1>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center p-5">
            404 — Schedule not found
        </div>

        <div v-if="ready && entry">
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label for="location" class="col-md-4 font-weight-bold col-form-label text-md-right">
                            Location
                            <small class="form-text text-muted mt-0"><em>required</em></small>
                        </label>

                        <div class="col-md-6">
                            <select id="location" v-model="form.location" class="custom-select custom-select-lg bg-light border-0">
                                <option disabled value="">Please select one location</option>
                                <option v-for="location in locations" :key="location.id" :value="location.id">
                                    {{location.name}}
                                </option>
                            </select>

                            <form-errors :errors="form.errors.location"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="start_date_time" class="col-md-4 font-weight-bold col-form-label text-md-right">
                            Start date
                            <small class="form-text text-muted mt-0">
                                <em>required (M/D/Y - H:M) UTC</em>
                            </small>
                        </label>

                        <div class="col-md-6">
                            <date-time-picker v-model="form.start_date_time"></date-time-picker>
                            <form-errors :errors="form.errors.start_date_time"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date_time" class="col-md-4 font-weight-bold col-form-label text-md-right">
                            End date
                            <small class="form-text text-muted mt-0">
                                <em>required (M/D/Y - H:M) UTC</em>
                            </small>
                        </label>

                        <div class="col-md-6">
                            <date-time-picker v-model="form.end_date_time"></date-time-picker>
                            <form-errors :errors="form.errors.end_date_time"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="service_time" class="col-md-4 font-weight-bold col-form-label text-md-right">Estimated service time</label>

                        <div class="col-md-3">
                            <div class="input-group">
                                <input id="service_time"
                                    type="number"
                                    class="form-control form-control-lg bg-light border-0"
                                    aria-label="Estimated service time"
                                    aria-describedby="estimated_service_time"
                                    v-model="form.service_time">

                                <div class="input-group-append">
                                    <span class="input-group-text bg-light border-0" id="estimated_service_time">Minutes</span>
                                </div>
                            </div>

                            <form-errors :errors="form.errors.service_time"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="#" class="btn btn-primary" @click="saveResource">
                                Save
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>