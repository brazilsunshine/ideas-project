<template>
    <div>
        <div class="mt-3">
           <a
               @click="showAllIdeas"
               class="flex items-center font-semibold hover:underline pointer"
           >
               <i class="fa-solid fa-chevron-left w-4 h-4"></i>
                <span class="ml-2">
                    All ideas
                </span>
           </a>
        </div>

        <ShowSelectedIdea
            :idea="idea"
        />

        <div
            v-if="this.idea"
            v-click-outside="onClickOutside"
            class="comments-container relative space-y-6 ml-24 my-8"
        >
            <!-- COMMENT CONTAINER-->
            <div
                v-for="comment in this.idea.comments"
                class="comment-container relative bg-white rounded-xl flex mt-4"
            >
                <div class="flex flex-1 px-4 py-6">
                    <div class="flex-none">
                        <a href="#">
                            <img
                                src="/img/ff.jpeg"
                                alt="avatar"
                                class="w-14 h-14 rounded-xl"
                            >
                        </a>
                    </div>
                    <!--  COMMENTS CONTAINER  -->
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
                                <div> &bull; </div>
                                <div
                                    :class="comment.isCommentLikedByCurrentUser ? 'heart-liked' : ''"
                                    class="likes"
                                >
                                    <i @click="heartIconClicked(comment.id)"
                                       class="fa-solid fa-heart heart text-sm"
                                    ></i>
                                    <p class="text">
                                        ({{ comment.likesCount }})
                                        {{ comment.isCommentLikedByCurrentUser ? 'liked' : 'likes'}}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center space-x-2"
                            >
                                <button
                                    @click.stop="toggleSpamModal1(comment.id)"
                                    class="relative bg-gray-100 hover:bg-gray-200 rounded-full
                                    h-7 transition duration-150 ease-in px-3 mobile-left-196"
                                    style="margin-right: -24px; z-index: 99;"
                                >
                                    <i class="fa-solid fa-plus in-button"></i>
                                    <ul
                                        v-show="comment.display"
                                        class="absolute w-44 font-semibold bg-white
                                        shadow-lg rounded-xl py-3 ml-4 mobile-left-10"
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
            </div> <!-- END COMMENT CONTAINER -->

            <div class="is-admin comment-container relative bg-white rounded-xl flex mt-4">
                <div class="flex flex-1 px-4 py-6">
                    <div class="flex-none">
                        <a href="#">
                            <img
                                src="/img/avatar.jpeg"
                                alt="avatar"
                                class="w-14 h-14 rounded-xl"
                            >
                        </a>
                        <div class="text-center uppercase text-blue text-xs font-semibold">
                            Admin
                        </div>
                    </div>
                    <div class="w-full mx-4">
                        <div class="text-gray-600 mt-3 line-clamp-3">
                            DESCRIPTION
                        </div>

                        <div class="flex items-center justify-between mt-6">

                            <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                                 <div class="mobile-right-182 font-semibold text-blue" style="left: 23px;">
                                    Sthefane Oliveira
                                 </div>
                                 <div>
                                    &bull;
                                 </div>
                                 <div>
                                    10 hours ago
                                 </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button
                                    class="relative bg-gray-100 hover:bg-gray-200 rounded-full
                                    h-7 transition duration-150 ease-in px-3 mobile-left-196"
                                    style="margin-right: -24px; z-index: 99;"
                                >
                                    <i class="fa-solid fa-plus in-button"></i>
                                    <ul
                                        class="absolute w-44 font-semibold bg-white
                                        shadow-lg rounded-xl py-3 ml-4 mobile-left-10"
                                    >
                                        <li>
                                            <a
                                                href="#"
                                                class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                            >
                                                Mark as Spam
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                href="#"
                                                class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
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
            </div> <!-- END COMMENT CONTAINER -->
        </div> <!-- END COMMENTS CONTAINER -->
    </div>

</template>

<script>
import ShowSelectedIdea from "./ShowSelectedIdea";
import ModalSpam from "./ModalSpam";
import vClickOutside from 'v-click-outside';

export default {
    name: "SelectedIdea",
    directives: {
        clickOutside: vClickOutside.directive
    },
    components: {
        ModalSpam,
        ShowSelectedIdea
    },
    props: [
        'idea'
    ],
    data () {
        return {
            spamModal1: null,
        }
    },
    methods: {
        /**
         * Find the comment that matches the commentId I'm passing in
         */
        async heartIconClicked (commentId)
        {
            // loop through my comments array and find the comment where the comment.id matches the commentId I'm passing in
            const comment = this.idea.comments.find(comment => comment.id === commentId);

            // if comment is liked by the current user, DELETE_LIKE, if it's not, CREATE_LIKE
            const action = (comment.isCommentLikedByCurrentUser) ? "DELETE_LIKE" : "CREATE_LIKE";

            await this.$store.dispatch(action, comment.id);
        },

        /**
         * Click outside the div that contains the comments and close the dialog
         */
        onClickOutside ()
        {
            this.$store.commit('closeCommentsDialog');

            console.log('clicked-outside');
        },
        /**
         * Here I am updating the mutation to turn selectedIdea to null
         * and show all the ideas
         */
        showAllIdeas ()
        {
            this.$store.commit('setSelectedIdea', null);

            // Push the user to the path /home
            if (this.$route.path !== '/')
            {
                this.$router.push("/");
            }
        },
        /**
         * Toggle spam modal
         */
        toggleSpamModal1 (commentId)
        {
            this.$store.commit('toggleCommentDisplay', commentId);
        },
    }
}
</script>

<style scoped>
    .likes {
        display: flex;
        align-items: center;
    }

    .likes:hover {
        color: red;
    }

    .text {
        margin-left: 0.5em;
    }

    .heart:hover {
        transform:scale(1.4);
        cursor: pointer;
        color: red;
    }

    .heart-liked {
        color: red;
    }
</style>
