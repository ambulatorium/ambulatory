<script type="text/ecmascript-6">
    export default {
        methods: {
            openBooking(value) {
                this.bookAppointment(value);
            }
        }
    }
</script>

<template>
    <form-entry title="Doctor" resource="doctors">
        <template slot="entry-data" slot-scope="slotProps" class="bg-light">
            <div class="d-flex w-100 justify-content-between">
                <div class="media">
                    <img :src="slotProps.formData.account.avatar"
                        :alt="slotProps.formData.full_name"
                        class="rounded mr-4"
                        height="84"
                        width="84">

                    <div class="media-body">
                        <h5 class="mt-0 mb-1">{{slotProps.formData.full_name}}, {{slotProps.formData.qualification}}</h5>

                        <p class="mb-1">{{dateDuration(slotProps.formData.practicing_from)}} of experience</p>

                        <span class="badge badge-pill badge-light mr-2" v-for="specialization in slotProps.formData.specializations" :key="specialization.id">
                            {{specialization.name}}
                        </span>

                        <p class="text-muted mt-2">
                            <em>{{slotProps.formData.professional_statement}}</em>
                        </p>
                    </div>
                </div>

                <small>{{slotProps.formData.is_active ? 'Active' : 'Not active'}}</small>
            </div>

            <ul class="nav nav-pills mt-3">
                <li class="nav-link active">Schedules</li>
            </ul>

            <div class="list-group list-group-flush">
                <div class="list-group-item text-center p-3 border-0" v-if="slotProps.formData.schedules.length == 0">
                    {{slotProps.formData.full_name}}
                    don't have any schedules yet.
                </div>

                <div v-else v-for="schedule in slotProps.formData.schedules" :key="schedule.id">
                    <a href="#" @click.prevent="openBooking(schedule.id)" class="border-0 list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 font-weight-bold text-dark">{{schedule.health_facility.name}}</h6>
                            <small>{{schedule.health_facility.country}}</small>
                        </div>

                        <p class="mb-1">
                            {{localDateTime(schedule.start_date).format('MMMM Do YYYY')}}
                            -
                            {{localDateTime(schedule.end_date).format('MMMM Do YYYY')}}
                        </p>
                        <small>
                            {{schedule.health_facility.address}},
                            {{schedule.health_facility.city}},
                            {{schedule.health_facility.zip_code}}
                            {{schedule.health_facility.state}}
                        </small>
                    </a>
                </div>
            </div>
        </template>
    </form-entry>
</template>
