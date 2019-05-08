<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                entry: null,
                ready: false,
                id: this.$route.params.id || 'new',
                form: {
                    errors: [],
                    working: false,
                    id: '',
                    email: '',
                    role: ''
                }
            };
        },

        mounted() {
            document.title = "Invitation — Reliqui Ambulatory";

            this.http().get('/api/invitations/' + this.id).then(response => {
                this.entry = response.data.entry;

                this.form.id = response.data.entry.id;

                if (this.id != 'new') {
                    this.form.email = response.data.entry.email;
                    this.form.role = response.data.entry.role;
                }

                this.ready = true;
            }).catch(error => {
                this.ready = true;
            });
        },

        methods: {
            deleteInvitation(){
                this.alertConfirm("Are you sure you want to delete this invitation?", () => {
                    this.http().delete('/api/invitations/' + this.id, this.form).then(response => {
                        this.$router.push({name: 'invitations'})
                    })
                });
            },

            saveInvitation() {
                this.form.working = true;
                this.form.errors = [];

                this.http().post('/api/invitations/' + this.id, this.form).then(response => {
                    this.form.working = false;

                    this.$router.push({name: 'invitations'});

                    this.flashSuccess('Invitation sent successfully!', 3000);
                }).catch(error => {
                    this.form.errors = error.response.data.errors;

                    this.form.working = false;
                });
            }
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header">
            <h1>Invitation</h1>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center p-5">
            404 — Invitation not found
        </div>

        <div v-if="ready && entry">
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right font-weight-bold">Role</label>

                        <div class="col-md-6">
                            <select id="role" v-model="form.role" class="custom-select custom-select-lg bg-light border-0">
                                <option disabled value="">Please select one</option>
                                <option>Doctor</option>
                                <option>Admin</option>
                            </select>

                            <form-errors :errors="form.errors.role"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">E-mail Address</label>

                        <div class="col-md-6">
                            <input id="email"
                                type="email"
                                class="form-control form-control-lg bg-light border-0"
                                v-model="form.email">

                            <form-errors :errors="form.errors.email"></form-errors>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="#" class="btn btn-primary" @click="saveInvitation">
                                <div v-if="form.working">
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Please wait...
                                </div>

                                <div v-else>
                                    Send
                                </div>
                            </a>
                            <a href="#" class="btn btn-danger" @click="deleteInvitation" v-if="id != 'new'">
                                Delete
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>