<template>
    <div class="page-title-box">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">
                    Purchase Credit Memo
                </li>
            </ol>
        </nav>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Credit Memo</h4>
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
            </div>
            <div class="width-100 overflow-auto">
                <table
                    id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100"
                >
                    <thead class="table-light">
                        <tr>
                            <th>Credit Note No</th>
                            <th>Date</th>
                            <th>Currency</th>
                            <th class="text-right">Amount Including SST</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="filteredData.length > 0">
                            <tr
                                v-for="(line, index) in filteredData"
                                :key="line.Vendor_Cr_Memo_No + '-' + index"
                            >
                                <td>{{ line["Vendor_Cr_Memo_No"] }}</td>
                                <td>{{ $date(line["Document_Date"]) }}</td>
                                <td>{{ line["Currency_Code"] }}</td>
                                <td class="text-right">
                                    {{ line["Amount_Including_VAT"] }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <router-link
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            :to="{
                                                name: 'Purchase Credit Memo Details',
                                                query: {
                                                    doc_no: line.Vendor_Cr_Memo_No,
                                                },
                                            }"
                                        >
                                            View
                                        </router-link>
                                        <router-link
                                            type="button"
                                            class="btn btn-primary btn-sm text-nowrap mx-2"
                                            :to="{
                                                name: 'Submit Credit Memo',
                                                query: {
                                                    doc_no: line.Vendor_Cr_Memo_No,
                                                },
                                            }"
                                        >
                                            New
                                        </router-link>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <template v-if="filteredData.length == 0 && !$loading.value">
                <p class="text-center py-2 mb-0 text-muted">No Record Found</p>
            </template>
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
            searchInput: "",
            tableData: ref([]),
        };
    },
    mounted() {
        this.$loadingStart();
        this.apiService.Get("/api/users/credit-memo").then((res) => {
            this.$loadingStop();
            if (
                res.success &&
                res.data.hasOwnProperty("eProcurement_PCM_List")
            ) {
                this.tableData = Array.isArray(res.data?.eProcurement_PCM_List)
                    ? res.data?.eProcurement_PCM_List
                    : [res.data?.eProcurement_PCM_List];
            } else if (res.success && res.data) {
                this.tableData = [];
            } else if (!res.message.includes("Invalid scope")) {
                this.$toast.error(res.message ?? "Something went wrong");
            }
        });
    },
    computed: {
        filteredData() {
            if (!this.tableData.length) return [];
            if (this.searchInput.trim === "") {
                return this.tableData;
            } else {
                return this.tableData?.filter((line) =>
                    Object.values(line)
                        .toString()
                        .toLowerCase()
                        .includes(this.searchInput.toLowerCase())
                );
            }
        },
    },
};
</script>
