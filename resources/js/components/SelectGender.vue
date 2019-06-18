<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },

        props: ['value'],

        data() {
            return {
                gender: [],
                selectedGender: this.value,
            }
        },

        mounted() {
            this.gender = ['Male', 'Female'];
        },

        methods: {
            handleInput() {
                this.$emit('input', this.selectedGender);
            }
        }
    }
</script>

<template>
    <multiselect
        v-model="selectedGender"
        placeholder="Select gender"
        @input="handleInput"
        :options="gender"
        :show-labels="false"
        :searchable="false">
    </multiselect>
</template>