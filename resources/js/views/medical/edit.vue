<script type="text/ecmascript-6">
    import SelectGender from './../../components/SelectGender';
    import MaritalStatus from './../../components/SelectMaritalStatus';

    export default {
        components: {
            'select-gender': SelectGender,
            'select-marital-status': MaritalStatus,
        }
    }
</script>

<template>
    <form-entry title="Medical Form" resource="medical-forms" okToSave okToUpdate>
        <div slot="form-information" class="alert alert-info form-info d-flex rounded-0 m-0">
            <div class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-info">
                    <path d="M10 20C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10-4.477 10-10 10zm0-2c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm-.5-5h1c.276 0 .5.224.5.5v1c0 .276-.224.5-.5.5h-1c-.276 0-.5-.224-.5-.5v-1c0-.276.224-.5.5-.5zm0-8h1c.276 0 .5.224.5.5V8l-.5 3-1 .5L9 8V5.5c0-.276.224-.5.5-.5z"></path>
                </svg>
            </div>
            <span>
                This Medical form is about the patient's biodata,
                you can have more than one form for your family,
                so please answer thoughtfully and carefully.
            </span>
        </div>

        <template slot="entry-data" slot-scope="slotProps">
            <div class="row border-bottom pb-4">
                <div class="col-sm-4">
                    <h5 class="text-dark">Medical form name</h5>
                    <small>
                        Give this form a name. e.g <mark>My Form</mark>, <mark>My Grandpa</mark>
                        or whatever is appropriate.
                    </small>
                </div>
                <div class="col-sm-8">
                    <input
                        type="text"
                        class="form-control bg-light border-0"
                        v-model="slotProps.formData.form_name"
                        placeholder="my-form"
                        autofocus>

                    <form-errors :errors="slotProps.formErrors.form_name"></form-errors>
                </div>
            </div>

            <div class="row mt-4 border-bottom">
                <div class="col-sm-4">
                    <h5 class="text-dark">Patient details</h5>
                    <small>All fields other than home phone ones are required.</small>
                </div>

                <div class="col-sm-8">
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="full_name">Full name</label>
                            <input
                                id="full_name"
                                type="text"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.full_name"
                                placeholder="Patient form name">

                            <form-errors :errors="slotProps.formErrors.full_name"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="dob">Date of birth</label>
                            <input
                                id="dob"
                                type="date"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.dob">

                            <form-errors :errors="slotProps.formErrors.dob"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="gender">Gender</label>
                            <select-gender id="gender" v-model="slotProps.formData.gender"></select-gender>

                            <form-errors :errors="slotProps.formErrors.gender"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="city">City</label>
                            <input
                                id="city"
                                type="text"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.city"
                                placeholder="city">

                            <form-errors :errors="slotProps.formErrors.city"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="state">State</label>
                            <input
                                id="state"
                                type="text"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.state"
                                placeholder="state">

                            <form-errors :errors="slotProps.formErrors.state"></form-errors>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="address">Address</label>
                            <input
                                id="address"
                                type="text"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.address"
                                placeholder="address">

                            <form-errors :errors="slotProps.formErrors.address"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="zip_code">Zip Code</label>
                            <input
                                id="zip_code"
                                type="text"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.zip_code"
                                placeholder="zip code">

                            <form-errors :errors="slotProps.formErrors.zip_code"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="home_phone">Home phone number</label>
                            <input
                                id="home_phone"
                                type="number"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.home_phone"
                                placeholder="home phone">

                            <form-errors :errors="slotProps.formErrors.home_phone"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="cell_phone">Cell phone number</label>
                            <input
                                id="cell_phone"
                                type="number"
                                class="form-control bg-light border-0"
                                v-model="slotProps.formData.cell_phone"
                                placeholder="cell phone">

                            <form-errors :errors="slotProps.formErrors.cell_phone"></form-errors>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="marital_status">Marital status</label>
                            <select-marital-status id="marital_status" v-model="slotProps.formData.marital_status"></select-marital-status>

                            <form-errors :errors="slotProps.formErrors.marital_status"></form-errors>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-4">
                    <h5 class="text-dark">What's Next?</h5>
                </div>
                <div class="col-sm-8">
                    <p class="text-dark">
                        Once you have the medical form, you can select the form when book an appointment.
                    </p>
                </div>
            </div>
        </template>
    </form-entry>
</template>