<script type="text/ecmascript-6">
    export default {
        methods: {
            onFileChange(e) {
                if (!e.target.files.length) return;

                let file = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = e => {
                    let src = e.target.result;

                };
                this.$emit('loaded', {src, file});
            }
        }
    }
</script>

<template>
    <div>
        <div slot="picker">
            <label for="image" class="col-md-auto align-self-center uploadLabel font-weight-bold">Upload an avatar</label>
        </div>

        <input
            id="image"
            type="file"
            ref="file"
            class="d-none"
            accept="image/*"
            @change="onFileChange">
    </div>
</template>
