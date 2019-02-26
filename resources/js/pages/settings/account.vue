<script type="text/ecmascript-6">
    import { Multiselect } from 'vue-multiselect';

    export default {
        components: { Multiselect },

        data() {
            return {
                currentTab: 'account',
                id: this.$route.params.id || '',
                entry: null,
                entryDoctor: null,
                settingDoctor: false,
                ready: false,
                uploadProgress: 0,
                uploading: false,
                specialities: [],
                isLoading: false,
                formAccount: {
                    errors: [],
                    id: '',
                    name: '',
                    email: '',
                    avatar: '',
                    password: '',
                },
                formDoctor: {
                    errors: [],
                    id: '',
                    full_name: '',
                    years_of_experience: '',
                    qualification: '',
                    specialities: [],
                    bio: ''
                }
            };
        },

        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "Settings — Reliqui";

            this.loadAccount();

            if (this.Reliqui.user.role === 'doctor') {
                this.settingDoctor = true;

                this.loadDoctor();
            }
        },

        methods: {
            loadAccount() {
                this.ready = false;

                this.http().get('/api/account/' + this.id).then(response => {
                    this.entry = response.data.entry;

                    this.formAccount.id = response.data.entry.id;
                    this.formAccount.name = response.data.entry.name;
                    this.formAccount.email = response.data.entry.email;
                    this.formAccount.avatar = response.data.entry.avatar;

                    this.ready = true;
                }).catch(error => {
                    this.ready = true;
                });
            },

            loadDoctor() {
                this.ready = false;

                this.http().get('/api/doctor-profile/' + this.id).then(response => {
                    this.entryDoctor = response.data.entry;

                    this.formDoctor.id = response.data.entry.id;
                    this.formDoctor.full_name = response.data.entry.full_name;
                    this.formDoctor.years_of_experience = response.data.entry.years_of_experience;
                    this.formDoctor.qualification = response.data.entry.qualification;
                    this.formDoctor.specialities = response.data.entry.specialties || '';
                    this.formDoctor.bio = response.data.entry.bio;

                    this.ready = true;
                }).catch(error => {
                    this.ready = true;
                });
            },

            loadSpesialities() {
                this.isLoading = true;

                this.http().get('/api/specialities').then(response => {
                    this.specialities = response.data.entries.data;

                    this.isLoading = false;
                }).catch(error => {
                    this.isLoading = false;
                });
            },

            saveAccount() {
                this.formAccount.errors = [];

                this.http().post('/api/account/' + this.id, this.formAccount).then(response => {
                    this.flashSuccess('Account saved successfully!', 2000);

                    location.reload();
                }).catch(error => {
                    this.formAccount.errors = error.response.data.errors;
                });
            },

            saveDoctorProfile() {
                this.formDoctor.errors = [];

                this.http().post('/api/doctor-profile/' + this.id, this.formDoctor).then(response => {
                    this.flashSuccess('Doctor profile saved successfully', 2000);
                }).catch(error => {
                    this.formDoctor.errors = error.response.data.errors;
                });
            },

            limitText (count) {
                return `and ${count} other specialities`
            },

            clearAll() {
                this.form.specialities = [];
            },

            uploadSelectedImage(event) {
                let file = event.target.files[0];
                let formAvatar = new FormData();

                formAvatar.append('image', file, file.name);

                this.uploading = true;

                this.http().post('/api/uploads-user-avatar', formAvatar, {
                    onUploadProgress: progressEvent => {
                        this.uploadProgress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    }
                }).then(response => {
                    this.formAccount.avatar = response.data.url;

                    this.uploading = false;
                }).catch(error => {
                });
            },
        }
    }
</script>

