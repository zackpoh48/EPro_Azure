<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header text-center p-1">
                            <span
                                ><img
                                    :src="companyLogoUrl"
                                    alt="logo"
                                    height="110"
                                    class="w-100 object-fit-contain"
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
                                <div class="d-flex align-items-center py-3">
                                    <div
                                        class="dropdown-divider border-bottom w-50"
                                    ></div>
                                    <small class="text-muted mx-2">OR</small>
                                    <div
                                        class="dropdown-divider border-bottom w-50"
                                    ></div>
                                </div>
                                <div>
                                    <router-link
                                        type="button"
                                        class="btn d-block btn-outline-dark w-100 mb-2"
                                        to="/forget-password"
                                        >Forgot Password?</router-link
                                    >
                                    <!-- <router-link
                                        type="button"
                                        class="btn d-block btn-outline-dark w-100 mb-2"
                                        to="/vendor-registration"
                                        >New Vendor Registration</router-link
                                    > -->
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
    <template v-if="showUpdatePasswordPopUp">
        <div class="modal-backdrop"></div>
        <div
            class="modal fade show d-block"
            tabindex="-1"
            :aria-hidden="false"
            :aria-modal="true"
            role="dialog"
            @click.self="showUpdatePasswordPopUp = false"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-auto"
            >
                <div class="modal-content">
                    <div class="modal-body py-0">
                        <ResetPassword :isChangePassword="true"></ResetPassword>
                    </div>
                    <div
                        class="text-center py-2 gap-2 d-flex justify-content-center align-items-center"
                    ></div>
                </div>
            </div></div
    ></template>
    <template v-if="showUserCompaniesPopUp">
        <div class="modal-backdrop"></div>
        <div
            class="modal fade show d-block"
            tabindex="-1"
            :aria-hidden="false"
            :aria-modal="true"
            role="dialog"
            @click.self="showUserCompaniesPopUp = false"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-auto"
                style="justify-content: center"
            >
                <div class="modal-content" style="width: 50%">
                    <div class="modal-body d-flex flex-column">
                        <span style="text-align: center">Select Company:</span>
                        <button
                            type="button"
                            class="btn btn-light margin"
                            v-for="company in companies"
                            :key="company.id"
                            @click="selectCompany(company)"
                        >
                            <div>
                                {{ company.company_name }}
                                ({{ company.organization_name }})
                            </div>
                        </button>
                    </div>
                    <!-- <div
                        class="text-center py-2 gap-2 d-flex justify-content-center align-items-center"
                    ></div> -->
                </div>
            </div>
        </div></template
    >
</template>

