<script type="text/ecmascript-6">
    export default {
        props: ['mode', 'type', 'message', 'autoClose', 'confirmationProceed', 'confirmationCancel'],

        data() {
            return {
                timeout: null,
            }
        },

        mounted() {
            if (this.autoClose) {
                this.timeout = setTimeout(() => {
                    this.close();
                }, this.autoClose);
            }
        },

        methods: {
            /**
             * Close the alert.
             */
            close() {
                clearTimeout(this.timeout);

                this.$root.alert.mode = null;
                this.$root.alert.type = null;
                this.$root.alert.autoClose = false;
                this.$root.alert.message = '';
                this.$root.alert.confirmationProceed = null;
                this.$root.alert.confirmationCancel = null;
            },

            /**
             * Confirm and close the alert.
             */
            confirm() {
                this.confirmationProceed();

                this.close();
            },

            /**
             * Cancel and close the alert.
             */
            cancel() {
                if (this.confirmationCancel) {
                    this.confirmationCancel();
                }

                this.close();
            }
        }
    }
</script>

<template>
    <div v-show="$root.alert.type">
        <div id="alert" v-if="mode == 'dialog'">
            <div class="dialog rounded">
                <div class="text-center mb-4">
                    <h5 class="mt-3 mb-0 font-weight-bold">{{message}}</h5>
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    <button v-if="type == 'error'" class="btn btn-primary" @click="close">
                        OK
                    </button>

                    <button v-if="type == 'confirmation'" class="btn btn-primary" @click="confirm">
                        YES
                    </button>

                    <button v-if="type == 'confirmation'" class="btn btn-light ml-1" @click="cancel">
                        NO
                    </button>
                </div>
            </div>
        </div>

        <div id="flash" v-if="mode == 'flash'">
            <div class="alert alert-primary border-0 rounded shadow-sm">
                <strong>{{message}}</strong>
            </div>
        </div>
    </div>
</template>

<style>
    #alert {
        position: absolute;
        z-index: 99999;
        width: 100%;
        height: 100%;
        background: #00000080;
    }

    #alert .dialog {
        background: #fff;
        width: 300px;
        margin: 30px auto;
        padding: 20px;
    }

    #flash {
        z-index: 99999;
        position: fixed;
        bottom: 20px;
        right: 10px;
    }
</style>