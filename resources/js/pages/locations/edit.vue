<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                entry: null,
                ready: false,
                id: this.$route.params.id || 'new',
                form: {
                    errors: [],
                    id: '',
                    name: '',
                    address: '',
                    city: '',
                    state: '',
                    country: '',
                    zip_code: '',
                }
            };
        },

        mounted() {
            document.title = "Healthcare Locations — Reliqui";

            this.http().get('/api/healthcare-locations/' + this.id).then(response => {
                this.entry = response.data.entry;

                this.form.id = response.data.entry.id;

                if (this.id != 'new') {
                    this.form.name = response.data.entry.name;
                    this.form.address = response.data.entry.address;
                    this.form.city = response.data.entry.city;
                    this.form.state = response.data.entry.state;
                    this.form.country = response.data.entry.country;
                    this.form.zip_code = response.data.entry.zip_code;
                }

                this.ready = true;
            }).catch(error => {
                this.ready = true;
            });
        },

        methods: {
            deleteLocation(){
                this.alertConfirm("Are you sure you want to delete this location ?", () => {
                    this.http().delete('/api/healthcare-locations/' + this.id, this.form).then(response => {
                        this.$router.push({name: 'locations'})
                    })
                });
            },

            save() {
                this.form.errors = [];

                this.http().post('/api/healthcare-locations/' + this.id, this.form).then(response => {
                    this.$router.push({name: 'locations'});

                    this.flashSuccess('Location saved successfully!', 2000);
                }).catch(error => {
                    this.form.errors = error.response.data.errors;
                });
            }
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h1>Location of healthcare facilities</h1>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center p-5">
            404 — Location not found
        </div>

        <div v-if="ready && entry">
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                        <div class="col-md-6">
                            <input id="name"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.name"
                                autofocus>

                            <form-errors :errors="form.errors.name"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                        <div class="col-md-6">
                            <input id="address"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.address"
                                autofocus>

                            <form-errors :errors="form.errors.address"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="city" class="col-md-4 col-form-label text-md-right">City</label>

                        <div class="col-md-6">
                            <input id="city"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.city">

                            <form-errors :errors="form.errors.city"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="state" class="col-md-4 col-form-label text-md-right">State</label>

                        <div class="col-md-6">
                            <input id="state"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.state">

                            <form-errors :errors="form.errors.state"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

                        <div class="col-md-6">
                            <input id="country"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.country">

                            <form-errors :errors="form.errors.country"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zip_code" class="col-md-4 col-form-label text-md-right">ZIP Code</label>

                        <div class="col-md-6">
                            <input id="zip_code"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.zip_code">

                            <form-errors :errors="form.errors.zip_code"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="#" class="btn btn-primary" @click="save">
                                Save
                            </a>
                            <a href="#" class="btn btn-danger" @click="deleteLocation" v-if="id != 'new'">
                                Delete this location
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>