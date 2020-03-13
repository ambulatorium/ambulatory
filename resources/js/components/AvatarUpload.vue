<script type="text/ecmascript-6">
    export default {
        props: ['value'],

        data() {
            return {
                uploading: false,
                uploadProgress: 0,
                avatar: this.value,
            }
        },

        methods: {
            uploadSelectedImage(event) {
                let file = event.target.files[0];
                let data = new FormData();

                data.append('image', file, file.name);

                this.uploading = true;

                this.http().post('/api/uploads-user-avatar', data, {
                    onUploadProgress: progressEvent => {
                        this.uploadProgress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    }
                }).then(response => {
                    this.avatar = response.data.url;

                    this.uploading = false;

                    this.$emit('input', this.avatar);
                }).catch(error => console.error(error));
            },
        }
    }
</script>

<template>
    <div class="form-group row">
        <div class="col-md-4 col-form-label text-md-right">
            <img v-if="!uploading"
                height="50"
                width="50"
                class="align-self-center rounded-circle"
                :src="avatar">

            <div v-if="uploading" class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <label for="avatar" class="col-md-auto align-self-center uploadLabel font-weight-bold">Upload an avatar</label>

        <input type="file" class="d-none" id="avatar" accept="image/*" @change="uploadSelectedImage">
    </div>
</template>

<style scoped>
    .uploadLabel {
        text-decoration: underline;
        cursor: pointer;
    }
</style>