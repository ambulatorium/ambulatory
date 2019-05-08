<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Invitations" resource="invitations">
        <router-link slot="btn-new-entry" :to="{name:'invitations-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <tr slot="table-header">
            <th scope="col">E-mail Address</th>
            <th scope="col">Role</th>
        </tr>

        <template slot="table-row" slot-scope="slotProps">
            <td class="table-fit">
                <router-link :to="{name:'invitations-edit', params:{id: slotProps.entry.id}}">
                    {{slotProps.entry.email}}
                </router-link>
            </td>
            <td class="table-fit">{{slotProps.entry.role}}</td>
        </template>
    </index-view>
</template>