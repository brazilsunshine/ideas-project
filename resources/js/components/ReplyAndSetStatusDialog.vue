<template>
    <div class="flex">
        <div class="relative"> <!-- SET REPLY DIALOG -->
            <button
                @click="toggleReplyModal"
                type="button"
                class="flex items-center justify-center h-11 w-28 text-sm
                bg-blue text-white font-semibold rounded-xl border border-blue
                hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
            >
                Reply
            </button>
            <div class="absolute z-10 w-104 text-left font-semibold text-sm bg-white shadow-lg rounded-xl mt-2"
            >
                <form
                    v-show="replyModal"
                    action="#"
                    class="space-y-4 px-4 py-6">
                    <div>
                        <i
                            class="fa fa-times x-icon"
                            @click="close"
                        />
                        <textarea
                            v-model="comment"
                            id="post_comment"
                            cols="30"
                            rows="4"
                            class="w-full text-sm bg-gray-100 rounded-xl border-none px-4 py-2"
                            placeholder="Go ahead! Don't be shy. Share your thoughts..."
                        >
                        </textarea>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button
                            @click="createANewComment"
                            type="button"
                            class="flex items-center justify-center h-11 w-1/2 text-sm
                            bg-blue text-white font-semibold rounded-xl border border-blue
                            hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                        >
                            Post Comment
                        </button>
                        <button
                            type="button"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200
                            font-semibold rounded-xl border border-gray-200 hover:border-gray-400
                            transition duration-150 ease-in px-6 py-3"
                        >
                            <i class="fa-solid fa-paperclip text-gray-500 w-4 transform -rotate-45"></i>
                            <span class="ml-1">
                                Attach
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div> <!-- END REPLY DIALOG -->

        <div> <!-- SET STATUS DIALOG -->
            <button
                @click="toggleSetStatusModal"
                type="button"
                class="ml-4 flex items-center justify-center w-36 h-11 text-sm bg-gray-200
                font-semibold rounded-xl border border-gray-200 hover:border-gray-400
                transition duration-150 ease-in px-6 py-3"
            >

                <span class="mr-1">
                    Set Status
                </span>
                <i class="fa-solid fa-chevron-down ml-1"></i>
            </button>
            <div
                v-show="setStatusModal"
                class="absolute z-20 w-76 text-left font-semibold text-sm bg-white shadow-lg rounded-xl mt-2"
            >
                <i
                    class="fa fa-times x-icon"
                    @click="close"
                />
                <form action="#" class="space-y-4 px-4 py-6">
                    <div class="space-y-2">
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    class="bg-gray-200 text-black border-none"
                                    type="radio"
                                    checked=""
                                    name="radio-direct"
                                    value="1">
                                <span class="ml-2">
                                    Open
                                </span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    class="bg-gray-200 text-purple border-none"
                                    type="radio"
                                    name="radio-direct"
                                    value="2">
                                <span class="ml-2">
                                    Considering
                                </span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    class="bg-gray-200 text-yellow border-none"
                                    type="radio"
                                    name="radio-direct"
                                    value="3">
                                <span class="ml-2">
                                    In Progress
                                </span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    class="bg-gray-200 text-green border-none"
                                    type="radio"
                                    name="radio-direct"
                                    value="4">
                                <span class="ml-2">
                                    Implemented
                                </span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    class="bg-gray-200 text-red border-none"
                                    type="radio"
                                    name="radio-direct"
                                    value="5">
                                <span class="ml-2">
                                    Closed
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- UPDATE COMMENT TEXTAREA -->
                    <div>
                    <textarea
                        name="update_comment"
                        id="update_comments"
                        cols="30"
                        rows="3"
                        class="w-full text-sm bg-gray-100 rounded-xl border-none px-4 py-2"
                        placeholder="Add an update comment (optional)"
                    >
                    </textarea>
                    </div>

                    <div class="flex items-center justify between space-x-3">
                        <button
                            type="button"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200
                            font-semibold rounded-xl border border-gray-200 hover:border-gray-400
                            transition duration-150 ease-in px-6 py-3"
                        >
                            <i class="fa-solid fa-paperclip text-gray-500 w-4 transform -rotate-45"></i>
                            <span class="ml-1">
                                Attach
                            </span>
                        </button>

                        <button
                            type="submit"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue
                            text-white font-semibold rounded-xl border border-blue
                            hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                        >
                            <span class="ml-1">
                                Update
                            </span>
                        </button>
                    </div>
                    <!--  CHECKBOX-->
                    <div>
                        <label class="font-normal inline-flex items-center">
                            <input
                                class="rounded bg-gray-200 form-checkbox"
                                type="checkbox"
                                name="notify_voters"
                                checked="">
                            <span class="ml-2">
                                Notify all voters
                            </span>
                        </label>
                    </div>
                </form>
            </div>
        </div> <!-- END SET STATUS DIALOG -->
    </div>
</template>

<script>

export default {
    name: "ReplyAndSetStatusDialog",
    props: [
        'idea'
    ],
    data ()
    {
        return {
            comment: '',
            replyModal: false,
            setStatusModal: false,
        }
    },
    mounted () {
        // Close modal with 'esc' key
        document.addEventListener('keydown', (e) => {
            if (e.keyCode === 27)
            {
                this.close();
            }
        });
    },
    methods: {
        /**
         * Making a commit to update show and set it to false and hide the modal;
         */
        close ()
        {
            this.replyModal = false;

            this.setStatusModal = false;
        },
        /**
         * Post request passing in as payload the comment and the idea_id
         */
        async createANewComment ()
        {
            await this.$store.dispatch('CREATE_A_NEW_COMMENT', {
                comment: this.comment,
                idea_id: this.idea.id
            });

            if (this.comment.length === 0)
            {
                alert('Please say something')
            }
            else
            {
                this.comment = '';

                this.replyModal = !this.replyModal;

                this.$vToastify.success("You added your comment! =)");
            }

        },
        /**
         * Toggle reply modal
         */
        toggleReplyModal ()
        {
            this.replyModal = !this.replyModal;

            this.setStatusModal = false;
        },

        /**
         * Toggle set status modal
         */
        toggleSetStatusModal ()
        {
            this.setStatusModal = !this.setStatusModal;

            this.replyModal = false;
        },


    }
}
</script>

<style scoped>
    .x-icon {
        position: absolute;
        right: 11px;
        top: 8px;
        cursor: pointer;
    }
</style>
