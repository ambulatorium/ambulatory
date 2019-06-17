<script type="text/ecmascript-6">
    export default {}
</script>

<template>
    <form-entry title="Invitation" resource="invitations" okToSave okToUpdate okToDelete>
        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="role" class="col-sm-4 col-form-label text-md-right font-weight-bold">Role</label>

                <div class="col-sm-6">
                    <select id="role"
                        v-model="slotProps.formData.role"
                        class="custom-select custom-select-lg bg-light border-0">
                        <option disabled value="">Please select one role</option>
                        <option>Doctor</option>
                        <option>Admin</option>
                    </select>

                    <form-errors :errors="slotProps.formErrors.role"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right font-weight-bold">E-mail Address</label>

                <div class="col-sm-6">
                    <input id="email"
                        type="email"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.email">

                    <form-errors :errors="slotProps.formErrors.email"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>