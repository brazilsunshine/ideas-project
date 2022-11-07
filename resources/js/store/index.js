import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import { errors } from './modules/errors'
import { ideas } from './modules/ideas'
import { modal } from './modules/modal'
import { user } from './modules/user'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [
        createPersistedState({
            key: 'so'
        })
    ],
    modules: {
        errors,
        ideas,
        modal,
        user
    }
});
