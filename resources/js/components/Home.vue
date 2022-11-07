<template>
    <div>
        <!-- ADD AN IDEA FORM -->
        <main class="container mx-auto max-w-custom flex flex-col md:flex-row">
            <div class="w-70 mx-auto md:mr-5">
                <div class="bg-white md:sticky md:top-8 border-2 border-blue rounded-xl mt-16 gradient">
                    <div class="text-center px-6 py-2 pt-6">
                        <h3 class="font-semibold text-base">
                            Add an Idea
                        </h3>
                        <div v-if="auth">
                            <p class="text-xs mt-4">
                                Let us know what you would like and we will take a look!
                            </p>
                        </div>
                        <div v-else>
                            <p class="text-xs mt-4">
                                Please login to create an idea.
                            </p>
                        </div>
                    </div>

                    <div v-if="auth">
                        <CreateIdea />
                    </div>

                    <div v-else class="my-6 text-center">
                        <a
                            href="/login"
                            class="inline-block justify-center w-1/2 h-11 text-xs bg-blue
                                text-white font-semibold rounded-xl border border-blue
                                hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                        >
                                <p class="ml-1">
                                    Login
                                </p>
                        </a>
                        <a
                            href="/register"
                            class="inline-block justify-center w-1/2 h-11 text-xs bg-gray-200
                                font-semibold rounded-xl border border-gray-200 hover:border-gray-400
                                transition duration-150 ease-in px-6 py-3 mt-2"
                        >
                            <p class="ml-1">
                                    Sign up
                            </p>
                        </a>
                    </div>

                </div>
            </div>

            <div class="w-full px-2 md:px-0 md:w-175 padding-idea-on-mobile">
                <StatusFilters />
                <div class="mt-8">
                    <Ideas />
                </div>
            </div>

        </main>
    </div>
</template>

<script>
import Ideas from './Ideas'
import CreateIdea from "./CreateIdea";
import StatusFilters from "./StatusFilters";
export default {
    name: "Home",
    components: {
        StatusFilters,
        CreateIdea,
        Ideas
    },
    computed: {
        /**
         * Return True if the user is logged in.
         */
        auth () {
            return this.$store.state.user.auth;
        }
    }
}
</script>

