<template>
    <div
        class="page-title-box d-flex flex-column flex-md-row justify-content-between align-items-md-center align-items-start"
    >
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <router-link to="/purchase-quote"
                        >Purchase Quote</router-link
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create New Quote
                </li>
            </ol>
        </nav>
        <div class="pa-0 d-flex justify-end" v-if="!is_complete">
            <button
                type="button"
                @click="deletePurchaseQuote()"
                class="btn mx-1 rounded-pill btn-danger"
            >
                Delete
            </button>
            <button
                type="button"
                @click="save('draft')"
                class="btn mx-1 rounded-pill btn-primary"
            >
                Save as Draft
            </button>
            <button
                type="button"
                class="btn mx-1 rounded-pill btn-success"
                @click="save('complete')"
            >
                Submit
            </button>
            <router-link
                to="/purchase-quote"
                type="button"
                class="btn mx-1 rounded-pill btn-outline-info"
            >
                Cancel
            </router-link>
        </div>
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
                                v-model="header.purchase_quote_no"
                                class="form-control-plaintext py-1 px-2 border ms-2"
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
                            <label class="me-2">Vendor Quote No.</label>
                        </td>
                        <td class="pb-1">
                            <input
                                v-model="header.vendor_no"
                                class="form-control-plaintext py-1 px-2 border ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Quotation Date</label>
                        </td>
                        <td class="pb-1">
                            <input
                                type="date"
                                v-model="header['document_date']"
                                class="form-control-plaintext py-1 px-2 border ms-2"
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
                                v-model="header.currency"
                                class="form-control-plaintext py-1 px-2 border ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Total Amount Incl. SST</label>
                        </td>
                        <td class="pb-1">
                            <input
                                v-model="header.amount_including_SST"
                                class="form-control-plaintext py-1 px-2 border ms-2"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Reference</label>
                        </td>
                        <td class="pb-1">
                            <input
                                v-model="header.reference"
                                class="form-control-plaintext py-1 px-2 border ms-2"
                            />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <button
                type="button"
                @click="addNewLine()"
                class="btn mb-1 btn-primary"
            >
                New Line
            </button>
            <div class="width-100 overflow-auto">
                <table
                    id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100"
                >
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit of Measure</th>
                            <th>Unit Cost Incl. SST</th>
                            <th>Amount Incl.SST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="tableData.length > 0">
                            <tr v-for="(line, index) in tableData" :key="index">
                                <td>{{ line["line_no"] }}</td>
                                <!-- <td class="min-w-50">
                                    {{ line["type"] }}
                                </td> -->
                                <td class="min-w-50">
                                    <input
                                        class="form-control"
                                        v-model="line['description']"
                                    />
                                    <!-- {{ line["description"] }} -->
                                </td>
                                <!-- <td class="text-center">
                                    {{ line["location"] }}
                                </td> -->
                                <td class="text-center">
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="line['quantity']"
                                    />
                                    <!-- {{ line["quantity"] }} -->
                                </td>
                                <!-- <td class="text-center">{{ line["uom"] }}</td> -->
                                <td class="text-center">
                                    <input
                                        class="form-control"
                                        v-model="line['unit_of_measure_code']"
                                    />
                                </td>
                                <td class="text-center">
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="line['direct_unit_cost']"
                                    />
                                    <!-- {{
                                        $formatNumber(line["direct_unit_cost"])
                                    }} -->
                                </td>
                                <td class="text-center">
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="line['line_amount']"
                                    />
                                    <!-- {{ $formatNumber(line["line_amount"]) }} -->
                                </td>
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

    <div class="card w-100">
        <div class="card-body">
            <!-- <h4 class="card-title">Submit Deliver Order and Invoice</h4> -->

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2"
                                >Support Document-Attachment</label
                            >
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
                                                  'supportAttachment',
                                                  $data,
                                                  '',
                                                  true,
                                                  true
                                              )
                                            : ''
                                    "
                                    :title="
                                        typeof supportAttachment[0] == 'string'
                                            ? supportAttachment?.join(',')
                                            : $getFileName(
                                                  'supportAttachment',
                                                  $data
                                              )
                                    "
                                    :value="
                                        typeof supportAttachment[0] == 'string'
                                            ? supportAttachment?.join(',')
                                            : $getFileName(
                                                  'supportAttachment',
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
                                    @click="supportAttachment = []"
                                >
                                    &Cross;
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card-footer text-end" v-if="!is_complete">
            <button
                type="button"
                @click="deletePurchaseQuote()"
                class="btn mx-1 rounded-pill btn-danger"
            >
                Delete
            </button>
            <button
                type="button"
                @click="save('draft')"
                class="btn mx-1 rounded-pill btn-primary"
            >
                Save as Draft
            </button>
            <button
                type="button"
                class="btn mx-1 rounded-pill btn-success"
                @click="save('complete')"
            >
                Submit
            </button>
            <router-link
                to="/purchase-quote"
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
            is_complete: false,
            header: {
                purchase_quote_no: "",
                vendor_no: "",
                date: "",
                document_date: "",
                currency: "",
                amount_including_SST: 0,
                reference: "",
            },
            supportAttachment: [],
            tableData: ref([]),
            error: {},
        };
    },
    mounted() {
        this.getLines();
    },
    methods: {
        getLines() {
            this.$loadingStart();
            this.apiService
                .Get(
                    `/api/users/companies/${localStorage.getItem("id")}/quotes`
                )
                .then((res) => {
                    this.$loadingStop();
                    if (res.success) {
                        this.header["purchase_quote_no"] = res.data?.no;
                        this.header["date"] = res.data?.order_date;
                        this.header["document_date"] =
                            res.data?.document_date ?? "";
                        this.header["vendor_no"] = res.data?.buy_from_vendor_no;
                        this.header["currency"] = res.data?.currency_code;
                        this.header["amount_including_SST"] =
                            res.data?.amount_including_vat;
                        this.header["reference"] = res.data?.reference;

                        if (res.data?.support_attachments)
                            this.supportAttachment =
                                res.data?.support_attachments
                                    .split(";")
                                    .slice(0, -1)
                                    .map((ele) => {
                                        return (
                                            ele.split("/").splice(-1, 1)[0] ??
                                            false
                                        );
                                    });
                        else this.supportAttachment = [];
                        if (res?.data?.purchase_quote_lines.length) {
                            this.tableData = res?.data?.purchase_quote_lines;
                        } else {
                            this.tableData = [
                                {
                                    line_no: 10000,
                                },
                            ];
                        }
                    } else if (!res.message.includes("Invalid scope")) {
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                })
                .finally(() => this.$loadingStop());
        },
        addNewLine() {
            let lastLineNo = 0;
            if (this.tableData.length) {
                lastLineNo = this.tableData[this.tableData.length - 1]?.line_no;
            }
            this.tableData.push({
                line_no: lastLineNo + 10000,
            });
        },
        deletePurchaseQuote() {
            this.$loadingStart();
            this.apiService
                .Delete(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/purchase-quotes`
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
        validateForm() {
            let valid = true;
            if (!this.header["purchase_quote_no"]?.trim()) {
                this.$toast.error("Purchase Quote No Required");
                valid = false;
            } else if (!this.header["amount_including_SST"]) {
                this.$toast.error("Total Amount Incl. SST Required");
                valid = false;
            } else if (!this.header["vendor_no"]?.trim()) {
                this.$toast.error("Vendor Quote No Required");
                valid = false;
            } else if (this.supportAttachment.length < 1) {
                this.$toast.error("Support Attachment Required");
                valid = false;
            } else if (!this.header["document_date"]) {
                this.$toast.error("Quotation Date Required");
                valid = false;
            } else if (!this.header["currency"]?.trim()) {
                this.$toast.error("Currency Required");
                valid = false;
            } else if (this.tableData.length) {
                for (let i = 0; i < this.tableData.length; i++) {
                    if (!this.tableData[i]?.description?.trim()) {
                        this.$toast.error(
                            "Description Required at Line No. " +
                                this.tableData[i].line_no
                        );
                        valid = false;
                        break;
                    }
                    if (!this.tableData[i]?.quantity) {
                        this.$toast.error(
                            "Quantity Required at Line No. " +
                                this.tableData[i].line_no
                        );
                        valid = false;
                        break;
                    }
                    if (!this.tableData[i]?.unit_of_measure_code?.trim()) {
                        this.$toast.error(
                            "Unit of Measure Required at Line No. " +
                                this.tableData[i].line_no
                        );
                        valid = false;
                        break;
                    }
                    if (!this.tableData[i]?.direct_unit_cost) {
                        this.$toast.error(
                            "Unit Cost Incl. SST Required at Line No. " +
                                this.tableData[i].line_no
                        );
                        valid = false;
                        break;
                    }
                    if (!this.tableData[i]?.line_amount) {
                        this.$toast.error(
                            "Amount Incl. SST Required at Line No. " +
                                this.tableData[i].line_no
                        );
                        valid = false;
                        break;
                    }
                }
            }

            return valid;
        },
        save(action) {
            if (action == "complete") if (!this.validateForm()) return;
            let formData = new FormData();
            let lastLineNo = 0;
            if (this.tableData.length) {
                lastLineNo = this.tableData[this.tableData.length - 1]?.line_no;
            }
            formData.append(
                "purchase_quote_no",
                this.header["purchase_quote_no"]
            );
            formData.append(
                "amount_including_sst",
                this.header["amount_including_SST"]
            );
            formData.append("date", this.header["date"]);
            formData.append("quotation_date", this.header["document_date"]);
            formData.append("currency", this.header["currency"]);
            formData.append("reference", this.header["reference"]);
            formData.append("vendor_quote_no", this.header["vendor_no"]);
            formData.append("last_line_no", lastLineNo.toString());
            formData.append("is_complete", action == "complete");
            if (this.supportAttachment.length > 0) {
                for (let i = 0; i < this.supportAttachment.length; i++) {
                    if (typeof this.supportAttachment[i] != "string")
                        formData.append(
                            `support_attachments[${i}]`,
                            this.supportAttachment[i]
                        );
                }
            }

            for (let i = 0; i < this.tableData.length; i++) {
                formData.append(
                    `purchase_quote_lines[${i}]${"[description]"}`,
                    this.tableData[i]?.description ?? ""
                );
                formData.append(
                    `purchase_quote_lines[${i}]${"[line_no]"}`,
                    this.tableData[i]?.line_no ?? ""
                );
                // formData.append(
                //     `purchase_quote_lines[${i}]${"[type]"}`,
                //     this.tableData[i]?.type ?? ""
                // );
                formData.append(
                    `purchase_quote_lines[${i}]${"[quantity]"}`,
                    this.tableData[i]?.quantity ?? ""
                );
                formData.append(
                    `purchase_quote_lines[${i}]${"[unit_of_measure_code]"}`,
                    this.tableData[i]?.unit_of_measure_code ?? ""
                );
                formData.append(
                    `purchase_quote_lines[${i}]${"[direct_unit_cost]"}`,
                    this.tableData[i]?.direct_unit_cost ?? ""
                );
                formData.append(
                    `purchase_quote_lines[${i}]${"[line_amount]"}`,
                    this.tableData[i]?.line_amount ?? ""
                );
            }

            this.$loadingStart();
            this.apiService
                .PostForm(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/purchase-quotes`,
                    formData
                )
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.message);
                        if (res.data?.support_attachments)
                            this.supportAttachment =
                                res.data?.support_attachments
                                    .split(";")
                                    .slice(0, -1)
                                    .map((ele) => {
                                        return (
                                            ele.split("/").splice(-1, 1)[0] ??
                                            false
                                        );
                                    });

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
};
</script>
