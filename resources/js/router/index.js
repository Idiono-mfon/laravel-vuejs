import { createRouter, createWebHistory } from "vue-router";

// admin

import homeAdminIndex from "../components/admin/home/index.vue";

// About

import aboutAdmin from "../components/admin/about/index.vue";

// Services

import serviceAdmin from "../components/admin/services/index.vue";

// Skills

import skillsAdminIndex from "../components/admin/skills/index.vue";

// pages

import homePageIndex from "../components/pages/home/index.vue";

// notfound
import notFound from "../components/notFound.vue";

// Login
import login from "../components/auth/login.vue";

const routes = [
    // admin
    {
        path: "/admin/home",
        name: "adminHome",
        component: homeAdminIndex,
        meta: {
            requiresAuth: true,
        },
    },

    // about
    {
        path: "/admin/about",
        name: "adminAbout",
        component: aboutAdmin,
        meta: {
            requiresAuth: true,
        },
    },

    // service
    {
        path: "/admin/services",
        name: "serviceAdmin",
        component: serviceAdmin,
        meta: {
            requiresAuth: true,
        },
    },

    // service
    {
        path: "/admin/skills",
        name: "skillsAdmin",
        component: skillsAdminIndex,
        meta: {
            requiresAuth: true,
        },
    },

    // pages
    {
        path: "/",
        component: homePageIndex,
        name: "Home",
        meta: {
            requiresAuth: false,
        },
    },

    // login
    {
        path: "/login",
        component: login,
        name: "Login",
        meta: {
            requiresAuth: false,
        },
    },

    // notFound
    {
        path: "/:pathMatch(.*)*",
        name: "notFound",
        component: notFound,
        meta: {
            requiresAuth: false,
        },
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem("token")) {
        // Redirect to Login
        return { name: "Login" };
    }

    if (!to.meta.requiresAuth && localStorage.getItem("token")) {
        return { name: "adminHome" };
    }
});

export default router;
