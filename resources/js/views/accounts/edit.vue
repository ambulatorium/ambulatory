<script type="text/ecmascript-6">
    import SettingTabs from './../../components/SettingTabs';
    import AvatarUpload from './../../components/AvatarUpload';

    export default {
        components: {
            'setting-tabs': SettingTabs,
            'avatar-upload': AvatarUpload,
        },
    }
</script>

<template>
    <form-entry title="Settings" resource="account" redirect-to="settings-account" okToSave>
        <template slot="form-information">
            <setting-tabs activeTab="account"></setting-tabs>
        </template>

        <template slot="entry-data" slot-scope="slotProps">
            <avatar-upload v-model="slotProps.formData.avatar"></avatar-upload>

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right font-weight-bold">Name</label>

                <div class="col-md-6">
                    <input id="name"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.name">

                    <form-errors :errors="slotProps.formErrors.name"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">Email</label>

                <div class="col-md-6">
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
