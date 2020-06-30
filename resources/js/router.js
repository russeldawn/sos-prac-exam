import Vue from 'vue';
import VueRouter from 'vue-router';
import Layout from '../components/Layout.vue';
import Main from '../components/pages/Main.vue';
import Create from '../components/pages/Create.vue';
import Read from '../components/pages/Read.vue';
import Update from '../components/pages/Update.vue';
import Delete from '../components/pages/Delete.vue';

import ErrorPage from '../components/Error.vue';


Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Layout,
            name: 'Layout',
            meta: { requiresAuth: true },
            children: [
                {
                    path: '/',
                    component: Main,
                    name: 'list',
                },
                {
                    path: 'create',
                    component: Create,
                    name: 'create',
                },
                {
                    path: 'customer/:id/read',
                    component: Read,
                    name: 'read',
                },
                {
                    path: 'customer/:id/update',
                    component: Update,
                    name: 'update',
                },
                {
                    path: 'customer/:id/delete',
                    component: Delete,
                    name: 'delete',
                },
                {
                    path: 'customer/*',
                    component: ErrorPage,

                }
            ]
        },
        {
            path: '*',
            component: ErrorPage,

        }

    ],
    scrollBehavior(to, from, savedPosition) {
        return {
            x: 0,
            y: 0
        };
    }
});

router.beforeEach((to, from, next) => {

		next();

});

export default router;
