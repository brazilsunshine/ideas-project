export const actions = {
    /**
     * Call to actions to check if the user is authenticated or not
     */
    async CHECK_AUTH (context)
    {
        await axios.get('/api/user/check-auth')

        .then(response => {
            console.log('check_auth', response);

            if (response.data.auth) // if response.data.auth is successful
            {
                // set user
                context.commit('setUserObject', response.data.user);
            }
            else
            {
                // log the user out
                context.commit('logout');
            }
         })
        .catch(error => {
            console.log('check_auth', error);
        });
    }
}
