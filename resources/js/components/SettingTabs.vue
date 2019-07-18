<script type="text/ecmascript-6">
    export default {
        props: {
            activeTab: String,
        },

        data() {
            return {
                userIsDoctor: false,
                doctorId: 'new',
            }
        },

        mounted() {
            if (this.Ambulatory.user.role === 'doctor') {
                this.doctor();
            };
        },

        methods: {
            doctor() {
                this.userIsDoctor = true;

                if (this.Ambulatory.user.doctorId != null) {
                    this.doctorId = this.Ambulatory.user.doctorId;
                }
            },
        }
    }
</script>

<template>
    <div class="tab">
        <ul class="nav nav-pills">
            <router-link
                active-class="active"
                class="nav-link"
                :to="{name:'settings-account'}"
                :class="{active: activeTab=='account'}">

                <span>Account</span>
            </router-link>

            <router-link
                active-class="active"
                class="nav-link"
                :to="{name:'new-password'}"
                :class="{active: activeTab=='newPassword'}">

                <span>Password</span>
            </router-link>

            <router-link
                v-if="userIsDoctor"
                active-class="active"
                class="nav-link"
                :to="{name:'settings-doctor-profile', params: {id: this.doctorId}}"
                :class="{active: activeTab=='doctorProfile'}">

                <span>Doctor Profile</span>
            </router-link>
        </ul>
    </div>
</template>
