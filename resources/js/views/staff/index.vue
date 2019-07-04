<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Staff" resource="staff">
        <router-link slot="btn-new-entry" :to="{name:'invitations-new'}" class="btn btn-outline-primary rounded-full font-weight-bold">
            Invite staff
        </router-link>

        <template slot="group-item" slot-scope="slotProps">
            <div class="border-bottom list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <div class="media">
                        <img :src="slotProps.entry.avatar"
                            :alt="slotProps.entry.name"
                            class="rounded mr-4"
                            height="54"
                            width="54">

                        <div class="media-body">
                            <h6 class="mt-0 mb-2 font-weight-bold text-dark">{{slotProps.entry.name}}</h6>
                            <p class="mb-1">Joined {{timeAgo(slotProps.entry.created_at)}}</p>
                        </div>
                    </div>

                    <small>{{slotProps.entry.role}}</small>
                </div>
            </div>
        </template>
    </index-view>
</template>