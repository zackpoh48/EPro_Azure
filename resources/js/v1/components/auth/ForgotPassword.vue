<template>
    <div class="account-pages mt-4">
        <loader v-if="loading"></loader>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a href="#">
                                <span><img :src="companyLogoUrl" alt="logo" width="100%" /></span>
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <form autocomplete="off" @submit.prevent="requestResetPassword" method="post">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" class="form-control" placeholder="user@example.com"
                                        v-model="email" />
                                    <div class="text-danger small mb-2 show">
                                        {{ errors.email }}
                                    </div>
                                    <div class="text-danger small mb-2 show">
                                        {{ message}}
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from "../common/Loader.vue";
    export default {
        components: {
            Loader
        },
        props: {
            companyLogoUrl: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                email: null,
                has_error: false,
                message: "",
                errors: {},
                loading: false
            };
        },
        methods: {
            requestResetPassword() {
                if (this.checkForm()) {
                    this.loading = true;

                    axios
                        .post("/api/reset-password", {
                            email: this.email
                        }).then(
                            result => {
                                this.response = result.data;
                                if (result.data.status_code === 200) {

                                    this.$router.push({
                                        name: "Admin Login"
                                    });
                                    this.message = result.data.message;
                                } else
                                    this.message = result.data.message;
                            },
                            error => {
                                console.error(error);
                            }
                        )
                        .finally(() => (this.loading = false));
                }
            },
            checkForm() {
                this.errors = {};
                if (!this.email)
                    this.errors.email = "Email is required";

                if (
                    Object.keys(this.errors).length === 0 &&
                    this.errors.constructor === Object
                ) {
                    return true;
                }
            }
        }
    };

</script>
