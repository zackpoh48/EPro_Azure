export default [
    {
        path: "/purchase-credit-memo/view-details",
        // params: true,
        name: "Purchase Credit Memo Details",
        component: () =>
            import("./../components/credit-memo/credit-memo-view-details.vue"),
    },
    {
        path: "/purchase-credit-memo/submit-credit-memo",
        // params: true,
        name: "Submit Credit Memo",
        component: () =>
            import("./../components/credit-memo/credit-memo-submit.vue"),
    },
    {
        path: "/purchase-credit-memo",
        name: "Purchase Credit Memo",
        component: () =>
            import("./../components/credit-memo/credit-memo-list.vue"),
    },
];
