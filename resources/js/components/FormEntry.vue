<script type="text/ecmascript-6">
    export default {
        props: {
            title: String,
            resource: String,
            okToSave: Boolean,
            okToDelete: Boolean,
        },

        data() {
            return {
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
                this.http().post('/api/' + this.resource + '/' + this.id, this.formData).then(response => {
                    this.$router.push({name: this.resource});

                    this.flashSuccess('Entry saved successfully!', 3000);
                }).catch(error => {
                    this.formErrors = error.response.data.errors;
                });
            },

            deleteEntry() {
                this.alertConfirm("Are you sure you want to delete this entry?", () => {
                    this.http().delete('/api/' + this.resource + '/' + this.id, this.formData).then(response => {
                        this.$router.push({name: this.resource})
                    })
                });
            },
        }
    }
</script>

<template>
    <div class="card">
        <div class="card-header">
            <h1>{{this.title}}</h1>
        </div>

        <slot name="form-information"></slot>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="p-5">
            <p class="text-center">No data were found</p>
        </div>

        <div class="card-body" v-if="ready && entry">
            <form>
                <slot name="entry-data" :formData="formData" :formErrors="formErrors"></slot>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <a href="#" class="btn btn-primary" v-if="okToSave" @click="saveEntry">
                            Save
                        </a>
                        <a href="#" class="btn btn-danger" v-if="okToDelete && id != 'new'" @click="deleteEntry">
                            Delete
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
