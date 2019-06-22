<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect';
    import SettingTabs from './../../components/SettingTabs';

    export default {
        components: {
            'setting-tabs': SettingTabs,
            'multi-select': Multiselect,
        },

        data() {
            return {
                specializations: [],
                isLoading: false,
            };
        },

        methods: {
            loadSpecializations() {
                this.isLoading = true;

                this.http().get('/api/specializations').then(response => {
                    this.specializations = response.data.entries.data;

                    this.isLoading = false;
                }).catch(error => {
                    this.isLoading = false;
                });
            },

            limitText (count) {
                return `and ${count} other specializations`
            },
        }
    }
</script>

<template>
    <form-entry title="Settings" resource="doctor-profile" redirect-to="settings-doctor-profile" okToSave okToUpdate>
        <template slot="form-information">
            <setting-tabs activeTab="doctorProfile"></setting-tabs>
        </template>

        <template slot="entry-data" slot-scope="slotProps">
            <div class="form-group row">
                <label for="full_name" class="col-md-4 col-form-label text-md-right font-weight-bold">Full Name</label>

                <div class="col-md-6">
                    <input id="full_name"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.full_name">

                    <form-errors :errors="slotProps.formErrors.full_name"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="practicing_from" class="col-md-4 col-form-label text-md-right font-weight-bold">Practicing From</label>

                <div class="col-md-6">
                    <input id="practicing_from"
                        type="date"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.practicing_from">

                    <form-errors :errors="slotProps.formErrors.practicing_from"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="qualification" class="col-md-4 col-form-label text-md-right font-weight-bold">Qualification</label>

                <div class="col-md-6">
                    <input id="qualification"
                        type="text"
                        class="form-control form-control-lg bg-light border-0"
                        v-model="slotProps.formData.qualification">

                    <form-errors :errors="slotProps.formErrors.qualification"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="specializations" class="col-md-4 col-form-label text-md-right font-weight-bold">Specializations</label>

                <div class="col-md-6">
                    <multi-select
                        v-model="slotProps.formData.specializations"
                        id="specializations"
                        label="name"
                        track-by="id"
                        placeholder="Type to search specializations"
                        :options="specializations"
                        :multiple="true"
                        :searchable="true"
                        :loading="isLoading"
                        :clear-on-select="true"
                        :close-on-select="true"
                        :options-limit="5"
                        :limit="5"
                        :limit-text="limitText"
                        :show-no-results="true"
                        :hide-selected="true"
                        @search-change="loadSpecializations">

                        <span slot="noResult">No data found. Consider changing the search query.</span>
                    </multi-select>

                    <form-errors :errors="slotProps.formErrors.specializations"></form-errors>
                </div>
            </div>

            <div class="form-group row">
                <label for="professional_statement" class="col-md-4 col-form-label text-md-right font-weight-bold font-weight-bold">Professional Statement</label>

                <div class="col-md-6">
                    <textarea id="professional_statement"
                        class="form-control bg-light border-0"
                        v-model="slotProps.formData.professional_statement"></textarea>

                    <form-errors :errors="slotProps.formErrors.professional_statement"></form-errors>
                </div>
            </div>
        </template>
    </form-entry>
</template>
