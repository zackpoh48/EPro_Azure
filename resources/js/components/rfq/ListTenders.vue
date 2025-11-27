<template>
    <div class="page-wrapper mt-4">
        <div class="row mb-3">
            <!-- <div class="col-12">
                <h3>RFQ Invite</h3>
            </div> -->
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="form-label">Select RFQ</label>
                    <select
                        class="form-select"
                        v-model="selectedRfq"
                        @change="switchRfq()"
                    >
                        <option selected disabled value="">Select RFQ</option>
                        <option
                            v-for="(rfq, index) in userRfqsList"
                            :key="rfq.id"
                            :value="index"
                        >
                            {{ rfq.rfq_id }}
                        </option>
                    </select>
                    <!-- <div class="invalid-feedback">
                        {{ errors.rfq }}
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Tabs -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">My Application</h3>
                        <div class="tab-content">
                            <div
                                class="tab-pane show active"
                                id="bordered-tabs-preview"
                            >
                                <ul class="nav nav-tabs nav-bordered">
                                    <li class="nav-item">
                                        <a
                                            class="nav-link crsr-p"
                                            @click="switchTab('ongoing')"
                                            :class="{
                                                active: activeTab === 'ongoing',
                                            }"
                                        >
                                            <span
                                                >On Going
                                                <span
                                                    class="badge badge-primary-lighten badge-pill"
                                                    >1</span
                                                >
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link crsr-p"
                                            :class="{
                                                active:
                                                    activeTab === 'completed',
                                            }"
                                            @click="switchTab('completed')"
                                        >
                                            <span
                                                >Completed
                                                <span
                                                    class="badge badge-primary-lighten badge-pill"
                                                    >{{
                                                        submissions
                                                            ? submissions.length
                                                            : 0
                                                    }}</span
                                                >
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="ongoing">
                                        <div class="table-responsive">
                                            <table
                                                class="table max-content table-hover table-centered mb-0"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th>RFQ No.</th>
                                                        <th>Proposal Status</th>
                                                        <th>Closing Date</th>
                                                        <th>Last Update</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="lists.id">
                                                    <td>
                                                        {{ lists.rfq_id }}
                                                    </td>
                                                    <td>In Progress</td>
                                                    <td>
                                                        {{
                                                            $filters.formatDate(
                                                                lists.date_of_expiry
                                                            )
                                                        }}
                                                        <br />
                                                        <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                    </td>
                                                    <td>
                                                        {{
                                                            $filters.formatDate(
                                                                lists.updated_at
                                                            )
                                                        }}
                                                        <br />
                                                        <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                    </td>
                                                    <td>
                                                        <router-link
                                                            :to="{
                                                                name: 'User Tender Details',
                                                                params: {
                                                                    rfq_id:
                                                                        lists.rfq_id ||
                                                                        1,
                                                                },
                                                            }"
                                                        >
                                                            <button
                                                                class="btn btn-primary btn-rounded"
                                                            >
                                                                {{
                                                                    status ===
                                                                    "edit"
                                                                        ? "Edit draft"
                                                                        : "New submission"
                                                                }}
                                                            </button>
                                                        </router-link>
                                                    </td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="completed">
                                        <div class="table-responsive">
                                            <table
                                                class="table max-content table-hover table-centered mb-0"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th>RFQ No.</th>
                                                        <th>Proposal Status</th>
                                                        <th>Quotation No.</th>
                                                        <th>Closing Date</th>
                                                        <th>Last Update</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="tender in submissions"
                                                    >
                                                        <td>
                                                            {{ tender.rfq_id }}
                                                        </td>
                                                        <td>Completed</td>
                                                        <td>
                                                            {{
                                                                tender.vendor_quotation_no
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                $filters.formatDate(
                                                                    lists.date_of_expiry
                                                                )
                                                            }}
                                                            <br />
                                                            <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                        </td>
                                                        <td>
                                                            {{
                                                                $filters.formatDate(
                                                                    tender.updated_at
                                                                )
                                                            }}
                                                            <br />
                                                            <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            lists: [],
            submissions: [],
            loading: false,
            status: "edit",
            activeTab: "ongoing",
            userRfqsList: [],
            selectedRfq: "",
        };
    },

    methods: {
        getRfqList() {
            this.$loadingStart();
            axios
                .get("/api/user/rfq-list", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                // .then((res) => res.data)
                .then((res) => {
                    this.userRfqsList = res.data.data;
                    this.$toast.success(res.data.message);
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => this.$loadingStop());
        },

        switchRfq() {
            this.lists = this.userRfqsList[this.selectedRfq];
            this.submissions = this.lists.submissions.filter(
                (s) => s.status === 1
            );
            this.checkStatus();
        },

        checkStatus() {
            this.status = "edit";
            let data = this.lists.submissions.filter((s) => s.status === 0);
            if (data.length === 0) this.status = "new";
        },

        switchTab(tabName) {
            if (tabName === this.activeTab) return;
            document.getElementById(this.activeTab).classList.remove("active");
            document.getElementById(tabName).classList.add("active");
            this.activeTab = tabName;
        },
    },

    mounted() {
        this.getRfqList();
    },
};
</script>

<style scoped>
.clr-unset {
    color: unset;
}
.crsr-p {
    cursor: pointer;
}
</style>
