import { actions } from './actions';
import { mutations } from './mutations';

const state = {
    selectedIdea: null,
    paginated: null,
    categories: null,
    counts: {
        all: 0,
        considering: 0,
        inProgress: 0,
        implemented: 0,
        closed: 0
    }
};

export const ideas = {
    state,
    actions,
    mutations
};
