<script type="text/ecmascript-6">
    import HealthFacilities from './../../components/SelectHealthFacility';

    export default {
        components: {
            'select-health-facility': HealthFacilities
        }
    }
</script>

<template>
    <form-entry title="Schedule" resource="schedules" okToSave okToUpdate>
        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="health_facility" class="col-md-4 font-weight-bold col-form-label text-md-right">
                    Health facility
                    <small class="form-text text-muted mt-0"><em>required</em></small>
                </label>

                <div class="col-md-6">
                    <select-health-facility
                        id="health_facility"
                        v-model="slotProps.formData.health_facility">
                    </select-health-facility>

                    <form-errors :errors="slotProps.formErrors.health_facility"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="start_date" class="col-md-4 font-weight-bold col-form-label text-md-right">
                    Start date
                    <small class="form-text text-muted mt-0">
                        <em>required</em>
                    </small>
                </label>

                <div class="col-md-6">
                    <input
                        id="start_date"
                        type="date"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.start_date">

                    <form-errors :errors="slotProps.formErrors.start_date"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="end_date" class="col-md-4 font-weight-bold col-form-label text-md-right">
                    End date
                    <small class="form-text text-muted mt-0">
                        <em>required</em>
                    </small>
                </label>

                <div class="col-md-6">
                    <input
                        id="end_date"
                        type="date"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.end_date">

                    <form-errors :errors="slotProps.formErrors.end_date"></form-errors>
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