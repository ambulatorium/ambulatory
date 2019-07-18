<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <index-view title="Doctors" resource="doctors">
        <template slot="group-item" slot-scope="slotProps">
            <router-link :to="{name:'doctors-preview', params:{id: slotProps.entry.id}}" class="border-bottom list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <div class="media">
                        <img :src="slotProps.entry.account.avatar"
                            :alt="slotProps.entry.full_name"
                            class="rounded mr-4"
                            height="54"
                            width="54">

                        <div class="media-body">
                            <h6 class="mt-0 mb-1 font-weight-bold text-dark">{{slotProps.entry.full_name}}, {{slotProps.entry.qualification}}</h6>
                            <p class="mb-1">{{dateDuration(slotProps.entry.practicing_from)}} of experience</p>

                            <span class="badge badge-pill badge-light mr-2" v-for="specialization in slotProps.entry.specializations" :key="specialization.id">
                                {{specialization.name}}
                            </span>
                        </div>
                    </div>

                    <small>{{slotProps.entry.is_active ? 'Active' : 'Not active'}}</small>
                </div>
            </router-link>
        </template>
    </index-view>
</template>
