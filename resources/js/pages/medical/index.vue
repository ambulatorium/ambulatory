<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-page title="Medical Forms" resource="medical-form">
        <router-link slot="store-resource" :to="{name:'medical-form-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <tr slot="table-header">
            <th scope="col">Form name</th>
            <th scope="col">Patient full name</th>
            <th scope="col">Gender</th>
            <th scope="col">Address</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'medical-form-edit', params:{id: slotProps.entry.id}}" class="badge badge-light font-weight-light">
                    {{slotProps.entry.form_name}}
                </router-link>
            </td>
            <td class="table-fit">{{slotProps.entry.patient_full_name}}</td>
            <td class="table-fit">{{slotProps.entry.gender}}</td>
            <td class="table-fit">{{slotProps.entry.address}}</td>
        </template>
    </index-page>
</template>
