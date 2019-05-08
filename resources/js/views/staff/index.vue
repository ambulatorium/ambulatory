<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Staff" resource="staff">
        <router-link slot="btn-new-entry" :to="{name:'invitations-new'}" class="btn btn-outline-primary">
            Invite staff
        </router-link>

        <template slot="group-item" slot-scope="slotProps">
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{slotProps.entry.name}}</h5>
                    <small class="text-muted">{{timeAgo(slotProps.entry.created_at)}}</small>
                </div>
                <p class="mb-1">{{slotProps.entry.role}}</p>
            </div>
        </template>
    </index-view>
</template>