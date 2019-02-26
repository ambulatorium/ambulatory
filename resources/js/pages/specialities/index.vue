<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-page title="Specialities" resource="specialities">
        <router-link slot="store-resource" :to="{name:'specialities-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <tr slot="table-header">
            <th scope="col">Name</th>
            <th scope="col">Description</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'specialities-edit', params:{id: slotProps.entry.id}}" class="badge badge-info">
                    {{slotProps.entry.name}}
                </router-link>
            </td>
            <td class="table-fit">{{slotProps.entry.description}}</td>
        </template>
    </index-page>
</template>