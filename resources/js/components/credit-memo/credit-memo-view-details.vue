<template>
    <div
        class="page-title-box d-flex justify-content-between align-items-center"
    >
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <router-link to="/purchase-credit-memo"
                        >Purchase Credit Memo</router-link
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    View Details ({{ poNo }})
                </li>
            </ol>
        </nav>
        <button type="button" class="btn btn-primary btn-sm px-3">Print</button>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Credit Memo</h4>

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Credit Note No</label>
                        </td>
                        <td class="pb-1">
                            <input
                                :value="header.credit_note_no"
                                readonly
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                :value="header.date"
                                readonly
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Currency</label>
                        </td>
                        <td class="pb-1">
                            <input
                                :value="header.currency"
                                readonly
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Amount Including SST</label>
                        </td>
                        <td class="pb-1">
                            <input
                                :value="header.amount_including_SST"
                                readonly
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="width-100 overflow-auto">
                <table
                    id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100"
                >
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Description</th>
                            <th>Location Name</th>
                            <th>Quantity</th>
                            <th>UOM</th>
                            <th>Unit Cost Incl. SST</th>
                            <th>Amount Incl. SST</th>
                            <th>Delivery Order No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(line, index) in tableData" :key="index">
                            <td>{{ line["no"] }}</td>
                            <td class="min-w-50">{{ line["description"] }}</td>
                            <td class="text-center">
                                {{ line["loc_name"] }}
                            </td>
                            <td class="text-center">{{ line["quantity"] }}</td>
                            <td class="text-center">
                                {{ line["unit_of_measure"] }}
                            </td>
                            <td class="text-center">
                                {{ line["direct_unit_cost"] }}
                            </td>
                            <td class="text-center">
                                {{ line["line_amount"] }}
                            </td>
                            <td class="text-center">
                                {{ line["delivery_order_no"] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            poNo: "",
            tableData: ref([]),
            header: {
                credit_note_no: "",
                date: "",
                currency: "",
                location_name: "",
                amount_including_SST: 0,
            },
        };
    },
    created() {
        this.poNo = this.$route.query.doc_no;
        this.$loadingStart();
        this.apiService
            .Get("/api/users/credit-memo?credit_memo_no=" + this.poNo)
            .then((res) => {
                this.$loadingStop();
                if (res.success) {
                    this.header["credit_note_no"] = res.data?.vendor_cr_memo_no;
                    this.header["date"] = res.data?.document_date;
                    this.header["currency"] = res.data?.currency_code;
                    this.header["amount_including_SST"] =
                        res.data?.amount_including_VAT;
                    this.tableData = res.data?.credit_memo_lines;
                } else if (!res.message.includes("Invalid scope")) {
                    this.$toast.error(res.message ?? "Something went wrong");
                }
            });
    },
};
</script>