<script lang="ts">
import axios from "axios";
import apiService from "../commons/apiService";
import ResetPassword from "./../reset-password/reset-password.vue";
export default {
    components: { ResetPassword },
    data() {
        return {
            companyLogoUrl: "",
            apiService: new apiService(),
            showUpdatePasswordPopUp: false,
            showUserCompaniesPopUp: false,
            recaptchaResponse: "",
            companies: null,
            widgetId: 0,
            isRecaptchaRendered: false,
            formGroup: {
                username: {
                    label: "Username",
                    placeholder: "Username",
                    type: "text",
                    message: "",
                    error: "",
                    required: true,
                    value: undefined,
                    rules(value: string) {
                        // return [
                        //     !!value || "Email is Required",
                        //     /.+@.+\..+/.test(value) || "Invalid Email id",
                        // ].filter((ele) => typeof ele != "boolean");
                        return true;
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
        selectCompany(company) {
            this.$companyName.value = company.company_name;
            this.$vendorNo.value = company.vendor_no;
            localStorage.setItem("status", company.status.toString());
            localStorage.setItem("company_name", company.company_name);
            localStorage.setItem("company_reg_no", company.company_reg_no);
            localStorage.setItem("vendor_no", company.vendor_no);
            localStorage.setItem("id", company.id.toString());
            switch (String(company.status)) {
                case "1":
                case "3":
                    this.$router.push("/profile-update");
                    break;
                case "4":
                case "5":
                    if (Boolean(localStorage.pass_set == "1")) {
                        this.$router.push("/");
                    } else {
                        this.showUserCompaniesPopUp = false;
                        this.showUpdatePasswordPopUp = true;
                    }
                    break;
                default:
                    this.$router.push("/status");
                    break;
            }
        },
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
                username: string;
                password: string;
                // vendor_no: string
            };
            let apiURl = "api/login";
            // let apiURl = this.formGroup.vendorAccountNo.value
            //     ? "api/login"
            //     : "api/admin-login";
            // if (this.formGroup.vendorAccountNo.value) {
            json = {
                username: this.formGroup.username.value,
                password: this.formGroup.password.value,
                // vendor_no: this.formGroup.vendorAccountNo.value,
                "g-recaptcha-response": this.recaptchaResponse,
            };
            // } else {
            //     json = {
            //         email: this.formGroup.email.value,
            //         password: this.formGroup.password.value,
            //         "g-recaptcha-response": this.recaptchaResponse
            //     };
            // }
            this.$loadingStart();
            this.apiService
                .Post(apiURl, json)
                .then(
                    (res: {
                        success: any;
                        data: {
                            companies: {
                                company_name: string;
                                vendor_no: string;
                                company_reg_no: string;
                                status: number;
                                id: number;
                            }[];
                            // [x: string]: string;
                            // company_name: string;
                            // vendor_no: string;
                            name: string;
                            email: string;
                            token: string;
                            is_password_updated: string;
                            troubleshooting_guide_url: string;
                            user_manual_url: string;
                            organization_id: string;
                        };
                        message: any;
                    }) => {
                        if (res.success) {
                            localStorage.setItem("name", res.data.name);
                            localStorage.setItem("email", res.data.email);
                            localStorage.setItem("token", res.data.token);
                            localStorage.setItem(
                                "pass_set",
                                res.data?.is_password_updated
                            );
                            localStorage.setItem(
                                "troubleshooting_guide_url",
                                res.data.troubleshooting_guide_url
                            );
                            localStorage.setItem(
                                "user_manual_url",
                                res.data.user_manual_url
                            );
                            localStorage.setItem(
                                "organization_id",
                                res.data.organization_id
                            );

                            this.companies = res.data.companies;
                            if (res.data.companies.length > 1) {
                                this.showUserCompaniesPopUp = true;
                            } else {
                                const company: {
                                    company_name: string;
                                    vendor_no: string;
                                    company_reg_no: string;
                                    status: number;
                                    id: number;
                                } = res.data.companies[0];

                                localStorage.setItem(
                                    "status",
                                    company.status.toString()
                                );
                                localStorage.setItem(
                                    "company_name",
                                    company.company_name
                                );
                                localStorage.setItem(
                                    "company_reg_no",
                                    company.company_reg_no
                                );
                                localStorage.setItem(
                                    "vendor_no",
                                    company.vendor_no
                                );
                                localStorage.setItem(
                                    "id",
                                    company.id.toString()
                                );
                                this.$companyName.value = company.company_name;
                                this.$vendorNo.value = company.vendor_no;

                                switch (String(company.status)) {
                                    case "1":
                                    case "3":
                                        this.$router.push("/profile-update");
                                        break;
                                    case "4":
                                    case "5":
                                        if (
                                            Boolean(
                                                localStorage.pass_set == "1"
                                            )
                                        ) {
                                            this.$router.push("/");
                                        } else {
                                            this.showUserCompaniesPopUp = false;
                                            this.showUpdatePasswordPopUp = true;
                                        }
                                        break;
                                    default:
                                        this.$router.push("/status");
                                        break;
                                }
                            }
                        } else {
                            this.$toast.error(res.message);
                        }
                    }
                )
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

<!-- enum
1: pending
2: rejected
3: approvwed
4: submitted
5: approve resubmission
-->
