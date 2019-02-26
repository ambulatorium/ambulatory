<template>
    <div class="d-flex align-items-center py-4">
        <h4 class="mb-0 text-primary">
            <strong>RELIQUI</strong>
        </h4>

        <div class="media ml-auto">
            <img :src="Reliqui.user.avatar"
                :alt="Reliqui.user.name"
                class="align-self-center rounded-circle mr-3"
                height="40"
                width="40">

            <div class="media-body" style="line-height: 0;">
                <h6 class="mt-1 font-weight-bold text-dark">
                    {{Reliqui.user.name}}

                    <small class="font-weight-lighter" v-if="Reliqui.user.role !== 'default'">
                        <mark class="bg-light rounded">{{Reliqui.user.role}}</mark>
                    </small>
                </h6>
                <a :href="'/'+Reliqui.path+'/logout'">Log out</a>
            </div>
        </div>
    </div>
</template>
