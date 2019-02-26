<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-page title="Location of healthcare facilities" resource="healthcare-locations">
        <router-link slot="store-resource" :to="{name:'locations-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <tr slot="table-header">
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">City</th>
            <th scope="col">State</th>
            <th scope="col">Country</th>
            <th scope="col">ZIP Code</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'locations-edit', params:{id: slotProps.entry.id}}" class="badge badge-info">
                    {{slotProps.entry.name}}
                </router-link>
            </td>
            <td class="table-fit">{{slotProps.entry.address}}</td>
            <td class="table-fit">{{slotProps.entry.city}}</td>
            <td class="table-fit">{{slotProps.entry.state}}</td>
            <td class="table-fit">{{slotProps.entry.country}}</td>
            <td class="table-fit">{{slotProps.entry.zip_code}}</td>
        </template>
    </index-page>
</template>