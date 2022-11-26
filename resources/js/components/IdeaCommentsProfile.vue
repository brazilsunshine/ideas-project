<template>
    <div>
        <!-- COMMENT CONTAINER-->
        <div
            v-if="idea"
            v-for="comment in idea.comments"
            class="relative bg-white rounded-xl flex mt-4 border-2"
        >
            <div class="flex flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img
                            v-if="idea.user.profile_image"
                            :src="idea.user.profile_image.url"
                            class="w-14 h-14 rounded-xl"
                        >
                    </a>
                </div>
                <div class="w-full mx-4">
                    <div class="text-gray-600 mt-3 line-clamp-3">
                        <p>
                            {{ comment.comment }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-6">

                        <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                            <div class="mobile-right-182 font-semibold text-gray-900">
                                {{ comment.user.name }}
                            </div>
                            <div> &bull; </div>
                            <div>
                                <p>
                                    {{ comment.diffForHumans }}
                                </p>
                            </div>
                        </div>

                        <div
                            v-click-outside="onClickOutside"
                            class="flex items-center space-x-2"
                        >
                            <button
                                @click.stop="toggleSpamModal(comment.id)"
                                class="relative bg-gray-100 hover:bg-gray-200 rounded-full
                                    h-7 px-3 mobile-left-196"
                                style="margin-right: -24px; z-index: 99;"
                            >
                                <i class="fa-solid fa-plus in-button" />

                                <transition name="pop-out">
                                    <ul
                                        v-show="comment.display"
                                        class="absolute w-44 font-semibold bg-white
                                        shadow-lg rounded-xl py-3 ml-4 mobile-left-10 duration-700"
                                    >
                                        <li>
                                            <a
                                                href="#"
                                                class="hover:bg-gray-100 block px-5 py-3"
                                            >
                                                Mark as Spam
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                href="#"
                                                class="hover:bg-gray-100 block px-5 py-3"
                                            >
                                                Delete Post
                                            </a>
                                        </li>
                                    </ul>
                                </transition>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- END COMMENT CONTAINER -->
    </div>
</template>

<script>
import vClickOutside from "v-click-outside";

export default {
    name: "IdeaCommentsProfile",
    props: [
        'idea'
    ],
    directives: {
        clickOutside: vClickOutside.directive
    },
    data ()
    {
        return {
            spamModal: null,
        }
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
         * Get the userObject;
         */
        user ()
        {
            return this.$store.state.user.userObject;
        },
    },

    methods: {
        /**
         * Close the comment's dialog when clicked outside
         */
        onClickOutside ()
        {
            this.$store.commit('closeCommentsDialogProfile');
        },

        /**
         * Toggle spam modal
         */
        toggleSpamModal (commentId)
        {
            this.$store.commit('toggleCommentDisplayIdesProfile', {
                commentId,
                ideaId: this.idea.id
            });
        },
    }
}
</script>

<style scoped>

    .pop-out-enter-active,
    .pop-out-leave-active {
        transition: all 0.4s;
    }

    .pop-out-enter,
    .pop-out-leave-active {
        opacity: 0;
        transform: translateY(-7px);
    }

</style>
