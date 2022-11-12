import Vue from 'vue'
export const actions = {
    /**
     * Here I am making a GET REQUEST to get all the ideas and paginate them
     */
    async GET_PAGINATED_IDEAS (context)
    {
        await axios.get('/api/ideas/get-paginated')

        .then(response => {
            console.log('get-paginated-ideas', response);

            context.commit('setPaginatedIdeas', response.data.ideas); // committing a mutation from actions
         })
        .catch(error => {
            console.log('get-paginated-ideas', error);
        });
    },

    /**
     * Get request to get idea by slug
     *
     * Payload is the split[4] that means the idea slug coming from the url
     */
    async GET_IDEA_BY_SLUG (context, payload)
    {
        await axios.get('/api/ideas/get-idea-by-slug/' + payload)

        .then(response => {
            console.log('get_idea_by_slug', response);

            context.commit('setSelectedIdea', response.data.idea);
         })
        .catch(error => {
            console.log('get_idea_by_slug', error);
        });
    },

    /**
     * Create a new comment
     */
    async CREATE_A_NEW_COMMENT (context, payload)
    {
        await axios.post('/api/ideas/create-a-new-comment', {
            comment: payload.comment,
            idea_id: payload.idea_id
        })

        .then(response => {
            console.log('create-comment', response);

            if (response.data.success)
            {
                context.commit('addCommentToSelectedIdea', response.data.comment);
            }
         })
        .catch(error => {
            console.log('create-comment', error);
        });
    },

    /**
     * Load the previous page of Ideas
     */
    async PREVIOUS_IDEAS_PAGE (context)
    {
        await axios.get(context.state.paginated.prev_page_url) // making a get request to my own store

        .then(response => {
            console.log('previous-ideas-page', response);

            if (response.data.success)
            {
                context.commit('setPaginatedIdeas', response.data.ideas);

                window.scrollTo(0,0); // scroll the page to the top
            }
         })
        .catch(error => {
            console.log('previous-ideas-page', error);
        });
    },

    /**
     * Load the next page of Ideas
     */
    async NEXT_IDEAS_PAGE (context)
    {
        await axios.get(context.state.paginated.next_page_url) // making a get request to my own store

        .then(response => {
            console.log('next-ideas-page', response);

            if (response.data.success)
            {
                context.commit('setPaginatedIdeas', response.data.ideas);

                window.scrollTo(0,0); // scroll the page to the top
            }
         })
        .catch(error => {
            console.log('next-ideas-page', error);
        });
    },

    /**
     * Get request to get all categories
     */
    async GET_CATEGORIES (context)
    {
        await axios.get('/api/ideas/get-categories')

        .then(response => {
            console.log('get-categories', response);

            context.commit('setCategories', response.data.categories);
         })
        .catch(error => {
            console.log('get-categories', error);
        });
    },

    /**
     * Delete vote from an idea
     */
    async DELETE_VOTE (context, payload)
    {
        await axios.post('/api/ideas/delete-vote', {
            id: payload // id is how I'm going to read im my PHP, it will have payload as the value
        })

        .then(response => {
            console.log('delete-vote', response);

            if (response.data.success)
            {
                context.commit('decreaseIdeaVoteCount', payload); // payload is the idea.id coming from Idea.vue

                Vue.$vToastify.success("You removed your vote from this idea!");

            }
         })
        .catch(error => {
            console.log('delete-vote', error);
        });

    },

    /**
     * Vote for an idea
     */
    async CREATE_VOTE (context, payload)
    {
        await axios.post('/api/ideas/create-vote',{
            id: payload
        })

        .then(response => {
            console.log('create-vote', response);

            if (response.data.success)
            {
                // commit a mutation to update 1 idea in the paginated ideas
                context.commit('increaseIdeaVoteCount', payload); // payload is the idea.id coming from Idea.vue

                Vue.$vToastify.success("You voted for this idea!");
            }
         })
        .catch(error => {
            console.log('create-vote', error);
        });
    },

    /**
     * Delete a like in a comment
     */
    async DELETE_LIKE (context, payload)
    {
        await axios.post('/api/ideas/delete-like', {
            id: payload
        })
        .then(response => {
            console.log('delete-like', response);

            if (response.data.success)
            {
                context.commit('decreaseCommentLikesCount', payload)
            }
         })
        .catch(error => {
            console.log('delete-like', error);
        });
    },

    /**
     * Create a like in a comment
     */
    async CREATE_LIKE (context, payload)
    {
        await axios.post('/api/ideas/create-like', {
            id: payload
        })

        .then(response => {
            console.log('create-like', response);

            if (response.data.success)
            {
                context.commit('increaseCommentLikesCount', payload)
            }
         })
        .catch(error => {
            console.log('create-like', error);
        });
    },

    /**
     * Get request to get paginated ideas and filter them by status id
     */
    async GET_PAGINATED_IDEAS_BY_STATUS_ID (context, payload)
    {
        // when it's a get request and we want to add data with it, (like we do with post request) we need to add params: {}
        await axios.get('/api/ideas/get-paginated-ideas-by-status-id', {
            params: {
                statusId: payload
            }
        })
        .then(response => {
            console.log('get-paginated-ideas-by-status-id', response);

            if (response.data.success)
            {
                context.commit('getPaginatedIdeasByStatusId', response.data.ideas);
            }
         })
        .catch(error => {
            console.log('get-paginated-ideas-by-status-id', error);
        });
    },

    /**
     * Get request to get ideas by status id and count them
     */
    async COUNT_IDEAS_BY_STATUS (context)
    {
        await axios.get('/api/ideas/count-ideas-by-status')

        .then(response => {
            console.log('count-ideas-by-status', response);

            if(response.data.success)
            {
                context.commit('countIdeasByStatus', response.data)
            }
         })
        .catch(error => {
            console.log('count-ideas-by-status', error);
        });
    },

    /**
     * Get filtered ideas by category and filter on the main page
     */
    async GET_FILTERED_IDEAS (context, payload)
    {
        await axios.get('/api/ideas/get-filtered-ideas', {
            params: {
                selectedCategory: payload.selectedCategory,
                selectedFilter: payload.selectedFilter
            }
        })

        .then(response => {
            console.log('get-filtered-ideas', response);

            if (response.data.success)
            {
                context.commit('setFilteredIdea', response.data.filteredIdeas)
            }
         })
        .catch(error => {
            console.log('get-filtered-ideas', error);
        });
    },

    /**
     * Get Idea by title when the user searches
     */
    async SEARCH_IDEA_BY_TITLE (context, payload)
    {
        await axios.get('/api/ideas/get-ideas-by-title', {
            params: {
                ideaTitle: payload
            }
        })

        .then(response => {
            console.log('get-idea-by-title', response);

            if (response.data.success)
            {
                // context.commit('setIdeaByTitle', response.data.idea)
                context.commit('setPaginatedIdeas', response.data.ideas);
            }
         })
        .catch(error => {
            console.log('get-idea-by-title', error);
        });
    }

}
