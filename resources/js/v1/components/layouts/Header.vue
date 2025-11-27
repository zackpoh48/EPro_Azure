<template>
    <div class="navbar-custom topnav-navbar topnav-navbar-dark">
        <loader v-if="loading"></loader>
        <div class="container-fluid">
            <!-- LOGO -->
            <a class="topnav-logo">
                <span class="topnav-logo-lg">
                    <img :src="companyLogoUrl" alt="" height="50" />
                </span>
                <span class="topnav-logo-sm">
                    <img :src="companyLogoUrl" alt="" height="30" />
                </span>
            </a>

            <ul class="list-unstyled topbar-right-menu float-right mb-0">
                <li class="dropdown notification-list">
                    <a
                        class="nav-link dropdown-toggle nav-user arrow-none mr-0"
                        data-toggle="dropdown"
                        id="topbar-userdrop"
                        href="#"
                        role="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <span class="account-user-avatar">
                            <img
                                src="/assets/images/users/avatar-1.jpg"
                                alt="user-image"
                                class="rounded-circle"
                            />
                        </span>
                        <span>
                            <span
                                class="account-user-name"
                                v-if="role === 'user'"
                                >{{ name }}</span
                            >
                            <span
                                class="account-user-name"
                                v-if="role === 'admin'"
                                >{{ name }}</span
                            >
                        </span>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                        aria-labelledby="topbar-userdrop"
                    >
                        <!-- item-->
                        <a
                            href="#"
                            class="dropdown-item notify-item"
                            @click.prevent="logout"
                        >
                            <i class="mdi mdi-logout mr-1"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
            <a class="button-menu-mobile disable-btn">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        </div>
    </div>
</template>
<script>
import Loader from "../common/Loader.vue";
import Config from "../common/Config.js";
export default {
    components: {
        Loader,
    },
    props: {
        companyLogoUrl: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            company_logo_url: "",
            base_url: "",
            name: "",
            role: "",
            loading: false,
        };
    },
    methods: {
        logout() {
            let apiUrl =
                this.$ls.get("role") === "admin" ? "admin-logout" : "logout";
            let path = this.$ls.get("role") === "admin" ? "/admin" : "/login";
            axios
                .post(
                    `/api/${apiUrl}`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${this.$ls.get(
                                "authorization"
                            )}`,
                        },
                    }
                )
                .then((res) => res.data)
                .then((res) => {
                    if (apiUrl) {
                        this.$ls.remove("authorization");
                        this.$ls.remove("role");
                        this.$router.push({
                            path: path,
                        });
                    }
                    $.toast({
                        heading: res.status,
                        text: res.message,
                        icon: "success",
                    });
                })
                .catch((error) => {
                    error = error.response.data;
                    $.toast({
                        heading: error.status,
                        text: error.message,
                        icon: "error",
                    });
                })
                .finally(() => (this.loading = false));
        },
    },
    mounted() {
        if (this.$ls.get("authorization")) {
            this.name = this.$ls.get("name");
            this.role = this.$ls.get("role");
        }
    },
};
</script>
