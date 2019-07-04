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
            document.title = "Inbox — Ambulatory";

            this.http().get('/api/inbox/' + this.id).then(response => {
                this.entry = response.data.entry;

                this.ready = true;
            });
        }
    }
</script>

<template>
    <div>
        <div class="card">
            <div class="card-header p-3">
                <h1>Inbox</h1>
            </div>

            <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="ready && !entry" class="text-center p-5">
                404 — Inbox not found
            </div>

            <div class="card-body pt-0 pr-0 pl-0 pb-1 rounded-bottom">
                <div class="table-responsive">
                    <table v-if="ready && entry" class="table-borderless table mb-0 card-bg-light">
                        <tbody>
                            <tr>
                                <td class="table-fit font-weight-bold">Type</td>
                                <td>
                                    Physical Appointment
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Date Time</td>
                                <td>
                                    {{localDateTime(entry.preferred_date_time)}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Location</td>
                                <td>
                                    {{entry.schedule.health_facility.name}},
                                    {{entry.schedule.health_facility.address}},
                                    {{entry.schedule.health_facility.city}},
                                    {{entry.schedule.health_facility.state}},
                                    {{entry.schedule.health_facility.country}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Doctor Name</td>
                                <td>
                                    {{entry.schedule.doctor.full_name}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Inbox menu -->
                <ul class="nav nav-pills">
                    <a class="nav-link active">Patient</a>
                </ul>

                <!-- patient -->
                <div class="table-responsive">
                    <table v-if="ready && entry" class="table-borderless table mb-0 card-bg-light">
                        <tbody>
                            <tr>
                                <td class="table-fit font-weight-bold">Form Name</td>
                                <td>
                                    {{entry.medical_form.form_name}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Patient Name</td>
                                <td>
                                    {{entry.medical_form.full_name}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Date of Birth</td>
                                <td>
                                    {{localDate(entry.medical_form.dob)}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Gender</td>
                                <td>
                                    {{entry.medical_form.gender}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Marital Status</td>
                                <td>
                                    {{entry.medical_form.marital_status}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Address</td>
                                <td>
                                    {{entry.medical_form.address}}, {{entry.medical_form.city}}
                                </td>
                            </tr>
                            <tr>
                                <td class="table-fit font-weight-bold">Cell Phone</td>
                                <td>
                                    {{entry.medical_form.cell_phone}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>