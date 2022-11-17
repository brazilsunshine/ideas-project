<template>
    <div class="mb-20">
        <p v-if="loading">
            Loading...
        </p>
        <div v-else>
            <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
                <div class="w-full md:w-1/3">
                    <select
                        v-model="selectedCategory"
                        class="w-full rounded-xl border-none px-4 py-2"
                        @change="getFilteredIdeas"
                    >
                        <option value="0">
                            All categories
                        </option>
                        <option
                            v-for="category in this.categories"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </div> <!-- END CATEGORIES -->

                <div class="w-full md:w-1/3">
                    <select
                        v-model="selectedFilter"
                        class="w-full rounded-xl border-none px-4 py-2"
                        @change="getFilteredIdeas"
                    >
                        <option value="No Filter">
                            No Filter
                        </option>
                        <option value="Top Voted">
                            Top Voted
                        </option>
                        <option value="My Ideas">
                            My Ideas
                        </option>
                    </select>
                </div> <!-- END FILTERS -->

                <div class="w-full md:w-2/3 relative">
                    <input
                        type="search"
                        v-model="ideaTitle"
                        @keyup="searchTitle"
                        placeholder="Type a title to find an idea"
                        class="w-full rounded-xl bg-white border-none px-4 py-2 pl-8"
                    >
                    <div class="absolute top-0 flex items-center h-full ml-2">
                        <i class="fa-solid fa-magnifying-glass text-gray-600"/>
                    </div>
                </div>
            </div> <!-- END INPUT FIND AN IDEA -->

            <!-- If we dont have any selected idea, then selectedIdea is equals to null -->
            <!-- And we will loop through all our ideas and show all of them -->
            <div
                v-if="selectedIdea === null"
                class="ideas-container space-y-6 my-6">

                <div
                    v-for="idea in ideas"
                    :key="idea.id"
                >
                    <Idea
                        :idea="idea"
                    />
                </div>

                <PaginationButtons
                    :current_page="this.$store.state.ideas.paginated.current_page"
                    :next_page_url="this.$store.state.ideas.paginated.next_page_url"
                    prev_page="PREVIOUS_IDEAS_PAGE"
                    next_page="NEXT_IDEAS_PAGE"
                />
            </div>

            <!-- if we click in one idea, it will fire the selectIdea(idea) function -->
            <!-- and selectedIdea will no longer be null.  -->
            <!-- And it will display the SelectedIdea.vue component  -->
            <!--  If selectedIdea is not null, then an idea is selected   -->
            <div
                v-else
            >
                <SelectedIdea
                    :idea="selectedIdea"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Idea from "./Idea";
import SelectedIdea from "./SelectedIdea";
import PaginationButtons from "./PaginationButtons";
import _ from "lodash";

export default {
    name: "Ideas",
    components: {
        Idea,
        SelectedIdea,
        PaginationButtons
    },
    data ()
    {
        return {
            loading: true,
            selectedCategory: 0,
            selectedFilter: 'No Filter',
            ideaTitle: '',
        }
    },
    async mounted ()
    {
        /**
         *  Call to actions.js to make a get request TO GET ALL IDEAS FROM DB AND PAGINATED THEM
         */
        await this.$store.dispatch('GET_PAGINATED_IDEAS');

        /**
         *  Call to actions.js to make a get request TO GET IDEA BY SLUG from DB
         */
        const url = window.location.href; // give me the current location from the browser url

        const split = url.split('/'); // split the url in every dash '/'

         if (split.length === 5) // if split.length is equals to 5 that means that there's a slug
         {
             // dispatch to get the idea by slug with the 4th split (5th in the array) as the payload
             await this.$store.dispatch('GET_IDEA_BY_SLUG', split[4]);

         }

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
         * Return paginated ideas from store > modules > ideas > index.js > paginated
         */
        ideas ()
        {
            return this.$store.state.ideas.paginated.data;
        },

        /**
         * Return the selectedIdea from store > modules > ideas > index.js > selectedIdea
         */
        selectedIdea ()
        {
            return this.$store.state.ideas.selectedIdea;
        }
    },

    methods: {
        /**
         * Dispatch action to get filtered ideas by category and filter on main page
         */
        async getFilteredIdeas ()
        {
            await this.$store.dispatch('GET_FILTERED_IDEAS', {
                selectedCategory: this.selectedCategory,
                selectedFilter: this.selectedFilter
            });
        },

        /**
         * Make a get request to search for an Idea when the user stops typing with debounce/lodash
         */
        searchTitle: _.debounce(function () {
            this.$store.dispatch('SEARCH_IDEA_BY_TITLE', this.ideaTitle)
        }, 500), // time
    }
}
</script>

