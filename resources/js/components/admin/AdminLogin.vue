<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header text-center bg-midnight p-1">
                            <span
                                ><img
                                    :src="companyLogoUrl"
                                    alt="Company Logo"
                                    height="110"
                            /></span>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4
                                    class="text-dark-50 text-center pb-0 fw-bold"
                                >
                                    Sign In
                                </h4>
                            </div>

                            <form @submit.prevent ref="form">
                                <div
                                    class="mb-3"
                                    v-for="(formValue, key) in formGroup"
                                    :key="key"
                                >
                                    <label
                                        for="emailaddress"
                                        class="form-label"
                                        :class="{}"
                                        >{{ formValue.label
                                        }}<sup v-if="formValue.required"
                                            >*</sup
                                        ></label
                                    >
                                    <input
                                        :class="{
                                            'is-invalid': formValue.error,
                                            'form-control': true,
                                        }"
                                        :type="formValue.type"
                                        :id="key"
                                        v-model="formValue.value"
                                        @focusout.self="
                                            checkForm($event?.target?.id)
                                        "
                                        :placeholder="formValue.placeholder"
                                    />
                                    <small class="text-danger">{{
                                        formValue.error
                                    }}</small>
                                </div>
                                <!-- Captcha -->
                                <div
                                    class="g-recaptcha recaptcha mb-3"
                                    id="recaptcha"
                                    :data-sitekey="$siteKey"
                                ></div>

                                <div
                                    class="mb-0 text-center"
                                    @click="checkForm()"
                                >
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        Log In
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
</template>

<script lang="ts">
import axios from "axios";
import apiService from "../commons/apiService";
import CompanyLogo from "./CompanyLogo.vue";
export default {
    components: {},
    data() {
        return {
            companyLogoUrl: "",
            apiService: new apiService(),
            recaptchaResponse: "",
            widgetId: 0,
            isRecaptchaRendered: false,
            formGroup: {
                email: {
                    label: "Email",
                    placeholder: "Email",
                    type: "email",
                    message: "",
                    error: "",
                    required: true,
                    value: undefined,
                    rules(value: string) {
                        return [
                            !!value || "Email is Required",
                            /.+@.+\..+/.test(value) || "Invalid Email id",
                        ].filter((ele) => typeof ele != "boolean");
                    },
                },
                // vendorAccountNo: {
                //     label: "Vendor Account Code",
                //     placeholder: "RFQ",
                //     type: "text",
                //     message: "",
                //     error: "",
                //     required: true,
                //     value: undefined,
                //     rules(value: any) {
                //         return [
                //             !!value || "Vendor Account Code is required",
                //         ].filter((ele) => typeof ele != "boolean");
                //     },
                // },
                password: {
                    label: "Password",
                    placeholder: "Password",
                    type: "password",
                    message: "",
                    error: "",
                    required: true,
                    value: undefined,
                    rules(value: any) {
                        return [!!value || "Password is required"].filter(
                            (ele) => typeof ele != "boolean"
                        );
                    },
                },
            },
        };
    },
    methods: {
        execute() {
            window.grecaptcha.execute(this.widgetId);
        },
        reset() {
            window.grecaptcha.reset(this.widgetId);
        },
        render() {
            try {
                setTimeout(
                    function () {
                        if (!this.isRecaptchaRendered) {
                            if (
                                !window?.grecaptcha ||
                                typeof grecaptcha.render === "undefined" ||
                                typeof grecaptcha === "undefined"
                            ) {
                                console.log("retrying....");
                                this.render();
                            } else {
                                // clearTimeout(timeout);
                                try {
                                    if (!this.widgetId) {
                                        this.widgetId =
                                            window?.grecaptcha.render(
                                                "recaptcha",
                                                {
                                                    sitekey: this.$siteKey,
                                                    // the callback executed when the user solve the recaptcha
                                                    callback: (response) => {
                                                        this.recaptchaResponse =
                                                            response;
                                                    },
                                                }
                                            );
                                        this.isRecaptchaRendered = true;
                                    }
                                } catch (error) {
                                    // console.log(
                                    //     error.message,
                                    //     error.code,
                                    //     error,
                                    //     error.message.includes(
                                    //         "reCAPTCHA has already been rendered in this element"
                                    //     ),
                                    //     window.recaptcha ===
                                    //         document.getElementById("recaptcha")
                                    // );
                                    if (
                                        error.message.includes(
                                            "reCAPTCHA has already been rendered in this element"
                                        ) &&
                                        window.recaptcha ===
                                            document.getElementById("recaptcha")
                                    ) {
                                        location.reload();
                                    }
                                }
                            }
                        }
                    }.bind(this),
                    100
                );
            } catch (err) {
                console.log(err);
            }
        },
        submitForm() {
            let json: {
                email: string;
                password: string;
            };
            let apiURl = "/api/admin-login";
            json = {
                email: this.formGroup.email.value,
                password: this.formGroup.password.value,
                "g-recaptcha-response": this.recaptchaResponse,
            };
            this.$loadingStart();
            this.apiService
                .Post(apiURl, json)
                .then(
                    (res: {
                        success: boolean;
                        data: {
                            name: string;
                            role: string;
                            token: string;
                            organization_id: string;
                        };
                        message: string;
                    }) => {
                        if (res.success) {
                            localStorage.setItem("name", res.data.name);
                            // localStorage.setItem("email", res.data.email);
                            localStorage.setItem("token", res.data.token);
                            localStorage.setItem("role", res.data.role);
                            localStorage.setItem(
                                "organization_id",
                                res.data.organization_id
                            );
                            this.$toast.success(res.message);
                            this.$router.push({
                                path: "/admin/import",
                            });
                        } else {
                            this.$toast.error(res.message);
                        }
                    }
                )
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => {
                    this.reset();

                    this.$loadingStop();
                });
        },
        checkForm(key = "") {
            if (Boolean(key)) {
                this.formGroup[key].error = this.formGroup[key].rules(
                    this.formGroup[key].value
                ).length
                    ? this.formGroup[key].rules(this.formGroup[key].value)[0]
                    : "";
            } else {
                Object.keys(this.formGroup).forEach((k) => {
                    this.formGroup[k].error = this.formGroup[k].rules(
                        this.formGroup[k].value
                    ).length
                        ? this.formGroup[k].rules(this.formGroup[k].value)[0]
                        : "";
                });
            }
            if (Boolean(key) || this.recaptchaResponse == "") {
                return;
            }

            if (
                Object.values(this.formGroup).filter((e) => Boolean(e.error))
                    .length === 0
            ) {
                this.submitForm();
            } else {
                this.$toast.error("Invalid Entries");
            }
        },
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
        if (!this.isRecaptchaRendered) this.render();
        if (
            Boolean(
                localStorage.getItem("token") &&
                    localStorage.getItem("status") === "4"
            ) &&
            !Boolean(localStorage.pass_set)
        ) {
            this.$router.push("/");
        }
    },
};
</script>
<style scoped>
.g-recaptcha {
    display: flex;
    justify-content: center;
}
.margin {
    margin-bottom: 2px;
}
</style>
