
export default [

    {
        path: "/purchase-order/view-details/:doc_no",
        params: true,
        name: "Purcahse Order (View Details)",
        component: () =>
            import(
                "./../components/purchase-order/purchase-order-view-details.vue"
            ),
    },
    {
        path: "/purchase-order/submit-delivery-order/:doc_no",
        params: true,
        name: "Submit Delivery Order",
        component: () =>
            import(
                "./../components/purchase-order/purchase-order-submit-delivery-order.vue"
            ),
    },
    {
        path: "/purchase-order",
        name: "Purchase Order(In Progress)",
        component: () =>
            import("./../components/purchase-order/purchase-order-list.vue"),
    },
];
