<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <div class="sticky-top">
        <!-- user avatar -->
        <div class="media ml-1 mt-2">
            <img :src="Ambulatory.user.avatar"
                :alt="Ambulatory.user.name"
                class="align-self-center rounded-circle mr-3"
                height="40"
                width="40">

            <div class="media-body d-none d-lg-block">
                <h6 class="mb-0 font-weight-bold text-dark">
                    {{Ambulatory.user.name}}
                </h6>
                <a :href="'/'+Ambulatory.path+'/logout'">log out</a>
            </div>
        </div>

        <nav role="navigation" class="nav flex-column mt-2">
            <!-- inbox -->
            <div class="nav-item">
                <router-link active-class="active" to="/inbox" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <path d="M22 6l-10 7L2 6"/>
                    </svg>

                    <span class="d-none d-lg-block">Inbox</span>
                </router-link>
            </div>

            <!-- doctors -->
            <div class="nav-item">
                <router-link active-class="active" to="/doctors" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>

                    <span class="d-none d-lg-block">Doctors</span>
                </router-link>
            </div>

            <!-- schedules -->
            <div class="nav-item" v-if="Ambulatory.user.role === 'doctor'">
                <router-link active-class="active" to="/schedules" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>

                    <span class="d-none d-lg-block">Schedules</span>
                </router-link>
            </div>

            <!-- medical forms -->
            <div class="nav-item">
                <router-link active-class="active" to="/medical-forms" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                        <path d="M13 2v7h7"/>
                    </svg>

                    <span class="d-none d-lg-block">Medical forms</span>
                </router-link>
            </div>

            <!-- menu for admin -->
            <span v-if="Ambulatory.user.role === 'admin'">
                <!-- staff -->
                <div class="nav-item">
                    <router-link active-class="active" to="/staff" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>

                        <span class="d-none d-lg-block">Staff</span>
                    </router-link>
                </div>

                <!-- invitations -->
                <div class="nav-item">
                    <router-link active-class="active" to="/invitations" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                        </svg>

                        <span class="d-none d-lg-block">Invitations</span>
                    </router-link>
                </div>

                <!-- specializations -->
                <div class="nav-item">
                    <router-link active-class="active" to="/specializations" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="7"/><path d="M8.21 13.89L7 23l5-3 5 3-1.21-9.12"/>
                        </svg>

                        <span class="d-none d-lg-block">Specializations</span>
                    </router-link>
                </div>

                <!-- health facilities -->
                <div class="nav-item">
                    <router-link active-class="active" to="/health-facilities" class="nav-link d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>

                        <span class="d-none d-lg-block">Health Facilities</span>
                    </router-link>
                </div>
            </span>

            <!-- settings -->
            <div class="nav-item">
                <router-link active-class="active" :to="{name:'settings-account', params: {id: Ambulatory.user.id}}" class="nav-link d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>

                    <span class="d-none d-lg-block">Settings</span>
                </router-link>
            </div>
        </nav>
    </div>
</template>
