<script type="text/ecmascript-6">
    export default {
        props: ['type', 'message', 'autoClose'],

        data() {
            return {
                timeout: null
            }
        },

        mounted() {
            this.timeout = setTimeout(() => {
                this.close();
            }, this.autoClose);
        },

        methods: {
            /**
             * Close the flash.
             */
            close() {
                clearTimeout(this.timeout);

                this.$root.flash.type = null;
                this.$root.flash.autoClose = false;
                this.$root.flash.message = '';
            }
        }
    }
</script>

<template>
    <div id="flashBody" class="alert alert-primary border-0 rounded shadow-sm">
        <strong>{{message}}</strong>
    </div>
</template>

<style>
    #flashBody {
        z-index: 99999;
        position: fixed;
        bottom: 20px;
        right: 10px;
    }
</style>