<template>
    <div>
        <div class="idea-and-buttons container">
            <div class="idea-container bg-white rounded-xl flex mt-4">
                <div class="flex flex-1 px-4 py-6">
                    <div class="flex-none">
                        <a href="#">
                            <img
                                src="/img/avatar.jpeg"
                                alt="avatar"
                                class="w-14 h-14 rounded-xl"
                            >
                        </a>
                    </div>
                    <div class="w-full mx-4">
                        <h4 class="text-xl font-semibold">
                            <a href="#" class="hover:underline">
                                {{ this.idea.title }}
                            </a>
                        </h4>
                        <div class="text-gray-600 mt-3 line-clamp-3">
                            {{ this.idea.description }}
                        </div>

                        <div class="flex items-center justify-between mt-6">

                            <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                                <div class="font-semibold text-gray-900">
                                    {{ this.idea.user.name }}
                                </div>
                                <div>
                                    &bull;
                                </div>
                                <div>
                                    {{ this.idea.diffForHumans }}
                                </div>
                                <div>
                                    &bull;
                                </div>
                                <div class="hide-on-mobile">
                                    {{ this.idea.category.name }}
                                </div>
                                <div class="hide-on-mobile">
                                    &bull;
                                </div>
                                <div class="text-gray-900">
                                    3 Comments
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <div class="hide-on-mobile text-xs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px4"
                                     :class="this.statusColors[this.idea.status.name]"
                                >
                                    {{ this.idea.status.name }}
                                </div>
                                <button
                                    @click.stop="toggleSpamModal"
                                    class="relative bg-gray-100 hover:bg-gray-200 rounded-full
                                        h-7 transition duration-150 ease-in px-3" style="margin-right: -23px;"
                                >
                                    <i class="fa-solid fa-plus in-button"></i>
                                    <ul
                                        v-show="spamModal"
                                        class="absolute w-44 font-semibold bg-white shadow-lg rounded-xl py-3 ml-4"
                                    >
                                        <li>
                                            <a
                                                href="#"
                                                class="hover:bg-gray-100 block transition
                                                    duration-150 ease-in px-5 py-3"
                                            >
                                                Mark as Spam
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                href="#"
                                                class="hover:bg-gray-100 block transition
                                                    duration-150 ease-in px-5 py-3"
                                            >
                                                Delete Post
                                            </a>
                                        </li>
                                    </ul>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- END IDEA CONTAINER -->

            <!-- BUTTONS-CONTAINER -->
            <div class="buttons-container flex items-center justify-between mt-6">
                <div class="flex items-center space-x-4 ml-6">
                    <ReplyAndSetStatusDialog
                        :idea="idea"
                    />
                </div>

                <div class="hide-on-mobile flex items-center space-x-3">
                    <div class="bg-white font-semibold text-center rounded-xl px-3 py-2" style="margin-left: 12em;">
                        <div
                             :class="this.idea.isVotedByUser ? 'text-blue' : ''"
                             class="text-xl leading-snug"
                        >
                            {{ this.idea.votesCount }}
                        </div>
                        <div
                            :class="this.idea.isVotedByUser ? 'text-blue' : ''"
                            class="text-gray-400 text-xs leading-none"
                        >
                            <p>
                                {{ this.idea.votesCount === 1 ? 'Vote' : 'Votes' }}
                            </p>
                        </div>
                    </div>

                    <div v-if="auth">
                        <button
                            @click="voteButtonClicked"
                            :class="this.idea.isVotedByUser ? 'bg-blue text-white' : ''"
                            type="button"
                            class="w-32 h-11 text-xs bg-gray-200
                            font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400
                            transition duration-150 ease-in px-6 py-3"
                        >
                            <span
                                class="mr-1"
                            >
                                {{ this.idea.isVotedByUser ? 'Voted' : 'Vote' }}
                            </span>
                        </button>
                    </div>

                    <div v-else>
                        <p class="text-xs">
                            Please log in to vote
                        </p>
                    </div>

                </div>
            </div> <!-- END BUTTONS CONTAINER -->
        </div>  <!-- END IDEA AND BUTTONS CONTAINER -->
    </div>
</template>

<script>
import ReplyAndSetStatusDialog from "./ReplyAndSetStatusDialog";

export default {
    name: "ShowSelectedIdea",
    components: {
        ReplyAndSetStatusDialog,
    },
    props: [
        'idea'
    ],
    data ()
    {
        return {
            spamModal: null,
            statusColors:  {
                'Open': 'bg-gray-200',
                'Considering': 'bg-purple text-white',
                'In Progress': 'bg-yellow text-white',
                'Implemented': 'bg-green text-white',
                'Closed': 'bg-red text-white'
            }
        }
    },

    computed : {
        /**
         * Return True if the user is logged in.
         */
        auth () {
            return this.$store.state.user.auth;
        }
    },
    methods: {
        /**
         * Toggle spam modal
         */
        toggleSpamModal ()
        {
            this.$store.commit('showModal', {
                innerComponent: 'ModalSpam',
                title: 'Options'
            });
        },

        /**
         * Post request to delete/create vote
         */
        async voteButtonClicked ()
        {
            const action = (this.idea.isVotedByUser) // if idea is voted by the current user
                ? "DELETE_VOTE" // I'm going to delete the vote
                : "CREATE_VOTE"; // if idea is not voted by the user, create a vote

            await this.$store.dispatch(action, this.idea.id);
        }
    }
}
</script>

<style scoped>

</style>
