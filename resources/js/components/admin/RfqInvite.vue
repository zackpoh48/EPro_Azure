<template>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form @submit="submitRfqInvite($event)">
                        <div class="row">
                            <div class="col-12">
                                <h3>RFQ Invite</h3>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select RFQ</label>
                                    <select
                                        class="form-select"
                                        v-model="selectedRfq"
                                        v-bind:class="{
                                            'is-invalid': errors.rfq,
                                        }"
                                    >
                                        <option selected disabled value="">
                                            Select RFQ
                                        </option>
                                        <option
                                            v-for="rfq of rfqs"
                                            :value="rfq.rfq_id"
                                        >
                                            {{ rfq.rfq_id }}
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ errors.rfq }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label"
                                        >Select User</label
                                    >
                                    <!-- <select
                                        class="form-select"
                                        multiple
                                        v-model="selectedUsers"
                                        v-bind:class="{
                                            'is-invalid': errors.users,
                                        }"
                                    >
                                        <option
                                            v-for="user of users"
                                            :value="user.id"
                                        >
                                            {{ user.email }}
                                        </option>
                                    </select> -->
                                    <Multiselect
                                        v-model="selectedUsers"
                                        :options="users"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        placeholder="Select users"
                                        label="username"
                                        track-by="id"
                                        :class="{ 'is-invalid': errors.users }"
                                    />
                                    <div class="invalid-feedback">
                                        {{ errors.users }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 text-right">
                                <button
                                    class="btn btn-primary mt-1 mb-1"
                                    type="submit"
                                >
                                    Submit
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
import apiService from "../commons/apiService";
export default {
    components: {},
    data() {
        return {
            apiService: new apiService(),
            selectedRfq: "",
            selectedUsers: [],
            rfqs: [],
            users: [],
            errors: {},
        };
    },

    methods: {
        fetchRfq() {
            this.$loadingStart();
            this.apiService
                .Get("/api/admin-rfq-list")
                .then((res) => {
                    this.rfqs = res.data;
                })
                .catch((err) => {
                    this.$toast.error(err.message);
                })
                .finally(() => {
                    this.$loadingStop();
                    this.$toast.success("RFQ list retreived successfully");
                });
        },
        fetchRfqUsers() {
            this.apiService
                .Get("/api/admin-rfq-users")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((err) => {
                    this.$toast.error(err.message);
                })
                .finally(() => {
                    this.$loadingStop();
                    this.$toast.success("RFQ User list retreived successfully");
                });
        },
        submitRfqInvite(e) {
            e.preventDefault();
            this.errors = {};
            if (!this.selectedRfq) {
                this.errors.rfq = "Please select RFQ";
                return this.$toast.error("Please Select RFQ");
            }
            if (this.selectedUsers.length === 0) {
                this.errors.users = "Please select atleast one user";
                return this.$toast.error("Please select user");
            }

            const data = {
                rfq_id: this.selectedRfq,
                user_ids: this.selectedUsers.map((el) => el.unique_id),
            };
            this.$loadingStart();

            this.apiService
                .Post("/api/admin-rfq-submit", data)
                .then((res) => {
                    this.$toast.success(res.message);
                })
                .catch((err) => {
                    this.$toast.error(err.message);
                })
                .finally(() => {
                    this.$loadingStop();
                });
        },
    },

    mounted() {
        this.fetchRfq();
        this.fetchRfqUsers();
    },
};
</script>
