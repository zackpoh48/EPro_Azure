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
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">
                                    Sign In
                                </h4>
                                <!-- <p class="text-muted mb-4">
                                    Enter your email address and password to
                                    access admin panel.
                                </p> -->
                            </div>

                            <form @submit.prevent="login">
                                <div class="form-group">
                                    <label for="emailaddress">Email</label>
                                    <input class="form-control" type="email" id="emailaddress" placeholder="Email"
                                        v-model="form.email" v-bind:class="{
                                            'is-invalid': errors.email
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.email }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">RFQ</label>
                                    <input type="text" id="rfq" class="form-control" placeholder="RFQ"
                                        v-model="form.rfq_id" v-bind:class="{
                                            'is-invalid': errors.rfq_id
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.rfq_id }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" placeholder="Password"
                                            v-model="form.password" name="password" v-bind:class="{
                                                'is-invalid': errors.password
                                            }" />
                                        <div class="invalid-feedback">
                                            {{ errors.password }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">
                                        Log In
                                    </button>
                                </div>
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
    import Errors from "../common/Errors.js";
    import Config from "../common/Config.js";
    export default {
        components: {
            Loader
        },
        props: {
            companyLogoUrl: {
                type: String,
                default: ""
            }
        },
        data() {
            return {
                form: {
                    email: "",
                    rfq_id: "",
                    password: ""
                },
                errors: {},
                loading: false
            };
        },
        methods: {
            login() {
                if (this.checkForm()) {
                    this.loading = true;
                    axios
                        .post("/api/v1/login", this.form)
                        .then(res => res.data)
                        .then(res => {
                            console.log(res.data)
                            console.log(res.data.person_name)
                            this.$ls.set("authorization", res.data.token);
                            this.$ls.set("role", res.data.role);
                            this.$ls.set("tnc_url", res.data.tnc_url);
                            this.$ls.set("name", res.data.name);
                            this.$router.push({
                                path: "/tender-list"
                            });
                            $.toast({
                                heading: res.status,
                                text: res.message,
                                icon: "success"
                            });
                        })
                        .catch(error => {
                            error = error.response.data;
                            $.toast({
                                heading: error.status,
                                text: error.message,
                                icon: "error"
                            });
                        })
                        .finally(() => (this.loading = false));
                }
            },

            checkForm() {
                this.errors = {};
                let errorMessages = Errors.login;
                Object.keys(errorMessages).forEach(data => {
                    if (!this.form[data]) this.errors[data] = errorMessages[data];
                });

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
