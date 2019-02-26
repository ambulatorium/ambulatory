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
                    description: ''
                }
            };
        },

        mounted() {
            document.title = "Specialities — Reliqui";

            this.http().get('/api/specialities/' + this.id).then(response => {
                this.entry = response.data.entry;

                this.form.id = response.data.entry.id;

                if (this.id != 'new') {
                    this.form.name = response.data.entry.name;
                    this.form.description = response.data.entry.description;
                }

                this.ready = true;
            }).catch(error => {
                this.ready = true;
            });
        },

        methods: {
            deleteSpeciality(){
                this.alertConfirm("Are you sure you want to delete this speciality ?", () => {
                    this.http().delete('/api/specialities/' + this.id, this.form).then(response => {
                        this.$router.push({name: 'specialities'})
                    })
                });
            },

            save() {
                this.form.errors = [];

                this.http().post('/api/specialities/' + this.id, this.form).then(response => {
                    this.$router.push({name: 'specialities'});

                    this.flashSuccess('Speciality saved successfully!', 2000);
                }).catch(error => {
                    this.form.errors = error.response.data.errors;
                });
            }
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header">
            <h1>Speciality</h1>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center p-5">
            404 — Speciality not found
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
                        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

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
                            <a href="#" class="btn btn-primary" @click="save">
                                Save
                            </a>
                            <a href="#" class="btn btn-danger" @click="deleteSpeciality" v-if="id != 'new'">
                                Delete this speciality
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>