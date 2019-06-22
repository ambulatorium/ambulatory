<script type="text/ecmascript-6">
    export default {
        props: {
            title: String,
            resource: String,
            okToSave: Boolean,
            okToUpdate: Boolean,
            okToDelete: Boolean,
            redirectTo: String,
        },

        data() {
            return {
                redirectName: this.redirectTo || this.resource,
                entry: null,
                ready: false,
                formData: {},
                formErrors: [],
                id: this.$route.params.id || 'new',
            };
        },

        mounted() {
            document.title = this.title + " — Reliqui Ambulatory";

            this.id != 'new'
                ? this.getEntry()
                : this.entry = [], this.ready = true;
        },

        methods: {
            getEntry() {
                this.http().get('/api/' + this.resource + '/' + this.id).then(response => {
                    this.entry = response.data.entry;

                    this.formData = response.data.entry;

                    this.ready = true;
                }).catch(error => {
                    this.ready = true;
                });
            },

            saveEntry() {
                this.http().post('/api/' + this.resource, this.formData).then(response => {
                    this.$router.push({name: this.redirectName});

                    this.alertSuccess('Entry successfully saved!', 3000);
                }).catch(error => {
                    this.formErrors = error.response.data.errors;
                });
            },

            updateEntry() {
                this.http().patch('/api/' + this.resource + '/' + this.id, this.formData).then(response => {
                    this.$router.push({name: this.redirectName});

                    this.alertSuccess('Entry successfully updated!', 3000);
                }).catch(error => {
                    this.formErrors = error.response.data.errors;
                });
            },

            deleteEntry() {
                this.alertConfirm("Are you sure you want to delete this entry?", () => {
                    this.http().delete('/api/' + this.resource + '/' + this.id, this.formData).then(response => {
                        this.$router.push({name: this.redirectName});

                        this.alertSuccess('Entry successfully deleted!', 3000);
                    });
                });
            },
        }
    }
</script>

<template>
    <div class="card">
        <!-- header -->
        <div id="card-header" class="card-header d-flex align-items-center justify-content-between sticky-top">
            <h1>{{this.title}}</h1>
        </div>

        <!-- alert content -->
        <slot name="form-information"></slot>

        <!-- loader -->
        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="p-5">
            <p class="text-center">No data were found</p>
        </div>

        <!-- data entry -->
        <div class="card-body" v-if="ready && entry">
            <form>
                <slot name="entry-data" :formData="formData" :formErrors="formErrors"></slot>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <div v-if="id != 'new'">
                            <a href="#" class="btn btn-info" v-if="okToUpdate" @click="updateEntry">Update</a>
                            <a href="#" class="btn btn-danger" v-if="okToDelete" @click="deleteEntry">Delete</a>
                        </div>

                        <div v-else>
                            <a href="#" class="btn btn-primary" v-if="okToSave" @click="saveEntry">Save</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
