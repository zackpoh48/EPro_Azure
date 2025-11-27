<template>
    <div class="page-title-box">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">
                    Purchase Order(In Progress)
                </li>
            </ol>
        </nav>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Order (in progress)</h4>
            <div
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
                <!-- <div class="item-group d-flex flex-column flex-sm-row align-items-sm-center w-60 gap-1 flex-grow">
                    <div class="text-small text-nowrap">Delivery Status</div>
                    <select class="form-control" v-model="deliveryStatus">
                        <option v-for="ele in deliveryStatusArray" :key="ele.value" :value="ele.value">
                            {{ ele.name }}
                        </option>
                    </select>
                </div> -->
            </div>
            <div class="width-100 overflow-auto">
                <table
                    id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100"
                >
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Purchase Order No.</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Delivery Status</th>
                            <th class="text-center">Expected Delivery Date</th>
                            <th class="text-center">Currency</th>
                            <th class="text-end">Amount Including SST</th>
                            <th class="text-center">Payment Date</th>
                            <th class="text-end">Outstanding Balance</th>
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
                                    <router-link
                                        :to="{
                                            name: 'Purcahse Order (View Details)',
                                            params: {
                                                doc_no: line.no,
                                            },
                                        }"
                                    >
                                        {{ line["no"] }}
                                    </router-link>
                                </td>
                                <td class="text-center">{{ $date(line["orderDate"]) }}</td>
                                <td class="text-center">{{ line["receiptStatus"] }}</td>
                                <td class="text-center">
                                    {{ $date(line["expectedReceiptDate"]) }}
                                </td>
                                <td class="text-center">{{ line["currencyCode"] }}</td>
                                <td class="text-end">
                                    {{ $formatNumber(line["amountIncludingVAT"]) }}
                                </td>
                                <td class="text-center">
                                    {{ line["lastPaymentDate"] }}
                                </td>
                                <td class="text-end">
                                    {{ $formatNumber(line["outstandingBalance"]) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <router-link
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            :to="{
                                                name: 'Purcahse Order (View Details)',
                                                params: {
                                                    doc_no: line.no,
                                                },
                                            }"
                                        >
                                            View Details
                                        </router-link>
                                        <router-link
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            :to="{
                                                name: 'Submit Delivery Order',
                                                params: {
                                                    doc_no: line.no,
                                                },
                                            }"
                                        >
                                            To Deliver
                                        </router-link>
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
        };
    },
    mounted() {
        this.$loadingStart();
        this.loadData();
    },
    methods: {
        loadData() {
            this.apiService
                .Get(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/purchase-orders`
                )
                .then((res) => {
                    this.$loadingStop();
                    if (res.success) {
                        this.tableData = Array.isArray(res.data?.value)
                            ? res.data?.value
                            : [res.data?.value];
                    } else if (res.success && res.data) {
                        this.tableData = [];
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                });
        },
    },
    computed: {
        filteredData() {
            if (!this.tableData.length) return [];
            if (this.searchInput.trim === "") {
                return this.tableData;
            } else {
                return this.tableData?.filter(
                    (line) =>
                        Object.values(line)
                            .toString()
                            .toLowerCase()
                            .includes(this.searchInput.toLowerCase()) //&& (this.deliveryStatus == '' ? true : line.Receipt_Status == this.deliveryStatus)
                );
            }
        },
    },
};
</script>
