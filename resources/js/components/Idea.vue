<template>
    <div
        @click="selectIdea"
        class="vote-button-mobile idea-container hover:shadow-md transition duration-150
        ease-in bg-white rounded-xl flex cursor-pointer"
    >
        <div class="border-r border-gray-100 px-5 py-8">
            <div class="text-center">
                <div
                    :class="this.idea.isVotedByUser ? 'text-blue' : ''"
                    class="font-semibold text-2xl">
                    {{ this.idea.votesCount }}
                </div>
                <div
                    :class="this.idea.isVotedByUser ? 'text-blue' : ''"
                    class="text-gray-500"
                >
                    <p>
                        {{ this.idea.votesCount === 0 ? 'Vote' : 'Votes'}}
                    </p>
                </div>

                <div v-if="auth" class="mt-8">
                    <button
                        @click.stop="voteButtonClicked"
                        :class="this.idea.isVotedByUser ? 'bg-blue text-white' : ''"
                        class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400
                        font-semibold text-xs rounded-xl transition duration-150 ease-in px-4 py-3"
                    >
                        <p>
                            {{ this.idea.isVotedByUser ? 'Voted' : 'Vote' }}
                        </p>
                    </button>
                </div>
                <div v-else>
                    <p class="text-xs">
                        Please log in to vote
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-1 px-2 py-6">
            <div class="flex-none">
                <a href="#">
                    <img
                        src="/img/profilepic.png"
                        alt="avatar"
                        class="w-14 h-14 rounded-xl"
                    >
                </a>
            </div>
            <div class="w-full flex flex-col justify-between mx-4">
                <h4 class="text-xl font-semibold">
                    <p class="hover:underline">
                        {{ this.idea.title }}
                    </p>
                </h4>
                <div class="text-gray-600 mt-3 line-clamp-3">
                    {{ this.idea.description }}
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
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
                            3
                        </div>
                        <div class="text-gray-900">
                            Comments
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div
                            class="hide-on-mobile text-xs font-bold uppercase leading-none
                            rounded-full text-center w-28 h-7 py-2 px4"
                            :class="this.statusColors[this.idea.status.name]"
                        >
                            {{ this.idea.status.name }}
                        </div>
                        <button
                            @click.stop="toggleSpamModal"
                            class="relative bg-gray-100 hover:bg-gray-200 rounded-full
                            h-7 transition duration-150 ease-in px-3" style="margin-right: -17px;"
                        >
                            <i class="fa-solid fa-plus in-button"></i>
                            <ul
                                v-show="spamModal"
                                class="absolute w-44 font-semibold bg-white
                                shadow-lg rounded-xl py-3 ml-4"
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
    </div>
</template>

<script>
import Avatar from 'vue-avatar'


export default {
    name: "Idea",
    components: {
        Avatar
    },
    props: [
        'idea'
    ],
    data() {
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
        },

    },
    methods: {
        /**
         * selectedIdea is no longer null, it will become the idea that the user clicked.
         */
        selectIdea ()
        {
            this.$store.commit('setSelectedIdea', this.idea); // updating the setIdea to become the idea clicked by the user

            this.$router.push(
                '/ideas/' + this.idea.slug
            ); // and we will redirect the user to /idea/{idea:slug} that matches with the idea clicked
        },

        /**
         * Making a commit to update show and set it to true and hide show the modal;
         */
        toggleSpamModal ()
        {
            // this.spamModal = !this.spamModal;
            this.$store.commit('showModal', {
                innerComponent: 'ModalSpam', // inner component is the component 'inside the model'
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


