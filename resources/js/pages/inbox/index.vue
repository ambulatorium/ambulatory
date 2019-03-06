<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-page title="Physical Appointment" resource="inbox">
        <tr slot="table-header">
            <th scope="col">Medical Form</th>
            <th scope="col">Date Time</th>
            <th scope="col">Location</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'inbox-preview', params:{id: slotProps.entry.id}}" class="badge badge-info">
                    {{slotProps.entry.patient.form_name}}
                </router-link>
            </td>
            <td class="table-fit">{{localTime(slotProps.entry.preferred_date_time)}}</td>
            <td class="table-fit">
                {{slotProps.entry.scheduled.work_location.address}},
                {{slotProps.entry.scheduled.work_location.city}},
                {{slotProps.entry.scheduled.work_location.state}},
                {{slotProps.entry.scheduled.work_location.country}}
            </td>
        </template>
    </index-page>
</template>