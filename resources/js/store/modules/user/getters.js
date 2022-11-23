export const getters = {
    /**
     * A global getter to check if the user is admin
     */
    isAdmin (state)
    {
        if (!state.auth) return false; // if state.auth is not true return false

        return (state.userObject.is_admin); // but if state.auth is true return userObject.is_admin
    }
}
