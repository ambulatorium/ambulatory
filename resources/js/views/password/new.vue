<script type="text/ecmascript-6">
    import SettingTabs from './../../components/SettingTabs';

    export default {
        components: {
            'setting-tabs': SettingTabs,
        },
    }
</script>

<template>
    <form-entry title="Settings" resource="new-password" redirect-to="inbox" okToSave>
        <template slot="form-information">
            <setting-tabs activeTab="newPassword"></setting-tabs>
        </template>

        <template slot="entry-data" slot-scope="slotProps">

            <div class="form-group row">
                <label for="current_password" class="col-md-4 col-form-label text-md-right font-weight-bold">
                    Current Password
                </label>

                <div class="col-md-6">
                    <input id="current_password"
                        type="password"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.current_password">

                    <form-errors :errors="slotProps.formErrors.current_password"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">
                    New Password
                </label>

                <div class="col-md-6">
                    <input id="password"
                        type="password"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.new_password">

                    <form-errors :errors="slotProps.formErrors.new_password"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right font-weight-bold">
                    Confirm Password
                </label>

                <div class="col-md-6">
                    <input id="password-confirm"
                        type="password"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.confirm_new_password">

                    <form-errors :errors="slotProps.formErrors.confirm_new_password"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>