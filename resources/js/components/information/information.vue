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
                                    src="/../../assets/images/logo_with_text.png"
                                    alt="logo"
                                    height="110"
                            /></span>
                        </div>

                        <div class="card-body p-4 text-center">
                            <h4>Status : {{ status_message[status].state }}</h4>
                            <p>{{ status_message[status].message }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">
                                Back to
                                <span
                                    @click="goToSignin()"
                                    class="text-muted ms-1 cursor-pointer"
                                    ><b>Sign In</b></span
                                >
                            </p>
                        </div>
                        <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    data() {
        return {
            status: "",
            status_message: {
                6: {
                    state: "Revoked",
                    message:
                        "Your Registration request has been rejected. Check your registered email for further updates or contact at exmaple@example.com.",
                },
                2: {
                    state: "Submitted",
                    message:
                        "Your Registration request has been submitted. Check your registered email for further updates",
                },
            },
        };
    },
    created() {
        this.status = localStorage.getItem("status");
    },
    methods: {
        goToSignin() {
            localStorage.clear();
            this.$router.push("sign-in");
        },
    },
};
</script>
