<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            'select-role': Multiselect,
        },

        data() {
            return {
                roles: ['Doctor', 'Admin'],
            }
        }
    }
</script>

<template>
    <form-entry title="Invitation" resource="invitations" okToSave okToUpdate okToDelete>
        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="role" class="col-sm-4 col-form-label text-md-right font-weight-bold">Role</label>

                <div class="col-sm-6">
                    <select-role
                        v-model="slotProps.formData.role"
                        placeholder="Select role"
                        :options="roles"
                        :show-labels="false"
                        :searchable="false">
                    </select-role>

                    <form-errors :errors="slotProps.formErrors.role"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right font-weight-bold">E-mail Address</label>

                <div class="col-sm-6">
                    <input id="email"
                        type="email"
                        class="form-control bg-light border-0"
                        v-model="slotProps.formData.email">

                    <form-errors :errors="slotProps.formErrors.email"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>