export const mutations = {
    /**
     *
     */
    hideModal (state)
    {
        state.show = false;
    },

    /**
     *
     */
    showModal (state, payload)
    {
        state.show = true;
        state.title = payload.title;
        state.innerComponent = payload.innerComponent;
    }
}
