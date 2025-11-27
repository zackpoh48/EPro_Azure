<template>
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo-->
                        <div class="card-header text-center bg-primary">
                            <router-link to="/">
                                <span
                                    ><img
                                        src="assets/images/logo_with_text.png"
                                        alt="logo"
                                        height="100"
                                /></span>
                            </router-link>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center w-100 m-auto">
                                <h4
                                    class="text-dark-50 text-center mt-0 fw-bold"
                                >
                                    Vendor Registration
                                </h4>
                                <p
                                    class="text-muted mb-4"
                                    style="text-align: justify"
                                >
                                    Notice: Please complete all required fields
                                    on this page to register as a vendor. Once
                                    submitted, your registration will be
                                    reviewed by our team. You will receive an
                                    email notification regarding the status of
                                    your registration within 5 business days. If
                                    you have any questions or concerns, please
                                    contact our support team at
                                    <em>example@example.com</em>
                                </p>
                            </div>

                            <form ref="form" @submit.prevent>
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
                                        @focusout="checkForm(key)"
                                        :placeholder="formValue.placeholder"
                                    />
                                    <small class="text-danger">{{
                                        formValue.error
                                    }}</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="checkbox-signup"
                                            v-model="terms"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="checkbox-signup"
                                            >I accept
                                            <a href="" class="text-muted"
                                                >Terms and Conditions</a
                                            ></label
                                        >
                                    </div>
                                </div>

                                <div class="mb-3 text-center">
                                    <button
                                        class="btn btn-primary"
                                        :disabled="!isFormValid"
                                        type="submit"
                                        @click="checkForm()"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">
                                Already have account?
                                <router-link
                                    class="text-muted ms-1 cursor-pointer"
                                    to="/sign-in"
                                    ><b>Sign In</b></router-link
                                >
                            </p>
                        </div>
                        <!-- end col-->
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
export default {
    data() {
        return {
            apiService: new apiService(),
            terms: false,
            formGroup: {
                name: {
                    label: "User Name",
                    placeholder: "",
                    type: "text",
                    message: "",
                    error: "",
                    value: undefined,
                    required: true,
                    rules(value) {
                        return [!!value || "User Name is required"].filter(
                            (ele) => typeof ele != "boolean"
                        );
                    },
                },
                companyName: {
                    label: "Company Name",
                    placeholder: "",
                    type: "text",
                    message: "",
                    error: "",
                    value: undefined,
                    required: true,
                    rules(value) {
                        return [!!value || "Company Name is required"].filter(
                            (ele) => typeof ele != "boolean"
                        );
                    },
                },
                companyRegNo: {
                    label: "Company Reg No.",
                    placeholder: "",
                    type: "text",
                    message: "",
                    error: "",
                    value: undefined,
                    required: true,
                    rules(value: any) {
                        return [!!value || "Comapny Reg No is required"].filter(
                            (ele) => typeof ele != "boolean"
                        );
                    },
                },
                email: {
                    label: "Email address",
                    placeholder: "",
                    type: "email",
                    message: "",
                    error: "",
                    value: undefined,
                    required: true,
                    rules(value) {
                        return [
                            !!value || "Eamil is Required",
                            /.+@.+\..+/.test(value) || "Invalid Email id",
                        ].filter((ele) => typeof ele != "boolean");
                    },
                },
                reconfirmEmail: {
                    label: "Reconfirm Email address",
                    placeholder: "",
                    type: "email",
                    message: "",
                    error: "",
                    value: undefined,
                    required: true,
                    rules(value) {
                        return [
                            !!value || "Reconfirm Email is Required",
                            value[0] == value[1] ||
                                "Email address does not match",
                        ].filter((ele) => typeof ele != "boolean");
                    },
                },
            },
        };
    },
    computed: {
        isFormValid() {
            return (
                Object.values(this.formGroup).filter((e) => Boolean(e.error))
                    .length === 0 && this.terms
            );
        },
    },

    methods: {
        submitForm() {
            this.$loadingStart();
            let json = {
                vendor_no: this.formGroup.companyRegNo.value,
                company_name: this.formGroup.companyName.value,
                name: this.formGroup.name.value,
                email: this.formGroup.email.value,
            };

            this.apiService
                .Post("api/register", json)
                .then((res) => {
                    if (res.hasOwnProperty("success") && res.success) {
                        this.$toast.success(res.message);
                        this.$router.push("/sign-in");
                    } else if (res.hasOwnProperty("success") && !res.success) {
                        this.$toast.error(res.message);
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong."
                        );
                    }
                })
                .finally(() => {
                    this.$loadingStop();
                });
        },
        checkForm(key = "") {
            if (Boolean(key)) {
                this.formGroup[key].error = this.formGroup[key].rules(
                    this.formGroup[key].value
                ).length
                    ? this.formGroup[key].rules(
                          key == "reconfirmEmail"
                              ? [
                                    this.formGroup[key].value,
                                    this.formGroup["email"].value,
                                ]
                              : this.formGroup[key].value
                      )[0]
                    : "";
            } else {
                Object.keys(this.formGroup).forEach((k) => {
                    this.formGroup[k].error = this.formGroup[k].rules(
                        this.formGroup[k].value
                    ).length
                        ? this.formGroup[k].rules(
                              k == "reconfirmEmail"
                                  ? [
                                        this.formGroup[k].value,
                                        this.formGroup["email"].value,
                                    ]
                                  : this.formGroup[k].value
                          )[0]
                        : "";
                });
            }
            if (Boolean(key)) {
                return;
            }

            if (
                Object.values(this.formGroup).filter((e) => Boolean(e.error))
                    .length === 0 &&
                this.terms
            ) {
                this.submitForm();
            } else if (
                Object.values(this.formGroup).filter((e) => Boolean(e.error))
                    .length
            ) {
                this.$toast.error("Invalid Entries");
            } else if (!this.terms) {
                this.$toast.error("Accept Terms & Conditions.");
                return;
            }
        },
        matchEmail() {
            return (
                this.formGroup.email.value ==
                    this.formGroup.reconfirmEmail.value ||
                "Email address does not match"
            );
        },
    },
};
</script>
