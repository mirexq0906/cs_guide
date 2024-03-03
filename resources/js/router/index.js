import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/admin',
            component: () => import('../pages/Admin/Index.vue'),
            children: [
                {
                    path: '/admin/categories',
                    components: {
                        adminPage: () => import('../pages/Admin/Categories.vue'),
                    },
                },
                {
                    path: '/admin/sub_categories',
                    components: {
                        adminPage: () => import('../pages/Admin/SubCategories.vue'),
                    },
                },
                {
                    path: '/admin/places',
                    components: {
                        adminPage: () => import('../pages/Admin/Places.vue'),
                    },
                },
                {
                    path: '/admin/actions',
                    components: {
                        adminPage: () => import('../pages/Admin/Actions.vue'),
                    },
                },
            ]
        },
        {
            path: '/',
            component: () => import('../pages/Client/Index.vue'),
        },
        {
            path: '/category/:category_id/subcategory/:sub_category_id',
            name: 'places',
            component: () => import('../pages/Client/Actions/Index.vue'),
            children: [
                {
                    path: '/category/:category_id/subcategory/:sub_category_id/action/:action_id',
                    name: 'action',
                    components: {
                        placesPage: () => import('../pages/Client/Actions/Action.vue'),
                    },
                },
            ]
        },
    ]
});

export default router
