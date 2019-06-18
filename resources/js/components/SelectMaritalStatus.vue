<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },

        props: ['value'],

        data() {
            return {
                status: [],
                selectedStatus: this.value,
            }
        },

        mounted() {
            this.status = ['Married', 'Single', 'Divorced', 'Separated'];
        },

        methods: {
            handleInput() {
                this.$emit('input', this.selectedStatus);
            }
        }
    }
</script>

<template>
    <multiselect
        v-model="selectedStatus"
        placeholder="Select status"
        @input="handleInput"
        :options="status"
        :show-labels="false"
        :searchable="false">
    </multiselect>
</template>