<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Medical Forms" resource="medical-form">
        <router-link slot="btn-new-entry" :to="{name:'medical-form-new'}" class="btn btn-outline-primary">
            New
        </router-link>

        <template slot="group-item" slot-scope="slotProps">
            <router-link :to="{name:'medical-form-edit', params:{id: slotProps.entry.id}}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{slotProps.entry.form_name}}</h5>
                    <small class="text-muted">{{timeAgo(slotProps.entry.created_at)}}</small>
                </div>
                <p class="mb-1">{{slotProps.entry.full_name}} - {{slotProps.entry.address}}</p>
            </router-link>
        </template>
    </index-view>
</template>
