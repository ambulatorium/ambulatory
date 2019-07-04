<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Inbox" resource="inbox">
        <template slot="group-item" slot-scope="slotProps">
            <router-link :to="{name:'inbox-preview', params:{id: slotProps.entry.id}}" class="border-bottom list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1 font-weight-bold text-dark">Physical appointment</h6>
                    <small>{{timeAgo(slotProps.entry.created_at)}}</small>
                </div>

                <p class="mb-1">Visit time: {{localDateTime(slotProps.entry.preferred_date_time)}}</p>
                <small>
                    Location:
                    {{slotProps.entry.schedule.health_facility.name}},
                    {{slotProps.entry.schedule.health_facility.address}},
                    {{slotProps.entry.schedule.health_facility.city}},
                    {{slotProps.entry.schedule.health_facility.state}},
                    {{slotProps.entry.schedule.health_facility.country}}
                </small>
            </router-link>
        </template>
    </index-view>
</template>