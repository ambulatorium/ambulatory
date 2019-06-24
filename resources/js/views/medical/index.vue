<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Medical Forms" resource="medical-forms">
        <router-link slot="btn-new-entry" :to="{name:'medical-forms-new'}" class="btn btn-outline-primary rounded-full">
            New
        </router-link>

        <template slot="group-item" slot-scope="slotProps">
            <router-link :to="{name:'medical-forms-edit', params:{id: slotProps.entry.id}}" class="border-bottom list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1 font-weight-bold text-dark">{{slotProps.entry.full_name}}</h6>
                    <small>{{slotProps.entry.form_name}}</small>
                </div>

                <p class="mb-1">{{slotProps.entry.address}} - {{slotProps.entry.city}}</p>
                <small>Created {{timeAgo(slotProps.entry.created_at)}}</small>
            </router-link>
        </template>
    </index-view>
</template>
