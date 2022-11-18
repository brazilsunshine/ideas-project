export const getters = {
    /**
     * A global getter to check if the user is admin
     */
    isAdmin (state)
    {
        if (!state.auth) return false;

        return (state.userObject.is_admin);
    }
}
