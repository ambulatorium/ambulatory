<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <form-entry title="Health Facility" resource="health-facilities" okToSave>
        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label text-md-right font-weight-bold">Name</label>

                <div class="col-sm-6">
                    <input id="name"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.name"
                        autofocus>

                    <form-errors :errors="slotProps.formErrors.name"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-4 col-form-label text-md-right font-weight-bold">Address</label>

                <div class="col-sm-6">
                    <input id="address"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.address">

                    <form-errors :errors="slotProps.formErrors.address"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="city" class="col-sm-4 col-form-label text-md-right font-weight-bold">City</label>

                <div class="col-md-6">
                    <input id="city"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.city">

                    <form-errors :errors="slotProps.formErrors.city"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="state" class="col-sm-4 col-form-label text-md-right font-weight-bold">State</label>

                <div class="col-md-6">
                    <input id="state"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.state">

                    <form-errors :errors="slotProps.formErrors.state"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="country" class="col-sm-4 col-form-label text-md-right font-weight-bold">Country</label>

                <div class="col-sm-6">
                    <input id="country"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.country">

                    <form-errors :errors="slotProps.formErrors.country"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="zip_code" class="col-sm-4 col-form-label text-md-right font-weight-bold">ZIP Code</label>

                <div class="col-md-6">
                    <input id="zip_code"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.zip_code">

                    <form-errors :errors="slotProps.formErrors.zip_code"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>