<template>
    <div>
        <Header
            v-if="!routes.includes($route.name)"
            :companyLogoUrl="companyLogoUrl"
        ></Header>
        <div class="container-fluid">
            <div>
                <div class="wrapper">
                    <Sidebar v-if="!routes.includes($route.name)"></Sidebar>
                    <div class="content-page">
                        <div class="content">
                            <router-view
                                @updateComapnyLogo="updateComapnyLogo"
                                :companyLogoUrl="companyLogoUrl"
                                :key="$route.fullPath"
                            ></router-view>
                            <Footer
                                v-if="!routes.includes($route.name)"
                            ></Footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Config from "./components/common/Config.js";
export default {
    name: "app",
    components: {
        Sidebar: () => import("./components/layouts/Sidebar.vue"),
        Header: () => import("./components/layouts/Header.vue"),
        Footer: () => import("./components/layouts/Footer.vue")
    },
    data() {
        let base_url = Config.env.base_url;
        let companyLogoUrl = Config.env.company_logo;
        companyLogoUrl = base_url + companyLogoUrl;
        return {
            base_url,
            companyLogoUrl,
            routes: [
                "Verification Screen",
                "Supplier Registration",
                "Login",
                "Admin Login",
                "Not Found",
                "Print Pdf",
                "reset-password",
                "reset-password-form"
            ]
        };
    },
    methods: {
        updateComapnyLogo(logoUrl) {
            this.companyLogoUrl = this.base_url + logoUrl;
        }
    },
    mounted() {
        axios
            .get("/api/get-logo")
            .then(res => res.data)
            .then(res => {
                this.companyLogoUrl = this.base_url + res.data.logo;
            })
            .catch(error => {
                error = error.response.data;
            });
    }
};
</script>
