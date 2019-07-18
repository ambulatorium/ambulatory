<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },

        props: ['value'],

        data() {
            return {
                facilities: [],
                isLoading: false,
                selectedFacility: this.value,
            };
        },

        mounted() {
            this.loadFacilities();
        },

        methods: {
            loadFacilities() {
                this.isLoading = true;

                this.http().get('/api/health-facilities').then(response => {
                    this.facilities = response.data.data;

                    this.isLoading = false;
                }).catch(error => console.error(error));
            },

            handleInput() {
                this.$emit('input', this.selectedFacility);
            }
        }
    }
</script>

<template>
    <multiselect
        v-model="selectedFacility"
        placeholder="Select health facility"
        @input="handleInput"
        label="name"
        track-by="id"
        :loading="isLoading"
        :options="facilities"
        :show-labels="false"
        :searchable="false">
    </multiselect>
</template>
