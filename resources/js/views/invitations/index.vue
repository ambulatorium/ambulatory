<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Invitations" resource="invitations">
        <router-link slot="btn-new-entry" :to="{name:'invitations-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <template slot="group-item" slot-scope="slotProps">
            <router-link :to="{name:'invitations-edit', params:{id: slotProps.entry.id}}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{slotProps.entry.email}}</h5>
                    <small class="text-muted">{{timeAgo(slotProps.entry.created_at)}}</small>
                </div>
                <p class="mb-1">{{slotProps.entry.role}}</p>
            </router-link>
        </template>
    </index-view>
</template>