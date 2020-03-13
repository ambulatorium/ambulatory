<script type="text/ecmascript-6">
    import SettingTabs from './../../components/SettingTabs';
    import ImageInput from './../../components/ImageInput';

    export default {
        components: {
            'setting-tabs': SettingTabs,
            'image-input': ImageInput,
        },

        data() {
            return {
                image: null,
                ready: false,
                formData: {},
                formErrors: [],
            };
        },

        mounted() {
            document.title = "Settings — Ambulatory";

            this.http().get('/api/account').then(response => {
                this.formData = response.data;

                this.ready = true;
            });
        },

        methods: {
            updateAccount() {
                this.http().patch('/api/account', this.formData).then(response => {
                    this.$router.go();

                    this.alertSuccess('Account successfully saved!', 3000);
                }).catch(error => {
                    this.formErrors = error.response.data.errors;
                });
            },

            loadImage(avatar) {
                this.formData.avatar = avatar.src;

                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                this.image = data;
            }
        }
    }
</script>

<template>
    <div class="card">
        <!-- header -->
        <div id="card-header" class="card-header d-flex align-items-center justify-content-between sticky-top">
            <h1>Settings</h1>
        </div>

        <setting-tabs activeTab="account"></setting-tabs>

        <!-- loader -->
        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="card-body" v-if="ready && formData">
            <form @submit.prevent="updateAccount" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-md-4 col-form-label text-md-right">
                        <img height="50" width="50" class="align-self-center rounded-circle" :src="formData.avatar">
                    </div>

                    <image-input v-model="formData.avatar" @loaded="loadImage" class="mt-3"></image-input>

                    <form-errors :errors="formErrors.avatar"></form-errors>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right font-weight-bold">Display name</label>

                    <div class="col-md-6">
                        <input id="name"
                            type="text"
                            class="form-control form-control-lg bg-light border-0"
                            v-model="formData.name">

                        <form-errors :errors="formErrors.name"></form-errors>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">Email</label>

                    <div class="col-md-6">
                        <input id="email"
                            type="email"
                            class="form-control form-control-lg bg-light border-0"
                            v-model="formData.email">

                        <form-errors :errors="formErrors.email"></form-errors>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary font-weight-bold rounded-full">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
