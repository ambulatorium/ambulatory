<script type="text/ecmascript-6">
    export default {
        props: {
            activeTab: String,
        },

        data() {
            return {
                userIsDoctor: false,
            }
        },

        mounted() {
            if (this.Ambulatory.user.role == 'doctor') {
                this.userIsDoctor = true;
            }
        }
    }
</script>

<template>
    <div class="tab">
        <ul class="nav nav-pills">
            <router-link
                active-class="active"
                class="nav-link"
                :to="{name:'settings-account', params: {id: Ambulatory.user.id}}"
                :class="{active: activeTab=='account'}">

                <span>Account</span>
            </router-link>

            <router-link
                v-if="userIsDoctor"
                active-class="active"
                class="nav-link"
                :to="{name:'settings-doctor-profile', params: {id: Ambulatory.user.id}}"
                :class="{active: activeTab=='doctorProfile'}">

                <span>Doctor Profile</span>
            </router-link>
        </ul>
    </div>
</template>
