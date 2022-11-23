<template>
    <div class="container mx-auto max-w-custom flex flex-col">
        <p v-if="loading">
            Loading...
        </p>

        <div v-else>
            <p>
                Profile vue
            </p>


        </div>
    </div>
</template>

<script>

export default {
    name: "Profile",

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
