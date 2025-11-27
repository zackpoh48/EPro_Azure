<template>
    <div class="page-wrapper mt-4">
        <loader v-if="loading"></loader>
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
                                            href="#ongoing"
                                            data-toggle="tab"
                                            aria-expanded="false"
                                            class="nav-link active"
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
                                            href="#completed"
                                            data-toggle="tab"
                                            aria-expanded="false"
                                            class="nav-link"
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
                                                <tbody>
                                                    <td>
                                                        {{ lists.rfq_id }}
                                                    </td>
                                                    <td>In Progress</td>
                                                    <td>
                                                        {{
                                                            lists.date_of_expiry
                                                                | formatDate
                                                        }}
                                                        <br />
                                                        <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                    </td>
                                                    <td>
                                                        {{
                                                            lists.updated_at
                                                                | formatDate
                                                        }}
                                                        <br />
                                                        <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                    </td>
                                                    <td>
                                                        <!-- <router-link
                                                            :to="{
                                                                name: 'Tender Details',
                                                                params: {
                                                                    rfq_id: lists.rfq_id,
                                                                },
                                                            }"
                                                            class="btn btn-primary"
                                                        >
                                                            {{
                                                                status ===
                                                                "edit"
                                                                    ? "Edit draft"
                                                                    : "New submission"
                                                            }}</router-link
                                                        > -->

                                                        Test
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
                                                                lists.date_of_expiry
                                                                    | formatDate
                                                            }}
                                                            <br />
                                                            <!-- <small
                                                                >1:15 AM</small
                                                            > -->
                                                        </td>
                                                        <td>
                                                            {{
                                                                tender.updated_at
                                                                    | formatDate
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
import Loader from "../common/Loader.vue";

export default {
    components: { Loader },
    data() {
        return {
            lists: [],
            submissions: [],
            loading: false,
            status: "edit",
        };
    },

    methods: {
        getRfqList() {
            this.loading = true;
            axios
                .get("/api/rfq-list", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                })
                .then((res) => res.data)
                .then((res) => {
                    this.lists = res.data;
                    this.submissions = this.lists.submissions.filter(
                        (s) => s.status === 1
                    );
                    this.checkStatus();
                    $.toast({
                        heading: res.status,
                        text: res.message,
                        icon: "success",
                    });
                })
                .catch((error) => {
                    error = error.response.data;
                    $.toast({
                        heading: error.status,
                        text: error.message,
                        icon: "error",
                    });
                })
                .finally(() => (this.loading = false));
        },

        checkStatus() {
            let data = this.lists.submissions.filter((s) => s.status === 0);
            if (data.length === 0) this.status = "new";
        },
    },

    mounted() {
        this.getRfqList();
    },
};
</script>
