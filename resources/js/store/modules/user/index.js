import { actions } from './actions';
import { mutations } from './mutations';

const state = {
    auth: false,
    userObject: null,
};

export const user = {
    state,
    actions,
    mutations
};
