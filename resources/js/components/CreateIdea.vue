<template>
    <div>
        <p v-if="loading">
            Loading...
        </p>
        <div v-else>
            <form
                @submit.prevent="submit"
                class="space-y-4 px-4 py-6"
            >
                <div>
                    <!-- Here I am showing the error to the user -->
                    <p v-if="errors['title']" class="show-error-ideas">
                        {{ this.errors['title'][0] }}
                    </p>
                    <input
                        type="text"
                        class="w-full text-sm bg-gray-100 border-none
                        rounded-xl placeholder:gray-900 px-4 py-2"
                        placeholder="Title of your awesome idea"
                        v-model="idea_title"
                        @keydown="clearError('title')"
                    />
                </div>
                <div>
                    <select
                        name="category_add"
                        id="category_add"
                        class="w-full bg-gray-100 rounded-xl border-none px-4 py-2 text-sm"
                        v-model="category_id"
                    >
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <!-- Here I am showing the error to the user -->
                    <p v-if="errors['description']" class="show-error-ideas">
                        {{ this.errors['description'][0] }}
                    </p>
                    <textarea
                        cols="30"
                        rows="4"
                        class="w-full bg-gray-100 rounded-xl border-none text-sm px-4 py-2"
                        placeholder="Describe your Idea"
                        v-model="idea_description"
                        @keydown="clearError('description')"
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
                            Submit
                        </span>
                    </button>
                </div>
            </form> <!-- END FORM -->
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateIdea",
    data ()
    {
        return {
            loading: true,

            // submit idea
            idea_title: '',
            idea_description: '',
            category_id: 1
        };
    },
    async mounted () {
        /**
         * Call to actions.js to make a get request TO GET ALL CATEGORIES from DB;
         */
        await this.$store.dispatch('GET_CATEGORIES');

        this.loading = false;
    },
    computed: {
        /**
         * Return all categories
         */
        categories () {
            return this.$store.state.ideas.categories;
        },

        /**
         * Return errors
         */
        errors ()
        {
            return this.$store.state.errors.errorsObject;
        }
    },
    methods: {

        /**
         * Post request to send new idea to the database
         */
        async submit ()
        {
            await axios.post('/api/create-idea', {
                title: this.idea_title,
                description: this.idea_description,
                category_id: this.category_id
            })

            .then(response => {

                console.log('test');
                console.log('create-idea', response);

                if (response.data.success)
                {
                    alert('Idea was added successfully! =)');

                    window.location.href = window.location.href;
                }
             })
            .catch(error => {
                console.log('create-idea', error.response);

                this.$store.commit('setErrorsObject', error.response.data.errors);
            });
        },

        /**
         * Clear an error with this key
         */
        clearError (key)
        {
            if (this.errors[key]) {
                this.$store.commit('deleteError', key);
            }
        }
    }
}
</script>

<style scoped>

</style>
