<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                locations: [],
            };
        },

        mounted() {
            this.http().get('/api/health-facilities').then(response => {
                this.locations = response.data.entries.data;
            }).catch(error => console(error));
        },
    }
</script>

<template>
    <form-entry title="Schedule" resource="schedules" okToSave>
        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="location" class="col-md-4 font-weight-bold col-form-label text-md-right">
                    Location
                    <small class="form-text text-muted mt-0"><em>required</em></small>
                </label>

                <div class="col-md-6">
                    <select id="location" v-model="slotProps.formData.health_facility_id" class="custom-select custom-select-lg bg-light border-0">
                        <option disabled value="">Please select one location</option>
                        <option v-for="location in locations" :key="location.id" :value="location.id">
                            {{location.name}}
                        </option>
                    </select>

                    <form-errors :errors="slotProps.formErrors.health_facility_id"></form-errors>
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
                    <date-time-picker v-model="slotProps.formData.start_date_time"></date-time-picker>

                    <form-errors :errors="slotProps.formErrors.start_date_time"></form-errors>
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
                    <date-time-picker v-model="slotProps.formData.end_date_time"></date-time-picker>

                    <form-errors :errors="slotProps.formErrors.end_date_time"></form-errors>
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
                            v-model="slotProps.formData.service_time">

                        <div class="input-group-append">
                            <span class="input-group-text bg-light border-0" id="estimated_service_time">Minutes</span>
                        </div>
                    </div>

                    <form-errors :errors="slotProps.formErrors.service_time"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>