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
                    <template v-if="emailVerified">
                        <div class="w-100 m-auto">
                            <h4 class="text-dark-50 mb-3 mt-4 fw-bold">
                                Change Password
                            </h4>
                        </div>
                    </template>
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
                            <template v-if="emailVerified">
                                <!-- <div class="text-center w-100 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 fw-bold">
                                        {{ pageName }}
                                    </h4>
                                </div> -->
                                <form @submit.prevent action="#">
                                    <template v-if="isChangePassword">
                                        <input type="password" class="d-none" />
                                        <div class="mx-sm-2 mb-sm-3 mx-0">
                                            <label for="key" class="form-label"
                                                >Current Password<sup
                                                    >*</sup
                                                ></label
                                            >
                                            <input
                                                :class="{
                                                    'is-invalid':
                                                        currentPasswordError,
                                                    'form-control': true,
                                                }"
                                                type="password"
                                                id="changePassword"
                                                v-model="currentPassword"
                                                @focusout="
                                                    currentPasswordError =
                                                        currentPassword
                                                            ? ''
                                                            : 'Field is Required'
                                                "
                                            />
                                            <small class="text-danger">{{
                                                currentPasswordError
                                            }}</small>
                                        </div>
                                    </template>
                                    <div class="d-flex flex-column flex-md-row">
                                        <div
                                            class="mx-sm-2 mb-sm-3 mx-0 w-50 w-100"
                                            v-for="(
                                                formValue, key
                                            ) in setPassword"
                                            :key="key"
                                        >
                                            <label for="key" class="form-label"
                                                >{{ formValue.label
                                                }}<sup v-if="formValue.required"
                                                    >*</sup
                                                ></label
                                            >
                                            <input
                                                :class="{
                                                    'is-invalid':
                                                        formValue.error,
                                                    'form-control': true,
                                                }"
                                                type="password"
                                                :id="key"
                                                v-model="formValue.value"
                                                @focusout="checkForm(key)"
                                            />
                                            <small class="text-danger">{{
                                                formValue.error
                                            }}</small>
                                        </div>
                                    </div>

                                    <div
                                        class="mb-0 text-center text-sm-end mx-2 mt-2"
                                    >
                                        <button
                                            class="btn btn-success"
                                            @click="checkForm()"
                                            type="submit"
                                        >
                                            Update Password
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
import apiService from "../commons/apiService";
import axios from "axios";
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
            // isChangePassword: false,
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
            setPassword: {
                newPassword: {
                    label: "New Password",
                    value: "",
                    required: true,
                    error: "",
                    rules(value) {
                        return [!!value || "Field is Required"].filter(
                            (ele) => typeof ele != "boolean"
                        );
                    },
                },
                confirmPassword: {
                    label: "Confirm New Password",
                    value: "",
                    required: true,
                    error: "",
                    rules(value) {
                        return [
                            !!value[0] || "Field is Required",
                            value[0] == value[1] || "Password does not match",
                        ].filter((ele) => typeof ele != "boolean");
                    },
                },
            },
        };
    },
    created: function () {
        this.pageName = this.$route?.name?.toString()!;
        if (
            // this.pageName.toLowerCase().includes("change") &&
            Boolean(localStorage.getItem("email"))
        ) {
            this.emailVerified = true;
            // this.isChangePassword = true;
        }
        if (this.$route.query.hasOwnProperty("token")) {
            this.emailToken = this.$route.query;
            this.emailVerified = true;
        }
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
        updatePassword() {
            this.$loadingStart();
            let json = {};
            const url = this.isChangePassword
                ? "/api/users/update-password"
                : "/api/reset/password";
            if (this.isChangePassword) {
                json = {
                    current_password: this.currentPassword,
                    password: this.setPassword.newPassword.value,
                    password_confirmation:
                        this.setPassword.confirmPassword.value,
                };
            } else {
                json = {
                    email: this.emailToken?.email,
                    password: this.setPassword.newPassword.value,
                    password_confirmation:
                        this.setPassword.confirmPassword.value,
                    token: this.emailToken?.token,
                };
            }
            this.apiService.Post(url, json).then((res) => {
                this.$loadingStop();
                if (res.success || res["status_code"]?.toString() == "200") {
                    this.email.value = "";
                    this.$toast.success(res.message ?? "Password Updated");
                    this.currentPassword = "";
                    this.setPassword.newPassword.value = "";
                    this.setPassword.confirmPassword.value = "";
                    if (!this.isChangePassword) {
                        this.$router.push("/sign-in");
                    } else if (Boolean(localStorage.pass_set == "0")) {
                        localStorage.setItem("pass_set", "1");
                        this.$router.push("/");
                    }
                } else if (!res.message.includes("Invalid scope")) {
                    this.$toast.error(
                        res.message ??
                            res.data.message ??
                            "Something went wrong"
                    );
                }
            });
        },

        checkForm(key = "") {
            if (Boolean(key)) {
                this.setPassword[key].error = this.setPassword[key].rules(
                    this.setPassword[key].value
                ).length
                    ? this.setPassword[key].rules(
                          key == "confirmPassword"
                              ? [
                                    this.setPassword[key].value,
                                    this.setPassword["newPassword"].value,
                                ]
                              : this.setPassword[key].value
                      )[0]
                    : "";
            } else {
                Object.keys(this.setPassword).forEach((k) => {
                    this.setPassword[k].error = this.setPassword[k].rules(
                        this.setPassword[k].value
                    ).length
                        ? this.setPassword[k].rules(
                              k == "confirmPassword"
                                  ? [
                                        this.setPassword[k].value,
                                        this.setPassword["newPassword"].value,
                                    ]
                                  : this.setPassword[k].value
                          )[0]
                        : "";
                });
            }
            if (Boolean(key)) {
                return false;
            }

            if (
                Object.values(this.setPassword).filter((e) => Boolean(e.error))
                    .length === 0
            ) {
                this.updatePassword();
            } else if (
                Object.values(this.setPassword).filter((e) => Boolean(e.error))
                    .length
            ) {
                this.$toast.error("Invalid Entries");
            }
        },
    },
    mounted() {
        this.getLogo();
    },
};
</script>
