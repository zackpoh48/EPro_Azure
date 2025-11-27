<template>
    <div
        class="page-title-box d-flex flex-column flex-md-row justify-content-between align-items-md-center align-items-start"
    >
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <router-link to="/purchase-order"
                        >Purchase Order</router-link
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Submit Delivery Order ({{ poNo }})
                </li>
            </ol>
        </nav>
        <div class="pa-0 d-flex justify-end" v-if="!is_complete">
            <button
                type="button"
                @click="deleteDeliveryOrder()"
                class="btn mx-1 rounded-pill btn-danger"
            >
                Delete
            </button>
            <button
                type="button"
                @click="save('draft')"
                :disabled="
                    invoiceDate != '' && deliveryOrderDate != '' && verifyDate
                "
                class="btn mx-1 rounded-pill btn-primary"
            >
                Save as Draft
            </button>
            <button
                :disabled="
                    invoiceDate != '' && deliveryOrderDate != '' && verifyDate
                "
                type="button"
                class="btn mx-1 rounded-pill btn-success"
                @click="save('complete')"
            >
                Submit
            </button>
            <router-link
                to="/purchase-order"
                type="button"
                class="btn mx-1 rounded-pill btn-outline-info"
            >
                Cancel
            </router-link>
        </div>
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
                                :value="$date(header['date'])"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Buy from Vendor No.</label>
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
                                :value="header.quote_no"
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
                                :value="header.delivery_status"
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
                                :value="header['expected_delivery_date'] !== '-' ? $date(header['expected_delivery_date']) : '-'"
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
                        </td> -->
                    <!-- </tr> -->
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Currency</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="header.currency"
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
                                :value="$formatNumber(header.document_discount_pcnt)"
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
                            <label class="me-2">Amount Incl. SST</label>
                        </td>
                        <td class="pb-1">
                            <input
                                readonly
                                :value="$formatNumber(header.amount_including_vat)"
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
                                :value="header['lastPaymentDate'] !== '-' ? $date(header['lastPaymentDate']) : '-'"
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
                                :value="$formatNumber(header.outstandingAmount)"
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
                            <th class="text-center">PO Line.No.</th>
                            <th class="text-center">Type</th>
                            <th class="text-start">Description</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Unit of Measure Code</th>
                            <th class="text-end">Direct Unit Cost</th>
                            <th class="text-center">Line Disc(%)</th>
                            <th class="text-center">SST(%)</th>
                            <th class="text-start">Remarks</th>
                            <th class="text-end">Line Amount</th>
                            <th class="text-center">Quantity to Delivery</th>
                            <th class="text-center">Quantity Delivered</th>
                            <th class="text-end">Outstanding Quantity</th>
                            <th class="text-center">Progress Billing</th>
                            <th class="text-center">Line Amount (Progress Billing)</th>
                            <th class="text-end">Line Amount (Progress Billed)</th>
                            <th class="text-end">Outstanding Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="tableData.length > 0">
                            <template
                                v-for="(line, index) in tableData"
                                :key="line?.po_line_no + '-' + index"
                            >
                                <tr>
                                    <td class="text-center">{{ line["po_line_no"] }}</td>
                                    <td class="text-center">{{ line["type"] }}</td>
                                    <td class="min-w-50">{{ line["description"] }}</td>
                                    <td class="text-center">{{ line["quantity"] }}</td>
                                    <td class="text-center">{{ line["unit_of_measure_code"]}}</td>
                                    <td class="text-end">{{ $formatNumber(line["direct_unit_cost"]) }}</td>
                                    <td class="text-center">{{ line["line_discount_pcnt"] }}</td>
                                    <td class="text-center">{{ line["sst_pcnt"] }}</td>
                                    <td class="text-start">{{ line["remarks"] }}</td>
                                    <td class="text-end">{{ $formatNumber(line["line_amount"]) }}</td>
                                    <td class="text-center">
                                        <input
                                            type="number"
                                            class="form-control py-1 text-end"
                                            :readonly="is_complete"
                                            min="0"
                                            @input="
                                                validateValue(
                                                    $event,
                                                    'quantity_delivered',
                                                    index,
                                                    'quantity_to_deliver'
                                                )
                                            "
                                            :disabled="
                                                line['deliver_with_amount'] ==
                                                true
                                            "
                                            v-model.number="
                                                line['quantity_to_deliver']
                                            "
                                        />
                                    </td>
                                    <td class="text-center">{{ line["quantity_received"] }}</td>
                                    <td class="text-end">{{ line["outstanding_quantity"] }}</td>
                                    <td class="text-center">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="progressBilling"
                                            v-model="line['progress_billing']"
                                        />
                                    </td>
                                    <td class="text-center">
                                        <input
                                            type="number"
                                            class="form-control py-1 text-end"
                                            min="0"
                                            v-model.number="line['progress_billing_amount']"
                                            :disabled="line['progress_billing'] == false"
                                        />
                                    </td>
                                    <td class="text-end">{{ line["amount_delivered"] }}</td>
                                    <td class="text-end">{{ line["outstanding_amount"] }}</td>
                                </tr>
                                <!-- Sublines -->
                                <tr
                                    v-for="(sdo_line, i) in line[
                                        'submitted_do_lines'
                                    ]"
                                >
                                    <td>
                                        {{
                                            Number(sdo_line["line_no"]) + i + 1
                                        }}
                                    </td>
                                    <td class="min-w-50">
                                        {{ sdo_line["description"] }}
                                    </td>
                                    <!-- <td class="text-center">
                                    {{ line["location"] }}
                                </td> -->
                                    <td class="text-center">
                                        {{ sdo_line["quantity"] }}
                                    </td>
                                    <td class="text-center">
                                        {{
                                            $formatNumber(
                                                sdo_line[
                                                    "unit_cost_including_sst"
                                                ]
                                            )
                                        }}
                                    </td>
                                    <td class="text-center">
                                        {{
                                            $formatNumber(
                                                sdo_line["amount_including_sst"]
                                            )
                                        }}
                                    </td>
                                    <td class="text-center">
                                        {{ sdo_line["quantity_to_deliver"] }}
                                    </td>
                                    <td class="text-center">
                                        {{ sdo_line["quantity_delivered"] }}
                                    </td>
                                    <td class="text-center">
                                        {{ Number(sdo_line["outstanding_quantity"]) - Number(sdo_line["quantity_to_deliver"]) }}
                                    </td>
                                    <td class="text-center">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            disabled
                                            :checked="
                                                sdo_line[
                                                    'deliver_with_amount'
                                                ] == true
                                            "
                                        />
                                    </td>
                                    <td class="text-center">
                                        {{
                                            $formatNumber(
                                                sdo_line[
                                                    "amount_to_deliver_including_sst"
                                                ]
                                            )
                                        }}
                                    </td>
                                    <td class="text-center">
                                        {{
                                            $formatNumber(
                                                sdo_line["amount_delivered"]
                                            )
                                        }}
                                    </td>
                                    <td class="text-center">
                                        {{
                                            $formatNumber(
                                                sdo_line["outstanding_amount"]
                                            )
                                        }}
                                    </td>
                                </tr>
                                <!-- submitted_do_lines -->
                            </template>
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

    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Submit Deliver Order and Invoice</h4>

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Delivery Order No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                :readonly="is_complete"
                                v-model="deliveryOrderNo"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                                style="width: 95%"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Delivery Order Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                type="date"
                                :readonly="is_complete"
                                v-model="deliveryOrderDate"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                                style="width: 95%"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Attachment-Delivery</label>
                        </td>
                        <td class="pb-1">
                            <div
                                class="form-group mb-1"
                                style="display: inline-flex"
                            >
                                <input
                                    readonly
                                    @click="
                                        !is_complete
                                            ? $getFile(
                                                  'attachmentDelivery',
                                                  $data,
                                                  '',
                                                  true,
                                                  true
                                              )
                                            : ''
                                    "
                                    :title="
                                        typeof attachmentDelivery[0] == 'string'
                                            ? attachmentDelivery?.join(',')
                                            : $getFileName(
                                                  'attachmentDelivery',
                                                  $data
                                              )
                                    "
                                    :value="
                                        typeof attachmentDelivery[0] == 'string'
                                            ? attachmentDelivery?.join(',')
                                            : $getFileName(
                                                  'attachmentDelivery',
                                                  $data
                                              )
                                    "
                                    class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                                />
                                <button
                                    type="button"
                                    :disabled="is_complete"
                                    class="remove-div btn btn-light"
                                    title="Clear all selections"
                                    @click="attachmentDelivery = []"
                                >
                                    &Cross;
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td class="pb-1">
                            <label class="me-2">Invoice</label>
                        </td>
                        <td class="pb-1 align-self-start">
                            <input
                                :disabled="is_complete"
                                v-model="invoice"
                                type="checkbox"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle cw-4 ms-2"
                            />
                        </td>
                    </tr> -->
                    <!-- <template v-if="invoice"> -->
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Invoice No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                :readonly="is_complete"
                                v-model="invoiceNo"
                                class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                                style="width: 95%"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Invoice Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                type="date"
                                :min="deliveryOrderDate"
                                :readonly="is_complete"
                                v-model="invoiceDate"
                                class="py-1 px-2 bg-secondary-subtle ms-2 form-control-plaintext"
                                :class="{
                                    'form-control border border-danger':
                                        verifyDate,
                                }"
                                style="width: 95%"
                            />
                            <div v-if="verifyDate" class="text-danger px-3">
                                Invoice Date can not be greater <br />than
                                delivery order date
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Attachment-Invoice</label>
                        </td>
                        <td class="pb-1">
                            <div
                                class="form-group mb-1 w-100"
                                style="display: inline-flex"
                            >
                                <input
                                    readonly
                                    @click="
                                        !is_complete
                                            ? $getFile(
                                                  'attachmentInvoice',
                                                  $data,
                                                  '',
                                                  true,
                                                  true
                                              )
                                            : ''
                                    "
                                    :title="
                                        typeof attachmentInvoice[0] == 'string'
                                            ? attachmentInvoice?.join(',')
                                            : $getFileName(
                                                  'attachmentInvoice',
                                                  $data
                                              )
                                    "
                                    :value="
                                        typeof attachmentInvoice[0] == 'string'
                                            ? attachmentInvoice?.join(',')
                                            : $getFileName(
                                                  'attachmentInvoice',
                                                  $data
                                              )
                                    "
                                    class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2"
                                />
                                <button
                                    type="button"
                                    :disabled="is_complete"
                                    class="remove-div btn btn-light"
                                    title="Clear all selections"
                                    @click="attachmentInvoice = []"
                                >
                                    &Cross;
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- </template> -->
                </table>
            </div>
        </div>

        <div class="card-footer text-end" v-if="!is_complete">
            <button
                type="button"
                @click="deleteDeliveryOrder()"
                class="btn mx-1 rounded-pill btn-danger"
            >
                Delete
            </button>
            <button
                type="button"
                :disabled="
                    invoiceDate != '' && deliveryOrderDate != '' && verifyDate
                "
                @click="save('draft')"
                class="btn mx-1 rounded-pill btn-primary"
            >
                Save as Draft
            </button>
            <button
                :disabled="
                    invoiceDate != '' && deliveryOrderDate != '' && verifyDate
                "
                type="button"
                class="btn mx-1 rounded-pill btn-success"
                @click="save('complete')"
            >
                Submit
            </button>
            <router-link
                to="/purchase-order"
                type="button"
                class="btn mx-1 rounded-pill btn-outline-info"
            >
                Cancel
            </router-link>
        </div>
    </div>
