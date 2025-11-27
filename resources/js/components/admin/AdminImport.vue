<template>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <h3>Import</h3>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select</label>
                                    <select
                                        class="form-select"
                                        @change="setOption"
                                        v-bind:class="{
                                            'is-invalid': errors.option,
                                        }"
                                    >
                                        <option value="">Select</option>
                                        <option value="1">
                                            Create RFQ Applications
                                        </option>
                                        <option value="2">
                                            Update RFQ Applications
                                        </option>
                                        <option value="3">
                                            New Vendor Invitation
                                        </option>
                                        <option value="4">
                                            Update Password
                                        </option>
                                        <option value="5">
                                            Deactivate vendor from specific RFQ
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ errors.option }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">CSV File</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="customFile"
                                        @change="customFileChange"
                                        ref="import_file"
                                        v-on:change="handleFileUpload"
                                    />
                                    <div class="custom-file-label"></div>
                                    <div class="invalid-feedback">
                                        Error Message
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>
                                    Please download the template
                                    <a
                                        :href="'/storage/' + template"
                                        target="_blank"
                                        >here</a
                                    >
                                </p>
                            </div>
                            <div class="col-12 col-sm-6 text-right">
                                <button
                                    class="btn btn-primary mt-1 mb-1"
                                    type="button"
                                    @click="importData"
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 text-left">
                                <button
                                    class="btn btn-primary"
                                    type="button"
                                    @click="runCron"
                                >
                                    Re-run CRON
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
import Errors from "../commons/Errors";
export default {
    components: {},
    data() {
        return {
            loading: false,
            form: {
                option: "",
                file: "",
            },
            template: "",
            files: [
                "",
                "rfq_create_update",
                "rfq_create_update",
                "vendor_invitation",
                "update_password",
                "vendor_deactivate",
            ],
            errors: {},
        };
    },

    methods: {
        customFileChange(event) {
            var fileName = event.target.value.slice(12);
            event.target.nextElementSibling.innerText = fileName;
        },
        setOption(e) {
            this.form.option = e.target.value;
            this.template = this.files[e.target.value] + ".csv";
        },

        handleFileUpload() {
            this.form.file = this.$refs.import_file.files[0];
        },

        importData() {
            let formData = new FormData();
            for (var key in this.form) formData.append(key, this.form[key]);

            if (this.checkForm()) {
                this.loading = true;
                axios
                    .post("/api/import", formData, {
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
                        console.log(error);
                        error = error.response.data;
                        this.$toast.error(error.message);
                    })
                    .finally(() => (this.loading = false));
            }
        },
        checkForm() {
            this.errors = {};
            let errorMessages = Errors.adminImport;
            Object.keys(errorMessages).forEach((data) => {
                console.log(this.form[data]);
                console.log(!this.form[data]);
                if (!this.form[data]) this.errors[data] = errorMessages[data];
            });
            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },

        runCron() {
            this.loading = true;
            axios
                .post("/api/cron", this.formData, {
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
    },

    mounted() {},
};
</script>
