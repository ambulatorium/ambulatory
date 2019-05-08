<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Schedules" resource="schedules">
        <router-link slot="btn-new-entry" :to="{name:'schedules-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <tr slot="table-header">
            <th scope="col">Location</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'schedules-edit', params:{id: slotProps.entry.id}}" class="badge badge-info">
                    {{slotProps.entry.health_facility.name}}
                </router-link>
            </td>
            <td class="table-fit">{{localDateTime(slotProps.entry.start_date_time)}}</td>
            <td class="table-fit">{{localDateTime(slotProps.entry.end_date_time)}}</td>
        </template>
    </index-view>
</template>