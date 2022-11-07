<template>
    <div>
        <div class="text-gray-900 text-sm hide-on-mobile">
            <nav class="flex flex-col md:flex-row items-center justify-between px-4 py-3 ">
                <div class="flex items-center space-x-4">
                    <ul>
                        <li @click="setIdeaNull">
                            <router-link to="/" class="hover:border-gray-400 mr-6">Home</router-link>
                        </li>
                    </ul>
                </div>
                <!-- If auth is not true return these routes -->
                <div v-if="!auth">
                    <ul class="md:flex">
                        <li>
                            <router-link to="/login" class="hover:border-gray-400 mr-4">Login</router-link>
                        </li>
                        <li>
                            <router-link to="/register" class="hover:border-gray-400">Register</router-link>
                        </li>
                    </ul>
                </div>
                <div v-else class="md:flex">
                    <ul class="md:flex">
                        <li>
                            <a
                                class="hover:border-gray-400 pointer"
                                @click="logout"
                            >
                                Logout
                            </a>
                        </li>
                    </ul>
                    <p class="ml-2">
                        user avatar here
                    </p>
                </div>
            </nav>
        </div>
        <!-- MOBILE NAV -->
        <div
            class="visible md:invisible menu-icon"
        >
            <i
                class="fa-solid fa-bars"
                style="float: right"
                @click="toggleMenuModal"
            ></i>
        </div>
    </div>
</template>

<script>
export default {
    name: "Nav",
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
                        this.$router.push("/");
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

        /**
         * Toggle mobile nav
         */
        toggleMenuModal ()
        {
            // this.mobileNav = !this.mobileNav;
            this.$store.commit('showModal', {
                innerComponent: 'MenuModalMobile',
                title: 'Menu'
            });
        }
    }
}
</script>

<style scoped>
    .menu-icon {
      cursor: pointer;
      position: absolute;
      top: 32px;
      right: 25px;
      height: 100px;
      width: auto;
    }
</style>
