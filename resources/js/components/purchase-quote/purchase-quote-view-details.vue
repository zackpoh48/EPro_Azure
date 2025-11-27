<template>
    <div class="page-title-box">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <!-- <router-link to="/purchase-quote"
                        >Purchase Quote</router-link
                    > -->
                    <a
                        class="router-link-active router-link-exact-active cursor-pointer"
                        @click="$emit('back')"
                        >Purchase Quote</a
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    View Details ({{ line.no }})
                </li>
            </ol>
        </nav>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Quote</h4>

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Purchase Quote No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="
                                    header.purchase_quote_no
                                        ? header.purchase_quote_no
                                        : ''
                                "
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
                                :value="
                                    header['document_date'] ? $date(header['document_date']) : ''
                                "
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
                                :value="
                                    header.vendor_no ? header.vendor_no : ''
                                "
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Vendor Quote No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="
                                    header.vendor_order_no ? header.vendor_order_no : ''
                                "
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Quotation Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="
                                    header['order_date']
                                        ? $date(header['order_date'])
                                        : ''
                                "
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">RFQ No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="
                                    header.rfq_no ? header.rfq_no : ''
                                "
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
                                :value="header.currency_code ? header.currency_code : ''"
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
                                :value="
                                    header.additional_disc ? header.additional_disc : ''
                                "
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
                                :value="
                                    header.total_amt_exc_sst
                                        ? $formatNumber(
                                              header.total_amt_exc_sst
                                          )
                                        : ''
                                "
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
                                :value="
                                    header.total_sst
                                        ? $formatNumber(
                                              header.total_sst
                                          )
                                        : ''
                                "
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
                                :value="
                                    header.total_amt_inc_sst
                                        ? $formatNumber(
                                              header.total_amt_inc_sst
                                          )
                                        : ''
                                "
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
                                :value="
                                    header.remarks ? header.remarks : ''
                                "
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Attach File</label>
                        </td>
                        <td class="pb-1">
                            <!-- <input
                                readonly
                                :value="
                                    header.attach_files ? header.attach_files : ''
                                "
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            /> -->
                            <a target="_blank" :href="header.attach_files" class="router-link-active router-link-exact-active d-flex py-1 px-2 bg-secondary-subtle ms-2">View File</a>
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
                            <th>Type</th>
                            <th>Description</th>
                            <!-- <th>Location Name</th> -->
                            <th>Quantity</th>
                            <!-- <th>UOM</th> -->
                            <th>Unit of Measure</th>
                            <th>Direct Unit Cost</th>
                            <th>Amount</th>
                            <th>Disc(%)</th>
                            <th>SST(%)</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="tableData.length > 0">
                            <tr v-for="(line, index) in tableData" :key="index">
                                <td>{{ line["LineNo"] }}</td>
                                <td class="min-w-50">
                                    {{ line["type"] }}
                                </td>
                                <td class="min-w-50">
                                    {{ line["description"] }}
                                </td>
                                <!-- <td class="text-center">
                                    {{ line["location"] }}
                                </td> -->
                                <td class="text-center">
                                    {{ line["quantity"] }}
                                </td>
                                <!-- <td class="text-center">{{ line["uom"] }}</td> -->
                                <td class="text-center">
                                    {{ line["unitOfMeasureCode"] }}
                                </td>
                                <td class="text-end">
                                    {{ $formatNumber(line["directUnitCost"]) }}
                                </td>
                                <td class="text-end">
                                    {{ $formatNumber(line["lineAmount"]) }}
                                </td>
                                <td class="text-center">{{ line["lineDiscountPcnt"] }}</td>
                                <td class="text-center">{{ line["sstPcnt"] }}</td>
                                <td class="text-center">{{ line["remarksByVendor"] }}</td>
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
    props: {
        line: { type: Object, required: true },
    },
    data() {
        return {
            apiService: new apiService(),
            poNo: "",
            header: {
                purchase_quote_no: this.line.no,
                document_date: this.line.documentDate,
                vendor_no: this.line.buyfromVendorNo,
                vendor_order_no: this.line.vendorOrderNo,
                order_date: this.line.orderDate,
                rfq_no: this.line.rfqNo,
                currency_code: this.line.currencyCode,
                additional_disc: this.line.documentDiscountPcnt,
                total_amt_exc_sst: this.line.amountExcludingVat,
                total_sst: this.line.totalSst,
                total_amt_inc_sst: this.line.amountIncludingVat,
                remarks: this.line.supplierRemarks,
                attach_files: this.line.fileAttachments
            },
            tableData: this.line.purchaseQuoteLines,
            vendor_no: localStorage.getItem("vendor_no"),
        };
    },

    created() {
        // console.log("Got line from state:", this.line);
        // this.poNo = this.$route.params.doc_no;
        // this.$loadingStart();
        // this.apiService
        //     .Get(
        //         `/api/users/companies/${localStorage.getItem(
        //             "id"
        //         )}/purchase-quotes/${this.poNo}/${this.vendor_no}`
        //     )
        //     .then((res) => {
        //         this.$loadingStop();
        //         if (res.success) {
        //             this.header["purchase_quote_no"] = res.data?.no;
        //             this.header["date"] = res.data?.order_date;
        //             this.header["document_date"] = res.data?.document_date;
        //             this.header["vendor_no"] = res.data?.buy_from_vendor_no;
        //             this.header["currency"] = res.data?.currency_code;
        //             this.header["amount_including_SST"] =
        //                 res.data?.amount_including_vat;
        //             this.tableData = res.data?.purchase_quote_lines;
        //         } else if (!res.message.includes("Invalid scope")) {
        //             this.$toast.error(res.message ?? "Something went wrong");
        //         }
        //     });
    },
};
</script>
