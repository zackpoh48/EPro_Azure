// // Composables
import { createRouter, createWebHistory } from "vue-router";
import purchaseOrderRoutes from "./purchase-order-routes.ts";
import purchaseQuoteRoutes from "./purchase-quote-routes.js";
// import purchaseInvoiceRoutes from "./purchase-invoice-routes.js";
// import purchaseCreditMemoRoutes from "./purchase-credit-memo-routes.js";

const routes = [
    {
        path: "/admin",
        component: () => import("../components/admin/AdminLogin.vue"),
        name: "Admin Login",
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/admin",
        component: () => import("../components/admin/layout/layout.vue"),
        meta: {
            requiresAuth: true,
        },
        children: [
            {
                path: "import",
                name: "Admin Import",
                component: () => import("../components/admin/AdminImport.vue"),
            },
            {
                path: "settings",
                name: "Admin Settings",
                component: () =>
                    import("../components/admin/AdminSettings.vue"),
            },
            {
                path: "company-logo",
                name: "Company Logo",
                component: () => import("../components/admin/CompanyLogo.vue"),
            },
            {
                path: "rfq-invite",
                name: "RFQ Invite",
                component: () => import("../components/admin/RfqInvite.vue"),
            },
        ],
    },
    // {
    //     path: "/rfq",
    //     component: () => import("../components/rfq-user/RFQLogin.vue"),
    //     name: "RFQ User Login",
    //     meta: {
    //         requiresAuth: false,
    //     },
    // },
    // {
    //     path: "/rfq",
    //     component: () => import("../components/rfq-user/layout/layout.vue"),
    //     meta: {
    //         requiresAuth: true,
    //     },
    //     children: [
    //         {
    //             path: "tender-list",
    //             component: () =>
    //                 import("../components/rfq-user/ListTenders.vue"),
    //             name: "Tender List",
    //             meta: {
    //                 requiresAuth: true,
    //             },
    //         },
    //         {
    //             path: "tender-details/:rfq_id",
    //             component: () =>
    //                 import("../components/rfq-user/TenderDetails.vue"),
    //             name: "Tender Details",
    //             meta: {
    //                 requiresAuth: true,
    //             },
    //         },
    //     ],
    // },
    {
        // vendor registration v1
        path: "/register/:unique_id",
        component: () => import("../components/register/Registration.vue"),
        name: "Verification Screen",
    },
    {
        path: "/sign-in",
        name: "Sign In",
        component: () => import("./../components/sign-in/sign-in.vue"),
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/vendor-registration",
        name: "Vendor Registration",
        component: () =>
            import(
                "./../components/vendor-registration/vendor-registration.vue"
            ),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/forgot-password",
        name: "Forgot Password",
        component: () =>
            import("./../components/reset-password/reset-password.vue"),
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/forget-password",
        name: "Forget Password",
        component: () =>
            import("./../components/reset-password/forget-password.vue"),
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/profile-update",
        name: "Update Profile",
        component: () =>
            import("./../components/user-profile/user-profile.vue"),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/update-status/:status/:token/",
        name: "Admin",
        params: true,
        component: () =>
            import("./../components/approve-reject/approve-reject.vue"),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/status",
        name: "Information",
        params: true,
        component: () => import("./../components/information/information.vue"),
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "",
        component: () => import("./../components/layouts/layout.vue"),
        redirect: { name: "Purchase Order(In Progress)" },
        meta: {
            requiresAuth: true,
        },
        children: [
            {
                path: "/purchase-order",
                name: "Purchase Order",
                children: purchaseOrderRoutes,
            },
            {
                path: "/purchase-quote",
                name: "Purchase Quote",
                children: purchaseQuoteRoutes,
            },
            // {
            //     path: "/purchase-invoice",
            //     name: "Purchase Invoice",
            //     children: purchaseInvoiceRoutes,
            // },
            // {
            //     path: "/purchase-credit-memo",
            //     name: "Purchase Credit Memo",
            //     children: purchaseCreditMemoRoutes,
            // },
            {
                path: "/statement",
                name: "Statement",
                component: () =>
                    import("./../components/statement/statement.vue"),
            },
            {
                path: "/rfqs",
                name: "RFQs",
                component: () => import("./../components/rfq/ListTenders.vue"),
            },
            {
                path: "tender-details/:rfq_id",
                component: () => import("../components/e-tender/ETenderDetails.vue"),
                name: "User E-Tender Details",
            },
              {
                path: "/tenders",
                name: "E-Tenders",
                component: () => import("./../components/e-tender/ListETenders.vue"),
            },
            {
                path: "tender-details/:rfq_id",
                component: () => import("../components/rfq/TenderDetails.vue"),
                name: "User Tender Details",
            },
            //             {
            //                 path: "/purchase-order-history",
            //                 name: "Purchase Order History",
            //                 component: () =>
            //                     import(
            //                         "./../components/purchase-history/purchase-history-list.vue"
            //                     ),
            //             },
            {
                path: "/profile",
                name: "Profile",
                component: () =>
                    import("./../components/user-profile/user-profile.vue"),
            },
            {
                path: "/help-or-support",
                name: "Help & Support",
                component: () =>
                    import("./../components/help-support/help-support.vue"),
            },
            {
                path: "/change-password",
                name: "Change Password",
                component: () =>
                    import("./../components/reset-password/reset-password.vue"),
            },
        ],
    },
    {
        path: "/:catchAll(.*)",
        redirect: "/sign-in",
    },
];

const scrollBehavior = (to, from, savedPosition) => {
    return { top: 0, left: 0 };
};

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    scrollBehavior,
    // strict: true,
});

const RoleDashboard = {
    admin: "/admin/import",
    rfq_invite: "/rfq/tender-list",
    user: "/purchase-order",
};

router.beforeEach((to, from) => {
    const appName = document.body.dataset?.appname ?? "";
    document.title = appName + (to.name ? "-".concat(String(to.name)) : "");
    if (
        from.path == "/" &&
        to.path != "/sign-in" &&
        to.path != "/rfq" &&
        to.path != "/rfq/tender-list" &&
        !to.path.startsWith("/register/") &&
        to.path != "/forgot-password" &&
        to.path != "/forget-password" &&
        to.name != "Admin" &&
        to.name != "Admin Login" &&
        !localStorage.getItem("token")
    ) {
        router.push("/sign-in");
        return false;
    }
});

export default router;
