<template>
    <div>
        <ul>
            <li @click="setIdeaNull">
                <router-link to="/" class="hover:border-gray-400 mr-1">Home</router-link>
            </li>
        </ul>
        <div v-if="!auth">
            <ul>
                <li>
                    <router-link to="/login" class="hover:border-gray-400 mr-1">Login</router-link>
                </li>
                <li>
                    <router-link to="/register" class="hover:border-gray-400">Register</router-link>
                </li>
            </ul>
        </div>
        <div v-else>
            <ul>
                <li>
                    <a
                        class="hover:border-gray-400 pointer mr-1"
                        @click="logout"
                    >
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "MenuModalMobile",
    computed: {
        /**
         * Return True if the user is logged in.
         */
        auth ()
        {
            return this.$store.state.user.auth;
        }
    },
    methods: {
        /**
         * Post request to logout
         */
        async logout ()
        {
            await axios.post('/api/logout')
                .then(response => {
                    console.log('logout', response);

                    this.$store.commit('logout');

                    // Push the user to the path /home
                    if (this.$route.path !== '/')
                    {
                        this.$router.replace("/");
                    }

                    alert('You have logged out!');

                })
                .catch(error => {
                    console.log('logout', error);
                });
        },
        /**
         * Here I am updating the mutation to turn selectedIdea to null
         * and show all the ideas
         */
        setIdeaNull ()
        {
            this.$store.commit('setSelectedIdea', null);
        },
    }
}
</script>

<style scoped>

</style>
