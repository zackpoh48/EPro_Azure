<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-lg-6">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header text-center bg-midnight p-1">
                            <span
                                ><img
                                    :src="companyLogoUrl"
                                    alt="logo"
                                    height="110"
                            /></span>
                        </div>

                        <div class="card-body p-4 text-center">
                            <p>{{ message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import axios from "axios";
import apiService from "../commons/apiService";

export default {
    data() {
        return {
            companyLogoUrl: "",
            apiService: new apiService(),
            status: "",
            message: "",
            token: "",
        };
    },
    created() {
        this.status = this.$route.params.status;
        this.token = this.$route.params.token;
        this.$loadingStart();
        this.apiService
            .Post(`/api/users/${this.token}/status/${this.status}`, {})
            .then((res) => {
                this.message = res?.message;
                if (!res.success && !res.message.includes("Invalid scope")) {
                    this.$toast.error(res.message ?? "Something went wrong");
                }
            })
            .finally(() => {
                this.$loadingStop();
            });
    },

    methods: {
        getLogo() {
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
    },

    mounted() {
        this.getLogo();
    },
};
</script>
