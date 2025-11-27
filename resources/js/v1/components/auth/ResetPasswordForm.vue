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
                            <form autocomplete="off" @submit.prevent="resetPassword" method="post">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" class="form-control" placeholder="user@example.com"
                                        v-model="email" />
                                    <div class="text-danger small mb-2 show">
                                        {{ errors.email }}
                                    </div>
                                    <div class="text-danger small mb-2 show">
                                        {{ email_message}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Password</label>
                                    <input type="password" id="password" class="form-control" placeholder=""
                                        v-model="password" />
                                    <div class="text-danger small mb-2 show">
                                        {{ errors.password }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Confirm Password</label>
                                    <input type="password" id="password_confirmation" class="form-control"
                                        placeholder="" v-model="password_confirmation" />
                                    <div class="text-danger small mb-2 show">
                                        {{ errors.password_confirmation }}
                                    </div>
                                </div>
                                <div class="text-danger small mb-2 show">
                                    {{error_password}}
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Update
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
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
                has_error: false,
                email_message: '',
                error_password: '',
                errors: {}
            };
        },
        methods: {
            resetPassword() {
                if (this.checkForm()) {

                    axios
                        .post("/api/reset/password/", {
                            token: this.$route.params.token,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        })
                        .then(
                            result => {
                                console.log(result.data);
                                if (result.data.status_code === 200) {

                                    this.$router.push({
                                        name: "Admin Login"
                                    });
                                    this.email_message = result.data.message;
                                } else {
                                    this.email_message = "Invalid Email Address";

                                }
                            },
                            error => {
                                this.error_password = error.response.data.errors.password[0];
                            }
                        );
                }
            },
            checkForm() {
                this.errors = {};
                if (!this.email || !this.password || !this.password_confirmation) {

                    this.errors.email = "Email is required";
                    this.errors.password = "Password Field is required";
                    this.errors.password_confirmation = "Confirm Password Field is required";
                }

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
