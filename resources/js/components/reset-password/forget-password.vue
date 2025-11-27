<template>
    <div
        :class="{
            'account-pages pt-2 pt-sm-5 pb-4 pb-sm-5': !isChangePassword,
        }"
    >
        <div :class="{ container: !isChangePassword }">
            <div class="row justify-content-center">
                <div
                    :class="{
                        'w-75': emailVerified && !isChangePassword,
                        'col-xxl-4 col-lg-5': !emailVerified,
                    }"
                >
                    <div class="card">
                        <!-- Logo -->
                        <div
                            class="card-header text-center bg-primary"
                            v-if="!isChangePassword"
                        >
                            <span
                                ><img
                                    :src="companyLogoUrl"
                                    alt="logo"
                                    height="100"
                            /></span>
                        </div>
                        <div class="card-body p-4">
                            <template v-if="!emailVerified">
                                <div class="text-center w-100 m-auto">
                                    <h4
                                        class="text-dark-50 text-center mt-0 fw-bold"
                                    >
                                        Reset Password
                                    </h4>
                                    <p class="text-muted mb-4">
                                        Enter your email address and we'll send
                                        you an email with instructions to reset
                                        your password.
                                    </p>
                                </div>

                                <form @submit.prevent action="#">
                                    <div class="mb-3">
                                        <label
                                            for="emailaddress"
                                            class="form-label"
                                            >Email address</label
                                        >
                                        <input
                                            class="form-control"
                                            :class="{
                                                'is-invalid': email.error,
                                            }"
                                            @focusout="
                                                email.error = email
                                                    .rules(email.value)
                                                    .filter(
                                                        (e) =>
                                                            typeof e !=
                                                            'boolean'
                                                    )[0]
                                            "
                                            type="email"
                                            id="emailaddress"
                                            v-model="email.value"
                                            required
                                            placeholder="Enter your email"
                                        />
                                        <small class="text-danger">{{
                                            email.error
                                        }}</small>
                                    </div>

                                    <div class="mb-0 text-center">
                                        <button
                                            class="btn btn-primary"
                                            @click="verifyEmail()"
                                            type="submit"
                                        >
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </template>
                        </div>
                        <!-- end card-body-->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3" v-if="!isChangePassword">
                        <div class="col-12 text-center">
                            <p class="text-muted">
                                Back to
                                <router-link
                                    to="/sign-in"
                                    class="text-muted ms-1"
                                    ><b>Sign In</b></router-link
                                >
                            </p>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
</template>

<script lang="ts">
import axios from "axios";
import apiService from "../commons/apiService";
export default {
    props: {
        isChangePassword: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            companyLogoUrl: "",
            apiService: new apiService(),
            pageName: "",
            emailVerified: false,
            currentPassword: "",
            currentPasswordError: "",
            emailToken: {},
            email: {
                value: undefined,
                error: "",
                rules(value) {
                    return [
                        !!value || "Field is Required",
                        /.+@.+\..+/.test(value) || "Invalid Email id",
                    ].filter((ele) => typeof ele != "boolean");
                },
            },
        };
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
        verifyEmail() {
            if (this.email.error) {
                this.email.error = this.email
                    .rules(this.email.value)
                    .filter((e) => typeof e != "boolean")[0];

                return;
            }
            this.$loadingStart();
            this.apiService
                .Post("/api/reset-password", {
                    email: this.email.value,
                })
                .then((res) => {
                    this.$loadingStop();
                    if (res.success || res?.status_code?.toString() == "200") {
                        this.$toast.success(res.message);
                        this.email.value = "";
                        this.$router.push("/sign-in");
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                });
        },
    },
    mounted() {
        this.getLogo();
    },
};
</script>
