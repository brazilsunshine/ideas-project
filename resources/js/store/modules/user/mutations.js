export const mutations = {
    /**
     * Changing user profile image to become the payload
     *
     * payload = new image uploaded by user
     */
    changeUserProfileImage (state, payload)
    {
        state.userObject.profile_image = payload;
    },

    /**
     * A user has logged in or registered
     */
    setUserObject (state, payload)
    {
        state.auth = true;
        state.userObject = payload;
    },

    /**
     * A user has logged out
     */
    logout (state)
    {
        state.auth = false;
        state.userObject = null;
    },

}
