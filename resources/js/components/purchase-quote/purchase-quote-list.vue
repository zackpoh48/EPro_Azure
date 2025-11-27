<template>
    <div class="page-title-box">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">
                    Purchase Quote
                </li>
            </ol>
        </nav>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Quote</h4>
            <!-- <div
                class="py-3 d-flex flex-column gap-2 flex-sm-row justify-content-sm-between"
            >
                <div class="input-group w-auto">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <unicon name="search" class="muted"></unicon>
                        </span>
                    </div>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Start typing to search"
                        aria-label="Search"
                        v-model="searchInput"
                    />
                </div>
                <router-link
                    type="button"
                    class="btn btn-primary text-nowrap mx-2"
                    :to="{
                        name: 'Submit Quote',
                    }"
                >
                    New Quote
                </router-link>
            </div> -->

            <div class="row mb-3">
                <div class="col-md-5 align-self-end">
                    <div class="input-group w-auto">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <unicon name="search" class="muted"></unicon>
                            </span>
                        </div>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Start typing to search"
                            aria-label="Search"
                            v-model="searchInput"
                        />
                    </div>
                </div>
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Select Status</label>
                        <select class="form-select" v-model="selectedStatus">
                            <option value="">Select Status</option>
                            <option
                                v-for="(status, idx) in statusOptions"
                                :key="status"
                                :value="status"
                            >
                                {{ status }}
                            </option>
                        </select>
                    </div>
                </div> -->
            </div>

            <div class="width-100 overflow-auto">
                <table
                    id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100"
                >
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Purchase Quote No.</th>
                            <th class="text-center">Date</th>
                            <!-- <th>Delivery Status</th> -->
                            <!-- <th>Expected Delivery Date</th> -->
                            <th class="text-center">Document Date</th>
                            <th class="text-center">Currency</th>
                            <th class="text-end">Amount Including SST</th>
                            <!-- <th>Payment Date</th> -->
                            <!-- <th>Outstanding Balance</th> -->
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="filteredData.length > 0">
                            <tr
                                v-for="(line, index) in filteredData"
                                :key="line.purchase_order_no + '-' + index"
                            >
                                <td class="text-center">
                                    <!-- <router-link
                                        :to="{
                                            name: 'View Purchase Quote',
                                            params: { doc_no: line.no },
                                            state: { line }
                                        }"
                                    >
                                            {{ line.no }}
                                    </router-link> -->
                                    <a
                                        class="cursor-pointer router-link-active router-link-exact-active"
                                        @click="$emit('view-details', line)"
                                    >
                                        {{ line["no"] }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $date(line["orderDate"]) }}</td>
                                <!-- <td>{{ line["Receipt_Status"] }}</td> -->
                                <td class="text-center">
                                    {{ $date(line["documentDate"]) }}
                                </td>
                                <td class="text-center">{{ line["currencyCode"] }}</td>
                                <td class="text-end">
                                    {{
                                        $formatNumber(
                                            line["amountIncludingVat"]
                                        )
                                    }}
                                </td>
                                <!-- <td class="text-right">
                                    {{ line["Last_Payment_Date"] }}
                                </td>
                                <td class="text-right">
                                    {{
                                        $formatNumber(
                                            line["Outstanding_Balance"]
                                        )
                                    }}
                                </td> -->
                                <td class="text-center">
                                    <div >
                                        <!-- <router-link
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            :to="{
                                                name: 'View Purchase Quote',
                                                params: {
                                                    doc_no: line.no,
                                                    // vendor_no: vendor_no, 
                                                },
                                                query: {
                                                    purchase_quote_no: line.no,
                                                    date: line.orderDate,
                                                    document_date: line.documentDate,
                                                    vendor_no: line.buyfromVendorNo,
                                                    currency: line.currencyCode,
                                                    amount_including_SST: line.amountIncludingVat,
                                                    purchase_quote_lines: JSON.stringify(line.purchaseQuoteLines),
                                                }
                                            }"
                                        >
                                            View Details
                                        </router-link> -->
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            @click="$emit('view-details', line)"
                                        >
                                            View Details
                                        </button>
                                        <!-- <router-link
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            :to="{
                                                name: 'Submit Quote',
                                                params: {
                                                    doc_no: line.No,
                                                },
                                            }"
                                        >
                                            New Quote
                                        </router-link> -->
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <template v-if="filteredData.length == 0 && !$loading.value">
                    <p class="text-center py-2 mb-0 text-muted">
                        No Record Found
                    </p>
                </template>
            </div>
            <!-- end table-responsive-->
        </div>
        <!-- end card body-->
    </div>
</template>

<script lang="ts">
import { ref } from "vue";
import apiService from "../commons/apiService";
export default {
    data() {
        return {
            apiService: new apiService(),
            // deliveryStatus: "",
            searchInput: "",
            // deliveryStatusArray: [
            //     { name: "All", value: "" },
            //     { name: "Not Delivered", value: "Not_Delivered" },
            //     { name: "Partial Delivery", value: "Partial_Delivery" },
            //     { name: "Completed", value: "Completed" },
            // ],
            tableData: ref([]),
            statusOptions: [
                "Open",
                "Released",
                "Pending Approval",
                "Pending Prepayment",
            ],
            selectedStatus: "",
        };
    },
    mounted() {
        this.loadData();
    },
    watch: {
        selectedStatus(newVal) {
            this.loadData();
        },
    },
    methods: {
        loadData() {
            this.$loadingStart();
            let url = `/api/users/companies/${localStorage.getItem(
                "id"
            )}/${localStorage.getItem("vendor_no")}/purchase-quotes`;

            if (this.selectedStatus !== "") {
                url += `?status=${encodeURIComponent(this.selectedStatus)}`;
            }

            this.apiService.Get(url).then((res) => {
                this.$loadingStop();
                if (res.success) {
                    this.tableData = Array.isArray(res.data?.value)
                        ? res.data?.value
                        : [res.data?.value];
                } else if (res.success && res.data) {
                    this.tableData = [];
                } else if (!res.message?.includes("Invalid scope")) {
                    this.$toast.error(res.message ?? "Something went wrong");
                }
            });
        },
    },
    computed: {
        filteredData() {
            if (!Array.isArray(this.tableData) || !this.tableData.length)
                return [];

            const search = String(this.searchInput || "")
                .trim()
                .toLowerCase();

            if (search === "") {
                return this.tableData;
            } else {
                return this.tableData.filter((line) => {
                    if (!line || typeof line !== "object") return false;

                    return Object.values(line)
                        .join(" ")
                        .toLowerCase()
                        .includes(search);
                });
            }
        },
    },
};
</script>
