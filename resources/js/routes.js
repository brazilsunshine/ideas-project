import VueRouter from "vue-router"
import store from './store'

// Middleware
import auth from './middleware/auth'
import middlewarePipeline from './middleware/middlewarePipeline'

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            component: require('./components/Home').default
        },
        {
            path: '/ideas/:id', // : will make the url
            component: require('./components/Home').default
        },
        {
            path: '/dashboard',
            component: require('./components/Dashboard').default,
            meta: {
                middleware: [ auth ]
            }
        },
        {
            path: '/login',
            component: require('./components/Login').default
        },
        {
            path: '/profile/:user', // : will make the url
            component: require('./components/Profile').default
        },
        {
            path: '/profile/:user/edit', // : will make the url
            component: require('./components/EditProfile').default
        },

        // {
        //     path: '/logout',
        //     component: require('./components/Login').default
        // },

        {
            path: '/register',
            component: require('./components/Register').default
        }
    ]
});

/**
 * Pipeline for multiple middleware
 */
router.beforeEach((to, from, next) => {

    if (! to.meta.middleware) return next();

    const middleware = to.meta.middleware

    const context = { to, from, next, store };

    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    });

});


export default router;
