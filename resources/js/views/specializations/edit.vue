<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                entry: null,
                ready: false,
                id: this.$route.params.id || 'new',
                form: {
                    errors: [],
                    name: '',
                    description: ''
                }
            };
        },

        mounted() {
            document.title = "Specializations — Reliqui Ambulatory";

            this.id != 'new'
                ? this.getSpecialization()
                : this.entry = [], this.ready = true;
        },

        methods: {
            getSpecialization() {
                this.http().get('/api/specializations/' + this.id).then(response => {
                    this.entry = response.data.entry;

                    this.form.name = response.data.entry.name;
                    this.form.description = response.data.entry.description;

                    this.ready = true;
                }).catch(error => {
                    this.ready = true;
                });
            },

            saveSpecialization() {
                this.form.errors = [];

                this.http().post('/api/specializations/' + this.id, this.form).then(response => {
                    this.$router.push({name: 'specializations'});

                    this.flashSuccess('Specialization saved successfully!', 3000);
                }).catch(error => {
                    this.form.errors = error.response.data.errors;
                });
            },

            deleteSpecialization() {
                this.alertConfirm("Are you sure you want to delete this specialization?", () => {
                    this.http().delete('/api/specializations/' + this.id, this.form).then(response => {
                        this.$router.push({name: 'specializations'})
                    })
                });
            },
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header">
            <h1>Specialization</h1>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center p-5">
            404 — Specialization not found
        </div>

        <div v-if="ready && entry">
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right font-weight-bold">Name</label>

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
                        <label for="description" class="col-md-4 col-form-label text-md-right font-weight-bold">Description</label>

                        <div class="col-md-6">
                            <input id="description"
                                type="text"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.description">

                            <form-errors :errors="form.errors.description"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="#" class="btn btn-primary" @click="saveSpecialization">
                                Save
                            </a>
                            <a href="#" class="btn btn-danger" @click="deleteSpecialization" v-if="id != 'new'">
                                Delete
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>