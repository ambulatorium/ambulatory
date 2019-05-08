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
                    form_name: '',
                    full_name: '',
                    dob: '',
                    gender: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: '',
                    home_phone: '',
                    cell_phone: '',
                    marital_status: '',
                }
            };
        },

        mounted() {
            document.title = "Medical Form — Reliqui Ambulatory";

            this.http().get('/api/medical-form/' + this.id).then(response => {
                this.entry = _.cloneDeep(response.data.entry);

                this.fillForm(response.data.entry);

                this.ready = true;
            }).catch(error => {
                this.ready = true;
            });
        },

        methods: {
            fillForm(data) {
                this.form.id = data.id;

                if (this.id != 'new') {
                    this.form.form_name = data.form_name;
                    this.form.full_name = data.full_name;
                    this.form.dob = data.dob;
                    this.form.gender = data.gender;
                    this.form.address = data.address;
                    this.form.city = data.city;
                    this.form.state = data.state;
                    this.form.zip_code = data.zip_code;
                    this.form.home_phone = data.home_phone;
                    this.form.cell_phone = data.cell_phone;
                    this.form.marital_status = data.marital_status;
                }
            },

            saveResource() {
                this.form.errors = [];

                this.http().post('/api/medical-form/' + this.id, this.form).then(response => {
                    this.$router.push({name: 'medical-form'});

                    this.flashSuccess('Medical form saved successfully!', 2000);
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
            <h1>Medical form</h1>
        </div>

        <div class="alert alert-info form-title-section d-flex rounded-0">
            <div class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-info">
                    <path d="M10 20C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10-4.477 10-10 10zm0-2c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm-.5-5h1c.276 0 .5.224.5.5v1c0 .276-.224.5-.5.5h-1c-.276 0-.5-.224-.5-.5v-1c0-.276.224-.5.5-.5zm0-8h1c.276 0 .5.224.5.5V8l-.5 3-1 .5L9 8V5.5c0-.276.224-.5.5-.5z"></path>
                </svg>
            </div>

            <div>
                This Medical form is about the patient's biodata,
                you can have more than one form for your family,
                so please answer thoughtfully and carefully.
            </div>
        </div>

        <div v-if="!ready" class="d-flex align-items-center justify-content-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-if="ready && !entry" class="text-center">
            404 — Medical form not found
        </div>

        <div v-if="ready && entry" class="card-body">
            <div class="row mb-4 border-bottom pb-4">
                <div class="col-sm-4">
                    <h6 class="text-dark"><strong>Medical form name</strong></h6>
                    <small class="text-muted">
                        Give this form a name. e.g <mark>My Form</mark>, <mark>My Grandpa</mark>
                        or whatever is appropriate.
                    </small>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text"
                                class="form-control bg-light border-0"
                                v-model="form.form_name"
                                placeholder="my-form"
                                autofocus>

                            <form-errors :errors="form.errors.form_name"></form-errors>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 border-bottom pb-4">
                <div class="col-sm-4">
                    <h6 class="text-dark"><strong>Patient details</strong></h6>
                    <small class="text-muted">
                        All fields other than home phone ones are required.
                    </small>
                </div>
                <div class="col-sm-8">
                    <div class="row pb-2">
                        <div class="col-sm-12 pb-2">
                            <input type="text"
                                class="form-control bg-light border-0"
                                v-model="form.full_name"
                                placeholder="Patient form name">

                            <form-errors :errors="form.errors.full_name"></form-errors>
                        </div>
                        <div class="col-sm-6">
                            <input type="date"
                                class="form-control bg-light border-0"
                                v-model="form.dob">

                            <small class="form-text text-muted">date of birth</small>

                            <form-errors :errors="form.errors.dob"></form-errors>
                        </div>
                        <div class="col-sm-6">
                            <select v-model="form.gender" id="gender" class="custom-select bg-light border-0">
                                <option value="Male">
                                    Male
                                </option>
                                <option value="Female">
                                    Female
                                </option>
                            </select>

                            <form-errors :errors="form.errors.gender"></form-errors>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-sm-6">
                            <input type="text"
                                class="form-control bg-light border-0"
                                v-model="form.city"
                                placeholder="city">

                            <form-errors :errors="form.errors.city"></form-errors>
                        </div>
                        <div class="col-sm-6">
                            <input type="text"
                                class="form-control bg-light border-0"
                                v-model="form.state"
                                placeholder="state">

                            <form-errors :errors="form.errors.state"></form-errors>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-sm-6">
                            <input type="text"
                                class="form-control bg-light border-0"
                                v-model="form.address"
                                placeholder="address">

                            <form-errors :errors="form.errors.address"></form-errors>
                        </div>
                        <div class="col-sm-6">
                            <input type="text"
                                class="form-control bg-light border-0"
                                v-model="form.zip_code"
                                placeholder="zip code">

                            <form-errors :errors="form.errors.zip_code"></form-errors>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-sm-6">
                            <input type="number"
                                class="form-control bg-light border-0"
                                v-model="form.home_phone"
                                placeholder="home phone">

                            <form-errors :errors="form.errors.home_phone"></form-errors>
                        </div>
                        <div class="col-sm-6">
                            <input type="number"
                                class="form-control bg-light border-0"
                                v-model="form.cell_phone"
                                placeholder="cell phone">

                            <form-errors :errors="form.errors.cell_phone"></form-errors>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-sm-6">
                            <select v-model="form.marital_status" id="marital_status" class="custom-select bg-light border-0">
                                <option value="Married">
                                    Married
                                </option>
                                <option value="Single">
                                    Single
                                </option>
                                <option value="Divorced">
                                    Divorced
                                </option>
                            </select>

                            <form-errors :errors="form.errors.marital_status"></form-errors>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <h5 class="text-dark">What's Next?</h5>
                </div>
                <div class="col-sm-8">
                    <p class="text-dark">
                        Once you have the medical form, you can select the form when making an appointment.
                    </p>

                    <button type="submit" class="btn btn-primary" @click="saveResource">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>