</template>
<script lang="ts">
import { ref } from "vue";
import apiService from "../commons/apiService";
import moment from "moment";

export default {
    data() {
        return {
            apiService: new apiService(),
            poNo: "",
            is_complete: false,
            header: {
                purchase_order_no : "",
                date : "",
                buy_from_vendor_no : null,
                quote_no : null,
                delivery_status : "",
                expected_delivery_date : "",
                currency : null,
                document_discount_pcnt : null,
                total_excl_vat : null,
                total_vat : null,
                amount_including_vat : null,
                amount_including_SST : null,
                lastPaymentDate : null,
                notes_from_vendor : null,
                outstandingAmount : null,
            },
            deliveryOrderNo: "",
            deliveryOrderDate: "",
            invoice: false,
            invoiceNo: "",
            invoiceDate: "",
            attachmentDelivery: [],
            attachmentInvoice: [],
            tableData: ref([]),
            error: {},
        };
    },
    mounted() {
        this.poNo = this.$route.params.doc_no;
        this.getLines();
    },
    methods: {
        getLines() {
            this.$loadingStart();
            this.apiService
                .Get(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/delivery-orders/${this.poNo}`
                )
                .then((res) => {
                    this.$loadingStop();
                    console.log(res);
                    if (res.success) {
                        this.header["purchase_order_no"] = res.data?.purchase_order_no;
                        this.header["date"] = res.data?.document_date;
                        this.header["buy_from_vendor_no"] = res.data?.buy_from_vendor_no;
                        this.header["quote_no"] = res.data?.vendor_quote_no;
                        this.header["delivery_status"] =
                            res.data?.receipt_status;
                        this.header["expected_delivery_date"] =
                            res.data?.expected_receipt_date;
                        this.header["currency"] = res.data?.currency_code;
                        // this.header['location_name'] = res.data?.location;
                        this.header["document_discount_pcnt"] = res.data?.document_discount_pcnt;
                        this.header["total_excl_vat"] = res.data?.total_excl_vat;
                        this.header["total_vat"] = res.data?.total_vat;
                        this.header["amount_including_vat"] = Number(res.data?.total_incl_vat);
                        this.header["amount_including_SST"] = Number(
                                res.data?.total_incl_vat
                        );
                        this.header["lastPaymentDate"] =
                            res.data?.last_payment_date;
                        this.header["notes_from_vendor"] = res.data?.notes_from_vendor;
                        this.header["outstandingAmount"] = Number(
                            res.data?.outstanding_balance
                        );

                        this.deliveryOrderNo =
                            res.data?.delivery_order_no ?? "";
                        this.deliveryOrderDate =
                            res.data?.delivery_order_date ?? "";
                        this.invoiceNo = res.data?.invoice_no ?? "";
                        this.invoiceDate = res.data?.invoice_date ?? "";
                        // if (res.data.hasOwnProperty("is_complete")) {
                        //     this.is_complete = res?.data?.is_complete == 1;
                        // } else {
                        //     this.is_complete = false;
                        // }
                        if (res.data?.delivery_attachments)
                            this.attachmentDelivery =
                                res.data?.delivery_attachments
                                    .split(";")
                                    .slice(0, -1)
                                    .map((ele) => {
                                        return (
                                            ele.split("/").splice(-1, 1)[0] ??
                                            false
                                        );
                                    });
                        else this.attachmentDelivery = [];
                        if (res.data?.invoice_attachments)
                            this.attachmentInvoice =
                                res.data?.invoice_attachments
                                    ?.split(";")
                                    .slice(0, -1)
                                    .map((ele) => {
                                        return (
                                            ele?.split("/").splice(-1, 1)[0] ??
                                            false
                                        );
                                    });
                        else this.attachmentInvoice = [];
                        this.tableData = res?.data?.delivery_order_lines ?? [];
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                })
                .finally(() => this.$loadingStop());
        },
        deleteDeliveryOrder() {
            this.$loadingStart();
            this.apiService
                .Delete(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/delivery-orders/${this.poNo}`
                )
                .then((res) => {
                    this.$loadingStop();
                    if (res.success) {
                        this.$toast.success(
                            res.message ?? "Something went wrong"
                        );
                        this.getLines();
                        // this.$router.push("/purchase-order");
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                })
                .finally(() => this.$loadingStop());
        },
        validateValue(currentValue, maxValue, index, key) {
            if (
                this.tableData[index]["quantity"] -
                    this.tableData[index][maxValue] <
                currentValue.target.value
            ) {
                this.tableData[index][key] =
                    this.tableData[index]["quantity"] -
                    this.tableData[index][maxValue];
            }
        },
        validateForm() {
            let valid = true;
            if (!this.deliveryOrderNo.trim()) {
                this.$toast.error("Delivery Order No Required");
                valid = false;
            } else if (this.attachmentDelivery.length < 1) {
                this.$toast.error("Delivery Attachment Required");
                valid = false;
            } else if (this.invoice && !this.invoiceNo.trim()) {
                this.$toast.error("Invoice No Required");
                valid = false;
            } else if (this.invoice && this.attachmentInvoice.length < 1) {
                this.$toast.error("Invoice Attachment Required");
                valid = false;
            }

            this.tableData.forEach((line, index) => {
                if (line.progress_billing) {
                    if (
                        line.progress_billing_amount === null ||
                        line.progress_billing_amount === "" ||
                        Number(line.progress_billing_amount) <= 0
                    ) {
                        this.$toast.error(
                            `Line Amount (Progress Billing) is required for PO line.No. ${line.po_line_no}`
                        );
                        valid = false;
                    }
                }
            });

            return valid;
        },
        save(action) {
            if (action == "complete") if (!this.validateForm()) return;
            let formData = new FormData();
            formData.append("delivery_order_no", this.deliveryOrderNo);
            formData.append(
                "amount_including_vat",
                this.header["amount_including_vat"]
            );
            formData.append("delivery_order_date", this.deliveryOrderDate);
            formData.append("invoice_date", this.invoiceDate);
            formData.append(
                "expected_receipt_date",
                this.header["expected_delivery_date"]
            );
            formData.append("order_date", this.header["date"]);
            formData.append("currency_code", this.header["currency"]);
            formData.append("invoice_no", this.invoiceNo);
            formData.append("is_complete", action == "complete");
            if (this.attachmentInvoice.length > 0) {
                for (let i = 0; i < this.attachmentInvoice.length; i++) {
                    if (typeof this.attachmentInvoice[i] != "string")
                        formData.append(
                            `invoice_attachments[${i}]`,
                            this.attachmentInvoice[i]
                        );
                }
            }
            for (let i = 0; i < this.attachmentDelivery.length; i++) {
                if (typeof this.attachmentDelivery[i] != "string")
                    formData.append(
                        `delivery_attachments[${i}]`,
                        this.attachmentDelivery[i]
                    );
            }
            for (let i = 0; i < this.tableData.length; i++) {
                formData.append(
                    `delivery_order_lines[${i}]${"[description]"}`,
                    this.tableData[i]?.description ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[no]"}`,
                    this.tableData[i]?.no ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[line_no]"}`,
                    this.tableData[i]?.po_line_no ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[type]"}`,
                    this.tableData[i]?.type ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[location_code]"}`,
                    this.tableData[i]?.location_code ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[quantity]"}`,
                    this.tableData[i]?.quantity ?? ""
                );
                // formData.append(`delivery_order_lines[${i}]${'[uom]'}`, this.tableData[i]?.uom ?? '');
                formData.append(
                    `delivery_order_lines[${i}]${"[unit_cost_including_sst]"}`,
                    this.tableData[i]?.direct_unit_cost ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[amount_including_sst]"}`,
                    this.tableData[i]?.line_amount ?? 0
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[quantity_to_deliver]"}`,
                    this.tableData[i]?.quantity_to_deliver ?? 0
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[quantity_delivered]"}`,
                    this.tableData[i]?.quantity_received ?? 0
                );
                // formData.append(`delivery_order_lines[${i}]${'[quantity_to_invoice]'}`, this.tableData[i]?.quantity_to_invoice ?? '0');
                formData.append(
                    `delivery_order_lines[${i}]${"[quantity_invoiced]"}`,
                    this.tableData[i]?.quantity_invoiced ?? 0
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[outstanding_amount]"}`,
                    this.tableData[i]?.outstanding_amount ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[outstanding_quantity]"}`,
                    this.tableData[i]?.outstanding_quantity ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[deliver_with_amount]"}`,
                    this.tableData[i]?.deliver_with_amount ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[amount_to_deliver_including_sst]"}`,
                    this.tableData[i]?.amount_to_deliver_including_sst ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[amount_delivered]"}`,
                    this.tableData[i]?.amount_delivered ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[progress_billing]"}`,
                    this.tableData[i]?.progress_billing ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[progress_billing_amount]"}`,
                    this.tableData[i]?.progress_billing_amount ?? ""
                );
                formData.append(
                    `delivery_order_lines[${i}]${"[unit_of_measure_code]"}`,
                    this.tableData[i]?.unit_of_measure_code ?? ""
                )
            }

            // for (let pair of formData.entries()) {
            //     console.log(pair[0], pair[1]);
            // }

            // return;


            this.$loadingStart();
            this.apiService
                .PostForm(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/delivery-orders/${this.poNo}`,
                    formData
                )
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.message);
                        this.deliveryOrderNo =
                            res.data?.delivery_order_no ?? "";
                        this.deliveryOrderDate =
                            res.data?.delivery_order_date ?? "";
                        this.invoiceNo = res.data?.invoice_no ?? "";
                        this.invoiceDate = res.data?.invoice_date ?? "";
                        // if (res.data.hasOwnProperty("is_complete")) {
                        //     this.is_complete = res?.data?.is_complete == 1;
                        // } else {
                        //     this.is_complete = false;
                        // }
                        if (res.data?.delivery_attachments)
                            this.attachmentDelivery =
                                res.data?.delivery_attachments
                                    .split(";")
                                    .slice(0, -1)
                                    .map((ele) => {
                                        return (
                                            ele.split("/").splice(-1, 1)[0] ??
                                            false
                                        );
                                    });
                        if (res.data?.invoice_attachments)
                            this.attachmentInvoice =
                                res.data?.invoice_attachments
                                    ?.split(";")
                                    .slice(0, -1)
                                    .map((ele) => {
                                        return (
                                            ele?.split("/").splice(-1, 1)[0] ??
                                            false
                                        );
                                    });
                        // this.invoice = res.data?.invoice == 1;
                        // this.tableData = res?.data?.delivery_order_lines ?? [];
                        this.getLines();
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                })
                .finally(() => {
                    this.$loadingStop();
                });
        },
    },
    computed: {
        verifyDate() {
            return (
                this.invoiceDate &&
                this.deliveryOrderDate &&
                moment(this.invoiceDate, "DD-MM-YYYY").isBefore(
                    moment(this.deliveryOrderDate, "DD-MM-YYYY")
                )
            );
        },
    },
};
</script>
