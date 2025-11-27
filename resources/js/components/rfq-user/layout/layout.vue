<template>
    <div class="wrapper">
        <nav-header :companyLogoUrl="companyLogoUrl"></nav-header>
        <side-nav :companyLogoUrl="companyLogoUrl"></side-nav>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <router-view
                        @updateComapnyLogo="updateComapnyLogo"
                        :companyLogoUrl="companyLogoUrl"
                        :key="$route.fullPath"
                    ></router-view>
                </div>
            </div>
            <Footer :companyLogoUrl="companyLogoUrl"></Footer>
        </div>
    </div>
</template>

<script lang="ts">
import NavHeader from "./nav-header.vue";
import SideNav from "./side-nav.vue";
import Footer from "./footer.vue";
import configurations from "../../commons/Config";
import axios from "axios";

export default {
    name: "Layout",
    components: {
        NavHeader,
        SideNav,
        Footer,
    },
    data() {
        return {
            companyLogoUrl: "",
            base_url: configurations.env.base_url,
        };
    },
    methods: {},
    created() {
        if (
            !localStorage.hasOwnProperty("token") ||
            !localStorage.hasOwnProperty("role") ||
            localStorage.getItem("role") !== "rfq_invite"
        ) {
            this.$router.push("/rfq");
        }
    },
    mounted() {
        axios
            .get("/api/get-logo")
            .then((res) => res.data)
            .then((res) => {
                // this.companyLogoUrl = this.base_url + res.data.logo;
                this.companyLogoUrl = res.data.logo;
            })
            .catch((error) => {
                error = error.response.data;
            });
    },
};
</script>
