export const mutations = {

    /**
     * Adding new comment to array of comments
     */
    addCommentToSelectedIdea (state, payload)
    {
        // comments will become a new array of selectedIdea.comment
        let comments = [...state.selectedIdea.comments]; // this is how I see in the browser in my Vuex tab

        comments.unshift(payload); // unshift() will add the payload to the beginning of an array and returns the new length of the array.

        state.selectedIdea.comments = comments; // then update selectedIdea with the new comment
    },

    /**
     * Decrease the idea.voteCount
     */
    decreaseIdeaVoteCount (state, payload)
    {
        let ideas = [...state.paginated.data]; // this is how I see in the browser in my Vuex tab

        ideas = ideas.map(idea =>
        {
            if (idea.id === payload)
            {
                idea.votesCount--;

                idea.isVotedByUser = false;
            }

            return idea;
        });

        state.paginated.data = ideas; // then update paginated.data to become the new array
    },

    /**
     * After an Idea was voted for,
     *
     * We want to increase the idea.votesCount
     */
    increaseIdeaVoteCount (state, payload)
    {
        // Create a new array
        let ideas = [...state.paginated.data]; // the [...] is making a copy of my original array paginated.data

        // map will loop through the new ideas array
        // and return a new array with the updated thing
        ideas = ideas.map(idea => // idea is every idea in my ideas array
        {
           if (idea.id === payload) // and if one idea.id is equals to the idea.id in the payload
           {
               idea.votesCount++; // you can increment the votesCount

               idea.isVotedByUser = true; // and set isVotedByUser equals to true

           }

            return idea; // then return every idea updated in my new array
        });

        state.paginated.data = ideas; // then update paginated.data to become the new array
    },

    /**
     * Decrease comment likesCount
     */
    decreaseCommentLikesCount (state, payload)
    {
        let comments = [...state.selectedIdea.comments]

        comments = comments.map(comment =>
        {
            if (comment.id === payload)
            {
                comment.likesCount--;

                comment.isCommentLikedByCurrentUser = false;
            }

            return comment
        })

        state.selectedIdea.comments = comments;
    },

    /**
     * Increase comment likesCount
     */
    increaseCommentLikesCount (state, payload)
    {
        let comments = [...state.selectedIdea.comments]

        comments = comments.map(comment =>
        {
            if (comment.id === payload)
            {
                comment.likesCount++;

                comment.isCommentLikedByCurrentUser = true;
            }

            return comment;
        })

        state.selectedIdea.comments = comments;

    },

    /**
     * Set selectedIdea to null
     */
    setSelectedIdea (state, payload)
    {
        state.selectedIdea = payload;
    },

    /**
     * Updating paginated to become what's inside the response.data.ideas
     */
    setPaginatedIdeas (state, payload)
    {
        state.paginated = payload;
    },

    /**
     * Set categories to what's inside the response.data.categories
     */
    setCategories (state, payload)
    {
        state.categories = payload;
    },

    // /**
    //  * Show comments on SelectedIdea
    //  */
    // showComments (state, payload)
    // {
    //     state.selectedIdea = payload;
    // }

    /**
     * Toggle comment spam dialogue
     *
     * Display is coming from Comment.php
     */
    toggleCommentDisplay (state, payload)
    {
        let comments = [...state.selectedIdea.comments];

        comments = comments.map(comment => {
            if (comment.id === payload)
            {
                comment.display = !comment.display;
            }
            else
            {
                comment.display = false;
            }

            return comment;
        });

        state.selectedIdea.comments = comments;
    },

    /**
     * Toggle comments display in Profile.vue
     */
    toggleCommentDisplayIdesProfile (state, payload)
    {
        let data = [...state.paginated.data];

        let idea = data.find(idea => idea.id === payload.ideaId);

        let comments = [...idea.comments];

        comments = comments.map(comment => {
            if (comment.id === payload.commentId)
            {
                comment.display = !comment.display;
            }

            return comment;
        });

        idea.comments = comments;

        state.paginated.data = data;
    },

    /**
     * CLOSE COMMENTS DIALOG WHEN CLICKED OUTSIDE
     */
    closeCommentsDialog (state)
    {
        let comments = [...state.selectedIdea.comments]

        comments = comments.map(comment => { // .map is going to look for something in our array and do whatever is inside the brackets
            comment.display = false;

            return comment;
        });

        state.selectedIdea.comments = comments;
    },

    /**
     * Update state.paginated to become paginated idea by the status id
     */
    getPaginatedIdeasByStatusId (state, payload)
    {
        state.paginated = payload;
    },

    /**
     * Count ideas by status on the top of the page
     */
    countIdeasByStatus (state, payload)
    {
        state.counts = payload;
    },

    /**
     * Set state.paginated ideas to become the filtered idea
     */
    setFilteredIdea (state, payload)
    {
        state.paginated = payload;
    },

    /**
     * Update selected Idea status to become the status the admin updated
     */
    updateSelectedIdeaStatus (state, payload)
    {
        state.selectedIdea = payload;
    },

    /**
     * Close the comment's dialog in IdeaCommentsProfile.vue
     */
    closeCommentsDialogProfile (state)
    {
        let data = [...state.paginated.data];

        data = data.map(idea =>
        {
            let comments = [...idea.comments];

            comments = comments.map(comment =>
            {
                comment.display = false;

                return comment;
            });

            idea.comments = comments;

            return idea;
        });

        state.paginated.data = data;
    }


}
