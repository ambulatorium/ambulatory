<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-page title="Working hours" resource="working-hours">
        <router-link slot="store-resource" :to="{name:'working-hours-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <tr slot="table-header">
            <th scope="col">Location</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'working-hours-edit', params:{id: slotProps.entry.id}}" class="badge badge-info">
                    {{slotProps.entry.work_location.name}}
                </router-link>
            </td>
            <td class="table-fit">{{localTime(slotProps.entry.start_date_time)}}</td>
            <td class="table-fit">{{localTime(slotProps.entry.end_date_time)}}</td>
        </template>
    </index-page>
</template>