<template>
    <div class="card">
        <ul class="nav nav-pills">
            <a class="nav-link" :class="{active: currentTab=='account'}" href="#" v-on:click.prevent="currentTab='account'">Account</a>
            <a v-if="settingDoctor" class="nav-link" :class="{active: currentTab=='doctor'}" href="#" v-on:click.prevent="currentTab='doctor'">Doctor profile</a>
        </ul>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center p-5">
            404 — Data not found
        </div>

        <div class="card-body rounded-bottom">
            <div v-if="currentTab=='account' && ready && entry">
                <form>
                    <div class="form-group row">
                        <div class="col-md-4 col-form-label text-md-right">
                            <img v-if="!uploading"
                                :src="formAccount.avatar"
                                height="50"
                                width="50"
                                class="align-self-center rounded-circle">
                        </div>

                        <label for="user_avatar" class="col-md-auto align-self-center uploadLabel">Upload an avatar</label>

                        <input type="file" class="d-none" id="user_avatar" accept="image/*" v-on:change="uploadSelectedImage">
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                        <div class="col-md-6">
                            <input id="name"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="formAccount.name">

                            <form-errors :errors="formAccount.errors.name"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                        <div class="col-md-6">
                            <input id="email"
                                type="email"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="formAccount.email">

                            <form-errors :errors="formAccount.errors.email"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                        <div class="col-md-6">
                            <input id="password"
                                type="password"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="formAccount.password"
                                placeholder="*****">

                            <form-errors :errors="formAccount.errors.password"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="#" class="btn btn-primary" v-on:click.prevent="saveAccount">
                                Save
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div v-if="currentTab=='doctor'">
                <form>
                    <div class="form-group row">
                        <label for="full_name" class="col-md-4 col-form-label text-md-right">Full name</label>

                        <div class="col-md-6">
                            <input id="full_name"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="formDoctor.full_name">

                            <form-errors :errors="formDoctor.errors.full_name"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="years_of_experience" class="col-md-4 col-form-label text-md-right">Years of experience</label>

                        <div class="col-md-6">
                            <input id="years_of_experience"
                                type="number"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="formDoctor.years_of_experience">

                            <form-errors :errors="formDoctor.errors.years_of_experience"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="qualification" class="col-md-4 col-form-label text-md-right">Qualification</label>

                        <div class="col-md-6">
                            <input id="qualification"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="formDoctor.qualification">

                            <form-errors :errors="formDoctor.errors.qualification"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="doctorSpeciality" class="col-md-4 col-form-label text-md-right">Specializations</label>

                        <div class="col-md-6">
                            <multiselect
                                v-model="formDoctor.specialities"
                                id="doctorSpeciality"
                                label="name"
                                track-by="id"
                                placeholder="Type to search"
                                :options="specialities"
                                :multiple="true"
                                :searchable="true"
                                :loading="isLoading"
                                :clear-on-select="true"
                                :close-on-select="true"
                                :options-limit="5"
                                :limit="5"
                                :limit-text="limitText"
                                :show-no-results="true"
                                :hide-selected="true"
                                @search-change="loadSpesialities">

                                <span slot="noResult">No data found. Consider changing the search query.</span>
                            </multiselect>

                            <form-errors :errors="formDoctor.errors.specialities"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bio" class="col-md-4 col-form-label text-md-right">Bio</label>

                        <div class="col-md-6">
                            <textarea id="bio"
                                v-model="formDoctor.bio"
                                class="form-control bg-light border-0"></textarea>

                            <form-errors :errors="formDoctor.errors.bio"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="#" class="btn btn-primary" v-on:click.prevent="saveDoctorProfile">
                                Save
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .uploadLabel {
        text-decoration: underline;
        cursor: pointer;
    }
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .multiselect__tags {
        border: 0;
        background: #f1f5f8;
    }

    .multiselect__tag {
        background: #40a6c8a6;
    }

    .multiselect__input {
        background: #f1f5f8;
    }

    .multiselect__option--highlight {
        background: #40a6c8a6;
    }

    .multiselect__tag-icon:after {
        color: darken(#40a6c8a6, 15%);
    }

    .multiselect__tag-icon:focus,
    .multiselect__tag-icon:hover {
        background: #40a6c8a6;
    }

    .multiselect__spinner:after,
    .multiselect__spinner:before {
        border-color: #40a6c8;
    }
</style>
