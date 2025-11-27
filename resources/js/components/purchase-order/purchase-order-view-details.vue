<template>
    <div class="page-title-box">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <router-link to="/purchase-order"
                        >Purchase Order</router-link
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    View Details ({{ poNo }})
                </li>
            </ol>
        </nav>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Order</h4>

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Purchase Quote No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.purchase_order_no"
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
                                readonly
                                :value="$date(header.document_date)"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Vendor No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.buy_from_vendor_no"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Quote No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.vendor_quote_no"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Delivery Status</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.receipt_status"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Expected Delivery Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="$date(header.expected_receipt_date)"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <!-- <tr>
                        <td class="pb-1">
                            <label class="me-2">Location Name</label>
                        </td>
                        <td class="pb-1">
                            <input readonly :value="header.location_name"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2" />
                        </td>
                    </tr> -->
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Currency</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.currency_code"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Additional Discount(%)</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.document_discount_pcnt"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Total Amount Excl. SST</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="$formatNumber(header.total_excl_vat)"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Total SST</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="$formatNumber(header.total_vat)"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Total Amount Incl. SST</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="$formatNumber(header.total_incl_vat)"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Payment Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.last_payment_date"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Outstanding Balance</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="$formatNumber(header.outstanding_balance)"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Remarks</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.notes_from_vendor"
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
                            <!-- <th>No.</th>
                            <th>Description</th> -->
                            <!-- <th>Location Name</th> -->
                            <!-- <th>Quantity</th> -->
                            <!-- <th>UOM</th> -->
                            <!-- <th>Direct Unit Cost</th>
                            <th>Line Amount</th>
                            <th>Quantity Delivered</th>
                            <th>Quantity Invoiced</th> -->

                            <th class="text-center">PO Line.No.</th>
                            <th class="text-center">Type</th>
                            <th class="text-start">Description</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Unit of Measure Code</th>
                            <th class="text-end">Direct Unit Cost</th>
                            <th class="text-center">Line Disc(%)</th>
                            <th class="text-center">SST(%)</th>
                            <th class="text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="tableData.length > 0">
                            <tr v-for="(line, index) in tableData" :key="index">
                                <td class="text-center">{{ line["po_line_no"] }}</td>
                                <td class="text-center">{{ line["type"] }}</td>
                                <td class="text-start min-w-50">
                                    {{ line["description"] }}
                                </td>
                                <!-- <td class="text-center">
                                    {{ line["location"] }}
                                </td> -->
                                <td class="text-center">
                                    {{ line["quantity"] }}
                                </td>
                                <td class="text-center">{{ line["unit_of_measure_code"] }}</td> 
                                <td class="text-end">{{ line["direct_unit_cost"] }}</td> 
                                <td class="text-center">{{ line["line_discount_pcnt"] }}</td> 
                                <td class="text-center">{{ line["sst_pcnt"] }}</td> 
                                <td class="text-center">{{ line["remarks"] }}</td> 

                                <!-- <td class="text-center">{{ line["uom"] }}</td> -->
                                <!-- <td class="text-center">
                                    {{
                                        $formatNumber(
                                            line["unit_cost_including_sst"]
                                        )
                                    }}
                                </td>
                                <td class="text-center">
                                    {{
                                        $formatNumber(
                                            line["amount_including_sst"]
                                        )
                                    }}
                                </td>
                                <td class="text-center">
                                    {{ line["quantity_delivered"] }}
                                </td>
                                <td class="text-center">
                                    {{ line["quantity_invoiced"] }}
                                </td> -->
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <template v-if="tableData.length == 0 && !$loading.value">
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
            poNo: "",
            header: {},
            tableData: ref([]),
        };
    },

    created() {
        this.poNo = this.$route.params.doc_no;
        this.$loadingStart();
        this.apiService
            .Get(
                `/api/users/companies/${localStorage.getItem(
                    "id"
                )}/purchase-orders/${this.poNo}`
            )
            .then((res) => {
                this.$loadingStop();
                if (res.success) {
                    this.header["purchase_order_no"] = res.data?.purchase_order_no;
                    this.header["document_date"] = res.data?.document_date;
                    this.header["buy_from_vendor_no"] = res.data?.buy_from_vendor_no;
                    this.header["vendor_quote_no"] = res.data?.vendor_quote_no
                    this.header["receipt_status"] = res.data?.receipt_status
                    this.header["expected_receipt_date"] = res.data?.expected_receipt_date
                    this.header["currency_code"] = res.data?.currency_code
                    this.header["document_discount_pcnt"] = res.data?.document_discount_pcnt
                    this.header["total_excl_vat"] = res.data?.total_excl_vat
                    this.header["total_vat"] = res.data?.total_vat
                    this.header["total_incl_vat"] = res.data?.total_incl_vat
                    this.header["last_payment_date"] = res.data?.last_payment_date
                    this.header["outstanding_balance"] = res.data?.outstanding_balance
                    this.header["notes_from_vendor"] = res.data?.notes_from_vendor

                    this.tableData = res.data?.delivery_order_lines;
                } else if (!res.message.includes("Invalid scope")) {
                    this.$toast.error(res.message ?? "Something went wrong");
                }
            });
    },
};
</script>   
