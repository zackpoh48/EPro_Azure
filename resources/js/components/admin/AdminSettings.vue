<template>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="postSettings">
                        <div class="row">
                            <div class="col-12">
                                <h3>Settings / Configuration Page</h3>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-1">
                                    <label class="form-label"
                                        >NAV SOAP services</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="URL"
                                        v-model="form.soap_url"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-1">
                                    <label class="form-label"
                                        >Edit external URL for T&C</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="URL"
                                        v-model="form.tnc_url"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-1">
                                    <label class="form-label"
                                        >NAV Username</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="USERNAME"
                                        v-model="form.nav_username"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-1">
                                    <label class="form-label"
                                        >NAV Password</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="PASSWORD"
                                        v-model="form.nav_password"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-1">
                                    <label class="form-label"
                                        >NAV Auth Type</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="AUTH TYPE"
                                        v-model="form.nav_authtype"
                                    />
                                </div>
                            </div>
                            <!-- <div class="col-12 col-md-12">
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox form-check">
                                        <input type="checkbox" class="custom-control-input" id="invalidCheck"
                                            v-model="form.e_sign" :checked="form.e_sign" />
                                        <label class="custom-control-label" for="invalidCheck">Allow eSignature
                                            field</label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-12 text-right">
                                <button
                                    class="btn btn-primary mt-1"
                                    type="submit"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="changeEmailAddress">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label"
                                        >Admin Email</label
                                    >
                                    <input
                                        type="email"
                                        class="form-control"
                                        placeholder="admin@admin.com"
                                        v-model="email"
                                    />
                                    <div class="text-danger small mb-2 show">
                                        {{ errors.email }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button class="btn btn-primary" type="submit">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="changeAdminPassword">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email"
                                        >New Password</label
                                    >
                                    <input
                                        type="password"
                                        id="newPassword"
                                        class="form-control"
                                        placeholder=""
                                        v-model="newPassword"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label"
                                        >Confirm New Password</label
                                    >
                                    <input
                                        type="password"
                                        id="confirmNewPassword"
                                        class="form-control"
                                        placeholder=""
                                        v-model="confirmNewPassword"
                                    />
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button
                                    class="btn btn-primary mt-2"
                                    type="submit"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components: {},
    data() {
        return {
            loading: false,
            form: {
                soap_url: "",
                tnc_url: "",
                nav_username: "",
                nav_password: "",
                nav_authtype: "",
            },
            email: "",
            newPassword: "",
            confirmNewPassword: "",
            newPassword_error: "",
            confirmNewPassword_error: "",
            errors: {},
        };
    },

    methods: {
        postSettings() {
            this.loading = true;
            axios
                .post("/api/settings", this.form, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((res) => res.data)
                .then((res) => {
                    this.$toast.success(res.message);
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => (this.loading = false));
        },

        getSettings() {
            this.loading = true;
            axios
                .get("/api/settings", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((res) => res.data)
                .then((res) => {
                    this.form = res.data;
                    this.$toast.success(res.message);
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => (this.loading = false));
        },
        getAdminDetails() {
            axios
                .get("/api/get-admin-name", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((res) => res.data)
                .then((res) => {
                    this.email = res.data.email;
                })
                .catch((error) => {
                    error = error.response.data;
                });
        },
        changeEmailAddress() {
            if (this.checkForm()) {
                axios
                    .post(
                        "/api/update-admin-email",
                        {
                            email: this.email,
                        },
                        {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                    "token"
                                )}`,
                            },
                        }
                    )
                    .then((res) => res.data)
                    .then((res) => {
                        if (res.success === true) {
                            this.$toast.success(res.message);
                            localStorage.removeItem("token");
                            localStorage.removeItem("role");
                            setTimeout(
                                () =>
                                    this.$router.push({
                                        path: "/admin",
                                    }),
                                2000
                            );
                            this.email = res.data.email;
                        }
                    })
                    .catch((error) => {
                        error = error.response.data;
                        this.$toast.error(error.message);
                    });
            }
        },
        changeAdminPassword() {
            axios
                .post(
                    "/api/admin-change-password",
                    {
                        newPassword: this.newPassword,
                        confirmNewPassword: this.confirmNewPassword,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                )
                .then((res) => res.data)
                .then((res) => {
                    if (res.success === true) {
                        this.$toast.success(res.message);
                        localStorage.removeItem("token");
                        localStorage.removeItem("role");
                        setTimeout(
                            () =>
                                this.$router.push({
                                    path: "/admin",
                                }),
                            2000
                        );
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        Object.entries(this.errors).forEach((key, value) => {
                            this.$toast.error(key);
                        });
                    } else {
                        this.$toast.error("Something went wrong");
                    }
                });
        },
        checkForm() {
            this.errors = {};
            if (!this.email) this.errors.email = "Admin Email is required";

            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },
    },

    mounted() {
        this.getSettings();
        this.getAdminDetails();
    },
};
</script>
