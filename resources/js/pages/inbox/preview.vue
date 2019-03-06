<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                entry: null,
                ready: false,
                id: this.$route.params.id,
            };
        },

        mounted() {
            document.title = "Physical Appointment — Reliqui";

            this.http().get('/api/inbox/' + this.id).then(response => {
                this.entry = response.data.entry;

                this.ready = true;
            }).catch(error => {
                this.ready = true;
            });
        }
    }
</script>

<template>
    <div>
        <div class="card">
            <div class="card-header p-3">
                <h1>Physical Appointment</h1>
            </div>

            <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="ready && !entry" class="text-center p-5">
                404 — Appointment not found
            </div>

            <div class="card-body pt-0 pr-0 pl-0 pb-1 bg-light rounded-bottom">
                <div class="table-responsive">
                    <table v-if="ready && entry" class="table-borderless table mb-0 card-bg-light">
                        <tbody>
                            <tr>
                                <td class="table-fit font-weight-bold">Time</td>
                                <td>
                                    {{localTime(entry.preferred_date_time)}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Location</td>
                                <td>
                                    {{entry.scheduled.work_location.address}},
                                    {{entry.scheduled.work_location.city}},
                                    {{entry.scheduled.work_location.country}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header p-3">
                <h1>Medical Form</h1>
            </div>

            <div class="card-body pt-0 pr-0 pl-0 pb-1 bg-light rounded-bottom">
                <div class="table-responsive">
                    <table v-if="ready && entry" class="table-borderless table mb-0 card-bg-light">
                        <tbody>
                            <tr>
                                <td class="table-fit font-weight-bold">Form Name</td>
                                <td>
                                    <span class="badge badge-info font-weight-light">
                                        {{entry.patient.form_name}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Patient Name</td>
                                <td>{{entry.patient.patient_full_name}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Gender</td>
                                <td>{{entry.patient.gender}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Date of Birth</td>
                                <td>{{entry.patient.dob}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Home Phone Number</td>
                                <td>{{entry.patient.home_phone}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Cell Phone Number</td>
                                <td>{{entry.patient.cell_phone}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Address</td>
                                <td>{{entry.patient.address}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">City</td>
                                <td>{{entry.patient.city}}</td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">State</td>
                                <td>{{entry.patient.state}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>