<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Staff" resource="staff">
        <router-link slot="btn-new-entry" :to="{name:'invitations-new'}" class="btn btn-outline-primary">
            Invite staff
        </router-link>

        <tr slot="table-header">
            <th scope="col">Name</th>
            <th scope="col">Role</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">{{slotProps.entry.name}}</td>
            <td class="table-fit">
                <span class="badge badge-light border">
                    {{slotProps.entry.role}}
                </span>
            </td>
        </template>
    </index-view>
</template>