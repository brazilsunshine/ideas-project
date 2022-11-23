<template>
    <div class="container mx-auto max-w-custom flex flex-col">
        <p v-if="loading">
            Loading...
        </p>

        <div v-else>
            <p>
                Profile vue
            </p>

            <p>
                Upload image
            </p>
            <img
                :src="user.profile_image.url"
                style="max-width: 300px;"
                alt=""
            />
            <div>
                <vue-dropzone
                    id="customdropzone"
                    :options="options"
                    :use-custom-slot="true"
                >
                    <i class="fa fa-image upload-icon" aria-hidden="true"/>
                </vue-dropzone>
            </div>
        </div>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone';

export default {
    name: "Profile",
    components: {
        vueDropzone: vue2Dropzone
    },
    data ()
    {
        return {
            loading: true,
            options: {
                url: '/api/profile/upload-image',
                thumbnailWidth: 150,
                maxFilesize: 20,
                headers: {
                    'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']
                },
                includeStyling: true,
                duplicateCheck: true,
                paramName: 'file',
                acceptedFiles: 'image/*,.heic,.heif'
            },
        }
    },
    created ()
    {
        this.loading = false;
    },
    computed: {
        /**
         * Return true if the user is logged in
         */
        auth ()
        {
            return this.$store.state.user.auth;
        },

        /**
         *
         */
        user ()
        {
            return this.$store.state.user.userObject;
        }
    },
}
</script>

<style scoped>

</style>
