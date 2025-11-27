<template>
    <div class="navbar-custom bg-midnight">
        <div class="topbar container-fluid">
            <div class="d-flex align-items-center gap-lg-2 gap-1">
                <!-- Sidebar Menu Toggle Button -->
                <button @click="toggle()" class="button-toggle-menu d-md-none">
                    <unicon name="bars" fill="white"></unicon>
                </button>

                <!-- Topbar Brand Logo -->
                <div class="logo-topbar">
                    <!-- Logo light -->
                    <router-link to="/" class="logo-light">
                        <span class="logo-lg">
                            <img :src="companyLogoUrl" alt="logo" />
                        </span>
                    </router-link>
                </div>
            </div>
            <div class="d-flex gap-1"></div>

            <ul class="topbar-menu d-flex align-items-center gap-3">
                <li class="dropdown">
                    <a
                        class="nav-link nav-user px-2 text-light"
                        role="button"
                        aria-haspopup="false"
                        @click="logout"
                        aria-expanded="false"
                    >
                        <unicon name="power" fill="white"></unicon>
                        <span class="d-none d-sm-block">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script lang="ts">
import apiService from "../../commons/apiService";
export default {
    name: "nav-header",
    props: {
        companyLogoUrl: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            apiService: new apiService(),
            user: "",
            role: ",",
            companies: [],
            selectedCompany: localStorage.getItem("id"),
        };
    },
    // created() {
    //     this.$loadingStart();
    //     this.apiService.Get(`/api/users/companies`).then((res) => {
    //         this.$loadingStop();
    //         if (res.success) {
    //             this.companies = res.data;
    //         } else if (!res.message.includes("Invalid scope")) {
    //             this.$toast.error(res.message ?? "Something went wrong");
    //         }
    //     });
    // },
    methods: {
        onChange(e) {
            this.companies.forEach((company) => {
                if (company.id == e.target.value) {
                    localStorage.setItem("status", company.status.toString());
                    localStorage.setItem("company_name", company.company_name);
                    localStorage.setItem(
                        "company_reg_no",
                        company.company_reg_no
                    );
                    localStorage.setItem("vendor_no", company.vendor_no);
                    localStorage.setItem("id", company.id.toString());
                    this.$companyName.value = company.company_name;
                    this.$vendorNo.value = company.vendor_no;
                    switch (String(company.status)) {
                        case "1":
                        case "3":
                            this.$router.push("/profile-update");
                            break;
                        case "4":
                        case "5":
                            this.$router.push("/");
                            if (
                                this.$route.name ==
                                "Purchase Order(In Progress)"
                            ) {
                                this.$router.go();
                            }
                            break;
                        default:
                            this.$router.push("/status");
                            break;
                    }
                }
            });
        },
        toggle() {
            let html = document.getElementsByTagName("html")[0];
            html.classList.toggle("sidebar-enable");
        },
        logout() {
            this.apiService.logOut().then((res) => {
                this.$router.push("/admin");
            });
        },
    },
};
</script>
