<template>
    <div class="container mx-auto max-w-custom flex flex-col md:flex-row">
        <p v-if="loading">
            Loading...
        </p>

        <div v-else style="display: flex;">
            <div style="padding-right: 43px">
                <img
                    v-if="user.profile_image"
                    :src="user.profile_image.url"
                    class="image-size"
                />

                <p style="padding-left: 30px;">
                    @{{ this.user.username }}
                </p>
            </div>

            <div
                class="ideas-container space-y-6 my-6"
            >
                <div
                    v-for="idea in ideas"
                    class="idea-container px-2 hover:shadow-md transition duration-150 ease-in bg-white rounded-xl"
                >
                    <div class="flex flex-1 px-2 py-6">
                        <div class="flex-none">
                            <a href="#">
                                <img
                                    :src="user.profile_image.url"
                                    alt="avatar"
                                    class="w-14 h-14 rounded-xl"
                                >
                            </a>
                        </div>
                        <div class="w-full flex flex-col justify-between mx-4">
                            <h4 class="text-xl font-semibold">
                                <p>
                                    {{ idea.title }}
                                </p>
                            </h4>
                            <div class="text-gray-600 mt-3 line-clamp-3">
                                {{ idea.description }}
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                                    <div>
                                        {{ idea.diffForHumans }}
                                    </div>
                                    <div>
                                        &bull;
                                    </div>
                                    <div class="hide-on-mobile">
                                        {{ idea.category.name }}
                                    </div>
                                    <div class="hide-on-mobile">
                                        &bull;
                                    </div>
                                    <button
                                        @click.stop="showComments(idea.id)"
                                        class="pointer hover:text-black">
                                        <p class="pr-2">
                                            ({{ idea.commentsCount }}) Comments
                                        </p>
                                    </button>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="hide-on-mobile text-xs font-bold uppercase leading-none
                                    rounded-full text-center w-28 h-7 py-2 px4"
                                        :class="statusColors[idea.status.name]"
                                    >
                                        {{ idea.status.name }}
                                    </div>
                                    <button
                                        @click.stop="toggleSpamModal"
                                        class="relative bg-gray-100 hover:bg-gray-200 rounded-full
                                        h-7 transition duration-150 ease-in px-3" style="margin-right: -17px;"
                                    >

                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <ul
                                        v-show="spamModal"
                                        class="absolute w-44 font-semibold bg-white
                                        shadow-lg rounded-xl py-3 ml-4"
                                    >
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <IdeaCommentsProfile
                        v-if="showCommentsForIdeaId === idea.id"
                        class="py-2"
                        :idea="idea"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IdeaCommentsProfile from "./IdeaCommentsProfile";

export default {
    name: "Profile",
    components: {
        IdeaCommentsProfile
    },
    data ()
    {
        return {
            loading: true,
            spamModal: null,
            showCommentsForIdeaId: 0,
            statusColors:  {
                'Open': 'bg-gray-200',
                'Considering': 'bg-purple text-white',
                'In Progress': 'bg-yellow text-white',
                'Implemented': 'bg-green text-white',
                'Closed': 'bg-red text-white'
            }
        }
    },
    async mounted ()
    {
        /**
         * Get the current user ideas
         */
        await this.$store.dispatch('GET_MY_IDEAS');

        this.loading = false;
    },
    computed: {
        /**
         * Get the userObject;
         */
        user ()
        {
            return this.$store.state.user.userObject;
        },

        /**
         * Return paginated ideas from store > modules > ideas > index.js > paginated
         */
        ideas ()
        {
            return this.$store.state.ideas.paginated.data;
        },
    },
    methods: {
        /**
         * Making a commit to update show and set it to true and hide show the modal;
         */
        toggleSpamModal ()
        {
            this.$store.commit('showModal', {
                innerComponent: 'ModalSpam', // inner component is the component 'inside the model'
                title: 'Options'
            });
        },

        /**
         * Show comments if the idea.id matches the ideaId
         */
        showComments (ideaId)
        {
            this.showCommentsForIdeaId = (this.showCommentsForIdeaId === ideaId)
                ? 0
                : ideaId;
        },
    }
}
</script>

<style scoped>
.image-size {
    max-width: 300px;
    border-radius: 50px;
}
</style>
