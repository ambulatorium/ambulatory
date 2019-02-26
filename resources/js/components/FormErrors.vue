<script type="text/ecmascript-6">

    export default {
        components: {},

        props: ['errors'],

        data(){
            return {}
        },


        mounted() {

        },


        methods: {}
    }
</script>

<template>
<div>
    <div class="text-danger pt-1" v-for="error in errors">
        {{error}}
    </div>
</div>
</template>