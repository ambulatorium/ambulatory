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
    <modal v-show="$root.alert.type">
        <!-- alert dialog -->
        <div id="modal-dialog" v-if="mode == 'dialog'">
            <div class="modal-container">
                <div class="text-center mb-4">
                    <span class="mt-3 mb-0 font-weight-bold">{{message}}</span>
                </div>

                <!-- information -->
                <div class="d-flex align-items-center justify-content-center">
                    <!-- for errors -->
                    <button v-if="type == 'error'" class="btn btn-block btn-primary rounded-full font-weight-bold" @click="close">
                        OK
                    </button>

                    <!-- for confirmation -->
                    <button v-if="type == 'confirmation'" class="btn btn-block btn-light rounded-full mt-2 mr-1 font-weight-bold" @click="cancel">
                        NO
                    </button>
                    <button v-if="type == 'confirmation'" class="btn btn-block btn-primary rounded-full ml-1 font-weight-bold" @click="confirm">
                        YES
                    </button>
                </div>
            </div>
        </div>

        <!-- alert notification -->
        <div id="modal-flash" v-if="mode == 'flash'">
            <div class="alert alert-primary border-0 rounded-lg shadow-xs">
                <strong>{{message}}</strong>
            </div>
        </div>
    </modal>
</template>
