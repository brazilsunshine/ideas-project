<template>
    <div>
        <div class="text-gray-900 text-sm hide-on-mobile">
            <nav
                class="flex flex-col md:flex-row items-center justify-between px-4 py-3"
                style="align-items: self-start;"
            >
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
                <div v-else>
                    <div v-click-outside="onClickOutside">
                        <button @click="isOpen = !isOpen">
                            <img
                                src="img/profilepic.png"
                                alt="Profile"
                                style="max-width: 59px;"
                            >
                        </button>
                        <ul
                            v-show="isOpen"
                            class="absolute bg-black text-white py-2 px-3 rounded mt-2 z-10"
                            style="right: 11px;"
                        >
                            <li class="pointer">
                                <router-link to="/profile">Profile</router-link>
                            </li>
                            <li
                                class="mt-2 pointer"
                                @click="logout"
                            >
                                Logout
                            </li>
                        </ul>
                    </div>
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
import vClickOutside from 'v-click-outside'

export default {
    name: "Nav",
    directives: {
        clickOutside: vClickOutside.directive
    },
    data () {
        return {
            isOpen: false,
        }
    },
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
        onClickOutside () {
            if (this.isOpen)
            {
                this.isOpen = false;
            }
        },
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

    /* Parent Container */
    .content_img{
    }

    /* Child Text Container */
    .content_img p{
        position: absolute;
        bottom: 294px;
        right: -76px;
        background: black;
        color: white;
        font-family: sans-serif;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: visibility 0s, opacity 0.5s linear;
        transition: visibility 0s, opacity 0.5s linear;

    }

    /* Hover on Parent Container */
    .content_img:hover{
        cursor: pointer;
    }

    .content_img:hover p{
        width: 150px;
        padding: 8px 15px;
        visibility: visible;
        opacity: 0.7;

    }
</style>
