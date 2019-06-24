<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Health Facilities" resource="health-facilities">
        <router-link slot="btn-new-entry" :to="{name:'health-facilities-new'}" class="btn btn-outline-primary rounded-full">
            New
        </router-link>

        <template slot="group-item" slot-scope="slotProps">
            <router-link :to="{name:'health-facilities-edit', params:{id: slotProps.entry.id}}" class="border-bottom list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1 font-weight-bold text-dark">{{slotProps.entry.name}}</h6>
                    <small>{{timeAgo(slotProps.entry.created_at)}}</small>
                </div>

                <p class="mb-1">
                    {{slotProps.entry.address}},
                    {{slotProps.entry.city}},
                    {{slotProps.entry.zip_code}},
                    {{slotProps.entry.state}}
                    {{slotProps.entry.country}}
                </p>
            </router-link>
        </template>
    </index-view>
</template>