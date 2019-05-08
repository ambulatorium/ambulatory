<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Inbox" resource="inbox">
        <tr slot="table-header">
            <th scope="col">Type</th>
            <th scope="col">Date Time</th>
            <th scope="col">Location</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'inbox-preview', params:{id: slotProps.entry.id}}" class="badge badge-info">
                    Physical Appointment
                </router-link>
            </td>
            <td class="table-fit">{{localDateTime(slotProps.entry.preferred_date_time)}}</td>
            <td class="table-fit">
                {{slotProps.entry.schedule.health_facility.name}},
                {{slotProps.entry.schedule.health_facility.address}},
                {{slotProps.entry.schedule.health_facility.city}}
            </td>
        </template>
    </index-view>
</template>