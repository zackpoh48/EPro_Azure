export default [
    {
        path: "/purchase-quote/view-details/:doc_no",
        params: true,
        name: "View Purchase Quote",
        component: () =>
            import(
                "./../components/purchase-quote/purchase-quote-view-details.vue"
            ),
        props: true
    },
    {
        path: "/purchase-quote/submit-delivery-order",
        params: true,
        name: "Submit Quote",
        component: () =>
            import("./../components/purchase-quote/purchase-quote-submit.vue"),
    },
    {
        path: "/purchase-quote",
        name: "Purchase Quote List",
        component: () =>
            import("./../components/purchase-quote/purchase-quote-view.vue"),
    },
];
