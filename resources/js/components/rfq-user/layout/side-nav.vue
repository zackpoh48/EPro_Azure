<template>
    <div class="leftside-menu">
        <!-- Brand Logo Light -->
        <a href="/" class="logo">
            <span>
                <img height="60" :src="companyLogoUrl" alt="logo" />
            </span>
        </a>

        <!-- Sidebar Hover Menu Toggle Button -->
        <div
            class="button-sm-hover"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            title="Show Full Sidebar"
            @click="toggle()"
        >
            <unicon name="times"></unicon>
        </div>

        <!-- Full Sidebar Menu Close Button -->
        <div class="button-close-fullsidebar" @click="toggle()">
            <unicon name="times"></unicon>
        </div>

        <!-- Sidebar -left -->
        <div class="max-h-100" id="leftside-menu-container" data-simplebar>
            <!-- Leftbar User -->
            <div class="leftbar-user">
                <!-- <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm"> -->
                <span class="leftbar-user-name mt-2"
                    >Name: {{ this.name }}</span
                >
                <span class="leftbar-user-name text-muted mt-2">
                    Role: {{ this.role }}
                </span>
            </div>

            <!--- Sidemenu -->
            <ul class="side-nav" data-simplebar>
                <li class="side-nav-title">Menu</li>

                <li
                    class="side-nav-item"
                    :to="option.route"
                    v-for="option of menuList"
                    :key="option.id"
                    @click="toggle()"
                >
                    <router-link
                        :to="option.route"
                        active-class="active-link"
                        class="side-nav-link"
                    >
                        <unicon :name="option.icon" fill="dark"></unicon>
                        <span> {{ option.name }} </span>
                    </router-link>
                </li>
            </ul>
            <!--- End Sidemenu -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            vendor_no: "",
            menuList: [
                {
                    name: "Tender list",
                    route: "/rfq/tender-list",
                    selected: true,
                    icon: "receipt",
                    value: "Tenderlist",
                },
            ],
        };
    },
    name: "side-nav",
    props: {
        companyLogoUrl: {
            type: String,
            default: "",
        },
    },
    methods: {
        toggle() {
            let html = document.getElementsByTagName("html")[0];
            html.classList.toggle("sidebar-enable");
        },
    },
    created() {
        this.name = localStorage.getItem("name");
        this.role = localStorage.getItem("role");
        // this.vendor_no = localStorage.getItem("vendor_no");
        // this.companyName = localStorage.getItem("company_name");
    },
    computed: {
        // companyName() {
        //     return this.$companyName;
        // },
        // vendorNo() {
        //     return this.$vendorNo;
        // },
    },
};
</script>

<style lang="scss" scoped>
.leftbar-user {
    background-image: url("./../../assets/images/waves.png") !important;
    background-size: cover;
}
</style>
