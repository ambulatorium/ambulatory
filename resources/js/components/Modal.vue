<script type="text/ecmascript-6">
    export default {
        created() {
            document.body.classList.add('overflow-hidden');
            document.getElementById('card-header').classList.remove('sticky-top');
        },

        destroyed() {
            document.body.classList.remove('overflow-hidden');
            document.getElementById('card-header').classList.add('sticky-top');
        },
    }
</script>

<template>
    <transition name="modal">
        <slot/>
    </transition>
</template>
