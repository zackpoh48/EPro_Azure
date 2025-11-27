export default [
    {
        path: "/purchase-invoice/view-details/:doc_no",
        params: true,
        name: "View Purchase Invoice",
        component: () =>
            import(
                "./../components/purchase-invoice/purchase-invoice-view-details.vue"
            ),
    },
    {
        path: "/purchase-invoice/submit-delivery-order/:doc_no",
        params: true,
        name: "Submit Invoice",
        component: () =>
            import(
                "./../components/purchase-invoice/purchase-invoice-submit-invoice.vue"
            ),
    },
    {
        path: "/purchase-invoice",
        name: "Purchase Invoice",
        component: () =>
            import(
                "./../components/purchase-invoice/purchase-invoice-list.vue"
            ),
    },
];
