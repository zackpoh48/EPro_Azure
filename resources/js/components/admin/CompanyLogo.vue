<template>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <h3>Company Logo</h3>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label"
                                        >Company Logo</label
                                    >
                                    <input
                                        type="file"
                                        class="form-control"
                                        ref="company_logo"
                                        v-on:change="
                                            handleFileUpload(
                                                'company_logo',
                                                'company_logo'
                                            )
                                        "
                                    />
                                    <div class="text-danger small mb-2 show">
                                        {{ errors.company_logo }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label"
                                        >Company Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Company Name"
                                        v-model="form.company_name"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label"
                                        >Company Enquiry</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Company Enquiry"
                                        v-model="form.company_enquiry"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label"
                                        >Mail From name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Mail From Name"
                                        v-model="form.mail_from_name"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row float-right">
                            <div class="col-12 col-sm-6 text-right">
                                <button
                                    class="btn btn-primary mt-2"
                                    type="button"
                                    @click="updateLogo"
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
                company_logo: "",
                company_name: "",
                company_enquiry: "",
                mail_from_name: "",
            },
            errors: {},
        };
    },

    methods: {
        handleFileUpload(formField, refField) {
            this.form[formField] = this.$refs[refField].files[0];
        },

        checkFileValidation(param) {
            this.fileValidator(this.$refs[param], param);
        },

        fileValidator(data, param) {
            const input = data.files[0];
            if (input) {
                if (input.size > 5000000)
                    this.errors[param] =
                        "File size must not be larger than 5MB";
                if (
                    input &&
                    !new RegExp("^.*\.(jpg|jpeg|png)$").test(input.name)
                )
                    this.errors[param] = "Invalid file extension specified";
            }
        },

        updateLogo() {
            let formData = new FormData();
            for (var key in this.form) formData.append(key, this.form[key]);
            if (this.checkForm()) {
                this.loading = true;
                axios
                    .post("/api/update-company-logo", formData, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    })
                    .then((res) => res.data)
                    .then((res) => {
                        this.$emit("updateComapnyLogo", res.data);
                        this.$toast.success(res.message);
                        const input = this.$refs.company_logo;
                        input.type = "text";
                        input.type = "file";
                    })
                    .catch((error) => {
                        error = error.response.data;
                        this.$toast.error(error.message);
                    })
                    .finally(() => (this.loading = false));
            }
        },

        checkForm() {
            this.errors = {};
            this.checkFileValidation("company_logo");

            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },
    },
    created() {
        axios
            .get("/api/get-logo")
            .then((res) => res.data)
            .then((res) => {
                this.form = res.data;
            })
            .catch((error) => {
                error = error.response.data;
            });
    },
};
</script>
