import VueRouter from "vue-router";

const router = new VueRouter({
    mode: "history",
    routes: [{
            path: "*",
            component: () => import("../components/NotFound.vue"),
            name: "Not Found"
        },
        {
            path: "/admin",
            //beforeEnter: requireLogin,
            component: () => import("../components/auth/AdminLogin.vue"),
            name: "Admin Login"
        },
        {
            path: "/login",
            // beforeEnter: requireLogin,
            component: () => import("../components/auth/Login.vue"),
            name: "Login"
        },
        {
            path: '/reset-password',
            beforeEnter: requireLogin,
            name: 'reset-password',
            component: () => import("../components/auth/ForgotPassword.vue"),
            meta: {
                requiresAuth: false
            }
        },
        {
            path: '/reset-password/:token',
            name: 'reset-password-form',
            component: () => import("../components/auth/ResetPasswordForm.vue"),
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/tender-list",
            component: () => import("../components/tender/List.vue"),
            name: "Tender List",
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/tender-details/:rfq_id",
            component: () => import("../components/tender/Details.vue"),
            name: "Tender Details",
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/register/:unique_id",
            component: () => import("../components/auth/Registration.vue"),
            name: "Verification Screen"
        },
        // {
        //     path: "/registration-form/:unique_id",
        //     component: () => import("../components/auth/Registration.vue"),
        //     name: "Supplier Registration"
        // },
        {
            path: "/admin-import",
            component: () => import("../components/admin/Import.vue"),
            name: "Admin Import",
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/admin-settings",
            component: () => import("../components/admin/Settings.vue"),
            name: "Admin Settings",
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/company-logo",
            component: () => import("../components/admin/CompanyLogo.vue"),
            name: "Company Logo",
            meta: {
                requiresAuth: true
            }
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!localStorage.getItem("authorization")) {

            next('/login');
        } else {
            next(true);
        }
    } else {
        next(true);
    }
});

function requireLogin(to, from, next) {
    if (localStorage.getItem('authorization')) {
        if (localStorage.getItem('role') === 'admin')
            next('/admin-import');
        else
            next('/tender-list');
    } else {
        next(true)
    }
}

export default router;
