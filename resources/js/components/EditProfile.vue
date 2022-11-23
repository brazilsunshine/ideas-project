<template>
    <div class="container bg-white border-2 border-blue rounded-xl mt-16">
        <p v-if="loading">
            Loading...
        </p>
        <div v-else>
            <div v-if="auth">
                <form
                    method="post"
                    @submit.prevent="submit"
                    class="text-sm space-y-4 px-4 py-6"
                >
                    <p>
                        Upload image
                    </p>
                    <div style="display: flex; justify-content: space-between;">
                        <img
                            v-if="user.profile_image"
                            :src="user.profile_image.url"
                            class="image-size"
                            alt=""
                        />
                        <div>
                            <vue-dropzone
                                id="customdropzone"
                                :options="options"
                                class="dropzone-size"
                                :use-custom-slot="true"
                                v-on:vdropzone-success="uploadSuccess"
                            >
                                <i class="fa fa-image upload-icon pointer" aria-hidden="true"/>
                            </vue-dropzone>
                        </div>
                    </div>

                    <!-- NAME -->
                    <div>
                        <div class="md:flex">
                            <p class="font-semibold ml-2 flex-1">Name</p>
                        </div>

                        <div class="flex items-center w-full">
                            <div class="relative w-full">
                                <input
                                    class="w-full bg-gray-100 border-none rounded-xl placeholder-gray-400 px-4 py-2"
                                    id="name"
                                    type="text"
                                    v-model="name"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- USERNAME -->
                    <div>
                        <div class="md:flex">
                            <p class="font-semibold ml-2 flex-1">Username</p>

                            <p v-if="errors['username']" class="show-error-ideas">
                                {{ this.errors['username'][0] }}
                            </p>
                        </div>

                        <div class="flex items-center w-full">
                            <div class="relative w-full">
                                <input
                                    class="w-full bg-gray-100 border-none rounded-xl placeholder-gray-400 px-4 py-2"
                                    id="username"
                                    type="text"
                                    v-model="username"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-between space-x-3">
                        <button
                            :class="processing ? 'is-loading' : ''"
                            :disabled="processing"
                            class="flex items-center h-11 text-xs bg-gray-00 font-semibold
                        rounded-xl border border-gray-200 hover:border-gray-400 px-6 py-3"
                            type="submit"
                        >
                            <span v-if="processing">
                                <i class="fa fa-spinner fa-spin mr-1"></i>
                            </span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";

export default {
    name: "EditProfile",
    components: {
        vueDropzone: vue2Dropzone
    },
    data ()
    {
        return {
            loading: true,
            processing: false,

            // EDIT PROFILE
            name: '',
            username: '',

            // vue-dropzone
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
         * Return userObject
         */
        user ()
        {
            return this.$store.state.user.userObject;
        },

        /**
         * Return errorsObject
         */
        errors ()
        {
            return this.$store.state.errors.errorsObject;
        },
    },
    methods: {
        /**
         * Submit edited profile
         *
         * Move to action
         */
        async submit ()
        {
            this.processing = true;

            await axios.post('/api/profile/edit-profile', {
                name: this.name,
                username: this.username
            })
            .then(response => {
                console.log('edit-profile', response);

                if (response.data.success)
                {
                    alert('Your profile was updated successfully! =)');

                    this.$store.commit('setUserObject', response.data.user);

                    // window.location.href = window.location.href;
                }
             })
            .catch(error => {
                console.log('edit-profile', error.response);

                this.$store.commit('setErrorsObject', error.response.data.errors);
            });

            this.processing = false;
        },

        /**
         * The upload was successful
         */
        uploadSuccess (file, response)
        {
            if (response.success)
            {
                this.$store.commit('changeUserProfileImage', response.user.profile_image);
            }
        }
    },
}
</script>

<style scoped>
.container {
    margin: auto;
    width: 50em;
    padding: 20px;
}

.image-size {
    max-width: 300px;
    border-radius: 50px;
}

.dropzone-size {
    min-width: 300px;
    min-height: 300px;
    border-radius: 50px;
}

.upload-icon {
    right: 500px;
    position: absolute;
    top: 317px;
}

</style>
