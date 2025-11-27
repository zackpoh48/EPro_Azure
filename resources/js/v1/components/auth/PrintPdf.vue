<template>
    <div>
        <button class="btn btn-success btn-rounded mr-2" type="button" @click="backToRegister">
            Back
        </button>
        <div class="row px-2">
            <div class="col-12 text-center mt-3 mb-3">
                <button class="btn btn-success btn-rounded mr-2" type="button" @click="printPdf">
                    Print Pdf
                </button>
                <label>Upload Pdf</label>
                <input type="file" :disabled='isDisabled' class="form-control" id="file" ref="file"
                    v-on:change="uploadPdf" />
                <button class="btn btn-success btn-rounded" type="button" :disabled='isDisabled'
                    @click="finalSubmission">
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                is_disable: false,
                file: "",
            }
        },
        methods: {
            printPdf() {
                this.is_disable = true;
                let url = "/api/print-pdf/" + this.$route.params.unique_id;
                window.open(url, "_blank");
            },
            uploadPdf() {
                this.file = this.$refs.file.files[0];

                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('unique_id', this.$route.params.unique_id);

                axios.post('/api/upload-pdf', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (res) {

                    })
                    .catch(error => {
                        error = error.response.data;
                    })
            },
            backToRegister() {
                let formData = new FormData();
                formData.append('unique_id', this.$route.params.unique_id);
                axios
                    .post("/api/back-to-register", formData)
                    .then(res => res.data)
                    .then(res => {
                        this.$router.push({
                            path: "/register/" + this.$route.params.unique_id
                        })
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

            },

            finalSubmission() {
                let formData = new FormData();
                formData.append('unique_id', this.$route.params.unique_id);

                axios
                    .post("/api/final-submit", formData)
                    .then(res => res.data)
                    .then(res => {
                        this.$router.push({
                            path: "/login"
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

            },
        },
        computed: {
            isDisabled: function () {
                return !this.is_disable;
            }
        }
    }

</script>
