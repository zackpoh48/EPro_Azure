<template>
    <div class="page-wrapper mt-4">
        <!-- <loader v-if="loading"></loader> -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-2 mb-1">
                        <li class="breadcrumb-item">
                            <!-- <a href="#">My Application</a> -->
                            <router-link to="/rfqs">My Application</router-link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Submission Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                RFQ : <b>#{{ form.rfq_id }} </b>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                Date of RFQ : <b>{{ form.date_of_rfq }}</b>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                Priority : <b>{{ form.priority }}</b>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                No. of days left before expiry :
                                <b>{{ finalDateDiff }}</b>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                Requisition no. :
                                <b>{{ form.quotation_no }}</b>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                Buyer remarks :
                                <b>{{ form.buyer_remarks }}</b>
                            </div>
                            <div class="col-md-4 col-sm-6 col-12">
                                Need Date :
                                <b>{{ purchaseQuoteData?.needDate?? '-' }}</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="needs-validation" novalidate="">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <span class="text-danger">
                                    <i class="dripicons-time-reverse"></i>
                                    {{ finalDateDiff }} left</span
                                >
                                Expiry on
                                {{ $filters.formatDate(form.date_of_expiry) }}
                            </h5>
                            <div id="custom-styles-preview">
                                <div class="row">
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01"
                                                >Expected Delivery Date
                                                <span class="text-danger"
                                                    >*</span
                                                >
                                            </label>
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="delivery_date"
                                                placeholder="Expected Delivery Date"
                                                v-model="form.delivery_date"
                                                v-bind:class="{
                                                    'is-invalid':
                                                        errors.delivery_date,
                                                }"
                                            />
                                            <div class="invalid-feedback">
                                                {{ errors.delivery_date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01"
                                                >Pay Terms
                                            </label>
                                            <select
                                                class="form-select select2"
                                                data-toggle="select2"
                                                v-model="form.pay_terms"
                                            >
                                                <option
                                                    disabled
                                                    selected
                                                    value="null"
                                                >
                                                    Select
                                                </option>
                                                <option value="30 days">
                                                    30 days
                                                </option>
                                                <option value="60 days">
                                                    60 days
                                                </option>
                                                <option value="90 days">
                                                    90 days
                                                </option>
                                                <option value="other">
                                                    Other
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01">Advance Paid
                                            </label>
                                            <input type="text" class="form-control" placeholder="Advance Paid"
                                                v-model="form.advance_paid" @keypress="
                                                    onKeypress(
                                                        $event,
                                                        form.advance_paid
                                                    )
                                                " />
                                        </div>
                                    </div> -->
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01"
                                                >Supplier Quotation No.
                                                <span class="text-danger"
                                                    >*</span
                                                >
                                            </label>
                                            <textarea
                                                class="form-control"
                                                v-model="
                                                    form.vendor_quotation_no
                                                "
                                                v-bind:class="{
                                                    'is-invalid':
                                                        errors.vendor_quotation_no,
                                                }"
                                                maxlength="35"
                                            >
                                            </textarea>
                                            <div class="invalid-feedback">
                                                {{ errors.vendor_quotation_no }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="quotation_valid_date">
                                                Quotation Valid Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input
                                                type="date"
                                                class="form-control"
                                                v-model="purchaseQuoteData.quotationValidDate"
                                                v-bind:class="{
                                                    'is-invalid': errors.quotation_valid_date,
                                                }"
                                            />
                                            <div class="invalid-feedback">
                                                {{ errors.quotation_valid_date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01"
                                                >Currency
                                                <span class="text-danger"
                                                    >*</span
                                                >
                                            </label>
                                            <select
                                                class="form-select select2"
                                                data-toggle="select2"
                                                v-model="form.currency"
                                                v-bind:class="{
                                                    'is-invalid':
                                                        errors.currency,
                                                }"
                                            >
                                                <option :value="null">
                                                    Select
                                                </option>
                                                <option value="MYR">MYR</option>
                                                <option value="USD">USD</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ errors.currency }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01"
                                                >Supplier Remarks
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Supplier Remarks"
                                                v-model="form.supplier_remarks"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-sm-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01"
                                                >Delivery Location
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Delivery Location"
                                                v-model="form.delivery_location"
                                                readonly
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table max-content table-hover table-centered mb-0"
                            >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Offer Oty</th>
                                        <th>Offer UOM</th>
                                        <th>Cost</th>
                                        <th>Disc(%)</th>
                                        <th>SST(%)</th>
                                        <th>Remarks</th>
                                        <th>Submitting</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in form.items">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <p
                                                class="text-primary font-weight-bold mb-0"
                                            >
                                                {{ item.item_description }}
                                            </p>
                                            <small class="d-block">
                                                <b>
                                                    No.
                                                    {{ item.item_no }}
                                                </b>
                                            </small>
                                            <span
                                                class="badge badge-primary-lighten badge-pill"
                                                >Delivery Date
                                                {{
                                                    $filters.formatDate(
                                                        item.item_expected_delivery
                                                    )
                                                }}</span
                                            >
                                        </td>
                                        <td>
                                            <p>{{ item.qty }}</p>
                                        </td>
                                        <td>
                                            <p>{{ item.uom }}</p>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input
                                                    class="form-control number-min-width"
                                                    v-model="
                                                        form.items[index]
                                                            .offer_qty
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errorsItem[index]
                                                                .offer_qty,
                                                    }"
                                                    :disabled="
                                                        form.items[index]
                                                            .is_submitting ===
                                                        '0'
                                                    "
                                                    @keypress="
                                                        onKeypress(
                                                            $event,
                                                            form.items[index]
                                                                .offer_qty
                                                        )
                                                    "
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errorsItem[index]
                                                            .offer_qty
                                                    }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input
                                                    class="form-control number-min-width"
                                                    v-model="
                                                        form.items[index]
                                                            .offer_uom
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errorsItem[index]
                                                                .offer_uom,
                                                    }"
                                                    :disabled="
                                                        form.items[index]
                                                            .is_submitting ===
                                                        '0'
                                                    "
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errorsItem[index]
                                                            .offer_uom
                                                    }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input
                                                    type="text"
                                                    class="form-control number-min-width"
                                                    v-model="
                                                        form.items[index].cost
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errorsItem[index]
                                                                .cost,
                                                    }"
                                                    :disabled="
                                                        form.items[index]
                                                            .is_submitting ===
                                                        '0'
                                                    "
                                                    @keypress="
                                                        onKeypress(
                                                            $event,
                                                            form.items[index]
                                                                .cost
                                                        )
                                                    "
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errorsItem[index].cost }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input
                                                    type="text"
                                                    class="form-control number-min-width"
                                                    v-model="
                                                        form.items[index]
                                                            .discount
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errorsItem[index]
                                                                .discount,
                                                    }"
                                                    :disabled="
                                                        form.items[index]
                                                            .is_submitting ===
                                                        '0'
                                                    "
                                                    @keypress="
                                                        onKeypress(
                                                            $event,
                                                            form.items[index]
                                                                .discount
                                                        )
                                                    "
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errorsItem[index]
                                                            .discount
                                                    }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input
                                                    type="text"
                                                    class="form-control number-min-width"
                                                    v-model="
                                                        form.items[index].sst
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errorsItem[index]
                                                                .sst,
                                                    }"
                                                    :disabled="
                                                        form.items[index]
                                                            .is_submitting ===
                                                        '0'
                                                    "
                                                    @keypress="
                                                        onKeypress(
                                                            $event,
                                                            form.items[index]
                                                                .sst
                                                        )
                                                    "
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errorsItem[index].sst }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="
                                                        form.items[index]
                                                            .remarks
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errorsItem[index]
                                                                .remarks,
                                                    }"
                                                    :disabled="
                                                        form.items[index]
                                                            .is_submitting ===
                                                        '0'
                                                    "
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errorsItem[index]
                                                            .remarks
                                                    }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select
                                                    class="form-control select2"
                                                    data-toggle="select2"
                                                    v-model="
                                                        form.items[index]
                                                            .is_submitting
                                                    "
                                                >
                                                    <!-- <option :value="null">Select</option> -->
                                                    <option value="1">
                                                        Yes
                                                    </option>
                                                    <option value="0">
                                                        No
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>{{ itemTotal[index] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <p class="text-secondary mb-0">
                                    Please attach the Quotation
                                </p>

                                <p class="w-90 text-muted font-italic mb-1">
                                    Acceptable file type: jpg, jpeg, png, doc,
                                    docx, pdf, xls, xlsx.<br />Max. file size:
                                    10MBs
                                </p>
                                <p class="text-muted font-italic mb-1">
                                    Can add up to 3 files.
                                </p>
                                <div class="w-50 add-more-file">
                                    <div id="quotation">
                                        <div class="form-group mb-1">
                                            <input
                                                type="file"
                                                class="form-control"
                                                name="quotation[]"
                                                multiple="multiple"
                                            />
                                        </div>
                                    </div>
                                    <div class="text-danger small show">
                                        {{ errors.quotation }}
                                    </div>
                                    <a
                                        @click="addMoreFile('quotation')"
                                        id="add-more-link"
                                        class="d-inline-block mb-3 crsr-p"
                                        ><i class="uil uil-plus"></i> Add More
                                        File</a
                                    >
                                </div>
                            </div>
                            <div
                                class="col-6 offset-xs-0 offset-sm-0 text-right"
                            >
                                <div class="row">
                                    <div class="col-sm-5 col-6">
                                        <h5 class="total-txt">
                                            Additional Discount(%)
                                        </h5>
                                    </div>
                                    <div class="col-sm-6 col-6">
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.document_discount"
                                                @keypress="
                                                    onKeypress(
                                                        $event,
                                                        form.document_discount
                                                    )
                                                "
                                            />
                                            <div
                                                class="invalid-feedback text-left"
                                            >
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-12">
                                        <h4 class="total-txt">
                                            Total
                                            <b
                                                >{{ grandTotal }}
                                                {{ form.currency }}</b
                                            >
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Term and conditions</h4>
                        <p class="text-muted mb-1">
                            Please click the link(s) to view the
                            <a
                                :href="`/${tnc_url}`"
                                class="font-weight-bold"
                                target="_blank"
                                >Term and conditions</a
                            >
                        </p>
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox"
                                class="custom-control-input"
                                id="customCheck1"
                                v-model="form.terms"
                                v-bind:class="{
                                    'is-invalid': errors.terms,
                                }"
                            />
                            <label
                                class="custom-control-label mlc-1"
                                for="customCheck1"
                            >
                                I agree to the Terms and conditions</label
                            >
                            <div class="invalid-feedback text-left">
                                {{ errors.terms }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <button
                    type="button"
                    class="btn btn-primary btn-rounded"
                    @click="updateRfqDetails('save')"
                >
                    Save as Draft
                </button>
                <button
                    type="button"
                    class="btn btn-success btn-rounded mlc-1"
                    @click="updateRfqDetails('submit')"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import Loader from "../commons/Loader.vue";
import Events from "../commons/Events.js";
import Errors from "../commons/Errors.ts";
import moment from "moment";
import apiService from "../commons/apiService.ts";

export default {
    components: {
        Loader,
    },
    data() {
        return {
            apiService: new apiService(),
            loading: false,
            form: {
                rfq_id: this.$route.params.rfq_id,
                delivery_date: null,
                pay_terms: null,
                vendor_quotation_no: "",
                quotation_valid_date:"",
                supplier_remarks: "",
                delivery_location: "",
                currency: "",
                items: [],
                document_discount: "",
                total: "",
                terms: "",
                status: "",
                quotation_files: "",
            },
            tnc_url: "",
            finalDateDiff: "",
            errors: {},
            errorsItem: [],
            purchaseQuoteData:{}
        };
    },

    methods: {
        checkFileValidation(param, type) {
            if (type === "multi") {
                // $(`input[name='${param}[]'`).each((i, data) => {
                //     this.fileValidator(data, param);
                // });
                let inputs = document.querySelectorAll(
                    `input[name='${param}[]']`
                );
                inputs.forEach(
                    function (data) {
                        this.fileValidator(data, param);
                    }.bind(this)
                );
            } else {
                this.fileValidator(this.$refs[param], param);
            }
        },

        fileValidator(data, param) {
            const input = data.files[0];
            const inputSize = Math.round(input / 1024);

            if (!input) this.errors[param] = "File is required";
            if (input && inputSize > 10240)
                this.errors[param] = "File size must not be larger than 10MB";
            if (
                input &&
                !new RegExp("^.*\.(jpg|jpeg|png|pdf|doc|docx|xls|xlsx)$").test(
                    input.name
                )
            )
                this.errors[param] = "Invalid file extension specified";
        },

        addMoreFile(id) {
            document.querySelector(`#${id}`).insertAdjacentHTML(
                "beforeend",
                `
            <div class="form-group mb-1" style="display: inline-flex;">
                    <input
                        type="file"
                        class="form-control"
                        name="${id}[]"
                        multiple="multiple"
                    />
                    <button type="button" class="remove-div btn btn-primary mlc-1">X</button>
                </div>
            `
            );
            var container = document.getElementById(id);
            if (container.querySelectorAll("div").length === 3) {
                var parent = container.parentNode;
                var link = parent.querySelector("a");
                link.classList.remove("d-inline-block");
                link.classList.add("d-none");
            }
        },

        removeFileUpload(self) {
            self.closest("div").remove();
            const parent = document.querySelector("#quotation");
            if (parent.querySelectorAll("div.form-group").length === 2) {
                var link = document.getElementById("add-more-link");
                link.classList.add("d-inline-block");
                link.classList.remove("d-none");
            }
        },

        getRfqDetails() {
            this.$loadingStart();
            axios
                .get("/api/user/rfq-details", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                    params: {
                        rfq_id: this.$route.params.rfq_id,
                    },
                })
                .then((res) => res.data)
                .then((res) => {
                    this.form = {
                        ...this.form,
                        ...res.data,
                    };
                    this.generateItems();
                    this.initDatepicker();
                    this.dateDiffCal(res.data);
                    this.$toast.success(res.message);
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => this.$loadingStop());
        },

        checkForm(type) {
            this.errors = {};

            if (type !== "save") {
                let errorMessages = Errors.rfq;
                Object.keys(errorMessages).forEach((data) => {
                    if (!this.form[data])
                        this.errors[data] = errorMessages[data];
                });
                this.checkFileValidation("quotation", "multi");
            }

            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },

        checkItems(type) {
            this.errorsItem = [];

            if (type !== "save") {
                let errorMessages = Errors.rfqItems;
                Object.keys(errorMessages).forEach((data) => {
                    this.form.items.forEach((item, i) => {
                        this.errorsItem[i][data] = "";
                        if (!item[data])
                            this.errorsItem[i][data] = errorMessages[data];
                    });
                });
            }

            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },

        createFormData() {
            let formData = new FormData();
            formData.append("rfq_id", this.form?.rfq_id);
            formData.append("delivery_date", this.form?.delivery_date);
            formData.append("pay_terms", this.form?.pay_terms ?? "");
            formData.append(
                "vendor_quotation_no",
                this.form?.vendor_quotation_no ?? ""
            );
            formData.append("quotation_valid_date", this.form?.quotation_valid_date ?? "");
            formData.append("supplier_remarks", this.form?.supplier_remarks);
            formData.append(
                "delivery_location",
                this.form?.delivery_location ?? ""
            );
            formData.append("currency", this.form?.currency ?? "");
            formData.append(
                "document_discount",
                this.form?.document_discount ?? ""
            );
            formData.append("total", this.form?.total ?? "");
            formData.append("terms", this.form?.terms);
            formData.append("status", this.form?.status);
            formData.append("date_of_rfq", this.form?.date_of_rfq);
            formData.append("priority", this.form?.priority);
            formData.append("quotation_no", this.form?.quotation_no);
            formData.append("buyer_remarks", this.form?.buyer_remarks);
            formData.append("tender_title", this.form?.tender_title);
            formData.append("offer_validity", this.form?.offer_validity);
            formData.append("quality", this.form?.quality ?? "");
            formData.append("advance_paid", this.form?.advance_paid ?? "");
            const vendor_no = localStorage.getItem("vendor_no");
            if(vendor_no) {
                formData.append("vendor_no", vendor_no);
            }

            // $("input[name='quotation[]']").each((i, data) => {
            //     if (data.files[0])
            //         formData.append(`quotation_` + i, data.files[0]);
            // });

            document
                .querySelectorAll("input[name='quotation[]']")
                .forEach((input, index) => {
                    if (input.files[0]) {
                        formData.append(`quotation_${index}`, input.files[0]);
                    }
                });

            for (let i = 0; i < this.form.items.length; i++) {
                formData.append(
                    `items[${i}]${"[item_description]"}`,
                    this.form.items[i]?.item_description ?? ""
                );
                formData.append(
                    `items[${i}]${"[item_no]"}`,
                    this.form.items[i]?.item_no ?? ""
                );
                formData.append(
                    `items[${i}]${"[item_expected_delivery]"}`,
                    this.form.items[i]?.item_expected_delivery ?? ""
                );
                formData.append(
                    `items[${i}]${"[quality]"}`,
                    this.form.items[i]?.quality ?? ""
                );
                formData.append(
                    `items[${i}]${"[offer_qty]"}`,
                    this.form.items[i]?.offer_qty ?? ""
                );
                formData.append(
                    `items[${i}]${"[cost]"}`,
                    this.form.items[i]?.cost ?? ""
                );
                formData.append(
                    `items[${i}]${"[discount]"}`,
                    this.form.items[i]?.discount ?? 0
                );
                formData.append(
                    `items[${i}]${"[offer_uom]"}`,
                    this.form.items[i]?.offer_uom ?? ""
                );
                formData.append(
                    `items[${i}]${"[remarks]"}`,
                    this.form.items[i]?.remarks ?? ""
                );
                formData.append(
                    `items[${i}]${"[id]"}`,
                    this.form.items[i]?.id ?? ""
                );
                formData.append(
                    `items[${i}]${"[is_submitting]"}`,
                    this.form.items[i]?.is_submitting ?? ""
                );
                formData.append(
                    `items[${i}]${"[s_no]"}`,
                    this.form.items[i]?.s_no ?? ""
                );
                formData.append(
                    `items[${i}]${"[qty]"}`,
                    this.form.items[i]?.qty ?? ""
                );
                formData.append(
                    `items[${i}]${"[uom]"}`,
                    this.form.items[i]?.uom ?? ""
                );
                formData.append(
                    `items[${i}]${"[sst]"}`,
                    this.form.items[i]?.sst ?? ""
                );
                formData.append(
                    `items[${i}]${"[total]"}`,
                    this.form.items[i]?.total ?? 0
                );
            }
            return formData;
        },

        updateRfqDetails(type) {
            this.createSubPurchaseQuoteLines();
            let condition = this.checkForm(type);

            // let formData = this.createFormData();

            // for (let pair of formData.entries()) {
            //     console.log(pair[0] + ": " + pair[1]);
            // }

            if (condition) {
                // this.loading = true;
                this.$loadingStart();
                this.form.status = type === "save" ? 0 : 1;
                axios
                    .post(
                        "/api/user/update-rfq-details",
                        this.createFormData(),
                        {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem(
                                    "token"
                                )}`,
                            },
                        }
                    )
                    .then((res) => res.data)
                    .then((res) => {
                        this.$router.push({
                            path: "/rfqs",
                        });
                        this.$toast.success(res.message);
                    })
                    .catch((error) => {
                        error = error.response.data;
                        this.$toast.error(error.message);
                    })
                    .finally(() => this.$loadingStop());
            }
        },

        createSubPurchaseQuoteLines(){
            const paylaod = {
                buyfromVendorNo: this.purchaseQuoteData.buyfromVendorNo,
                no: this.purchaseQuoteData.no,
                documentDate: this.purchaseQuoteData.documentDate,
                expectedReceiptDate: this.purchaseQuoteData.expectedReceiptDate,
                paymentTermsCode: this.purchaseQuoteData.paymentTermsCode,
                paymentMethodCode: this.purchaseQuoteData.paymentMethodCode,
                supplierRemarks: this.purchaseQuoteData.supplierRemarks,
                locationCode: this.purchaseQuoteData.locationCode,
                supplierQuotationNo: this.purchaseQuoteData.supplierQuotationNo,
                orderPriority: this.purchaseQuoteData.orderPriority,
                quotationValidDate: this.purchaseQuoteData.quotationValidDate,
                documentDiscountPcnt: this.purchaseQuoteData.documentDiscountPcnt,
                currencyCode: this.purchaseQuoteData.currencyCode,
                fileAttachments: this.purchaseQuoteData.fileAttachments
            }

            this.$loadingStart();
            axios
                .post(
                    "/api/user/create-sub-purchase-quote-lines",
                    paylaod,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                )
                .then((res) => res.data)
                .then((res) => {
                    this.$toast.success(res.message);
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => this.$loadingStop());
        },

        // For managing and error handling of items table
        generateItems() {
            let formObject = {
                offer_qty: "",
                offer_uom: "",
                cost: "",
                discount: "",
                sst: "",
                remarks: "",
                is_submitting: "1",
            };

            if (this.form.submission)
                this.form.items = this.form.items.map(
                    (data) =>
                        (data = {
                            ...data,
                            ...formObject,
                        })
                );
            // New submission
            else this.form.items = [...this.form.items]; // Edit draft

            this.form.items.forEach(() => {
                this.errorsItem.push({
                    ...formObject,
                });
            });
        },

        onKeypress(e, data) {
            Events.onKeypress(e, data);
        },

        dateDiffCal(data) {
            let date = moment(new Date(data.date_of_expiry));
            let currentDate = moment();
            let dateDiff = date.diff(currentDate, "days", true).toFixed(0);
            if (dateDiff == 1) this.finalDateDiff = dateDiff + " day";
            else this.finalDateDiff = dateDiff + " days";
        },

        initDatepicker() {
            // $(document).ready(() => {
            //     let dateFields = ["delivery_date", "offer_validity"];
            //     dateFields.forEach((data) => {
            //         $(`#${data}`).datepicker({
            //             startDate: new Date(),
            //         });
            //         $(`#${data}`)
            //             .datepicker(
            //                 "setDate",
            //                 (this.form[data] = this.form[data]
            //                     ? new Date(this.form[data])
            //                     : new Date())
            //             )
            //             .on("changeDate", () => {
            //                 this.form[data] = $(`#${data}`).val();
            //             });
            //     });
            // });
            // document.addEventListener("DOMContentLoaded", function () {
            // let dateFields = ["delivery_date", "offer_validity"];
            // console.log(dateFields);
            // dateFields.forEach(function (data) {
            //     let datePicker = document.getElementById(data);
            //     datePicker.value = moment().format("YYYY-MM-DD");
            //     datePicker.addEventListener("change", function () {
            //         this.form[data] = this.value;
            //     });
            // });
            // });
        },
        getPurchaseQuoteData() {
            this.$loadingStart();
            let url = `/api/users/companies/${localStorage.getItem(
                "id"
            )}/${localStorage.getItem("vendor_no")}/purchase-quotes`;

            this.apiService.Get(url).then((res) => {
                this.$loadingStop();
                if (res.success) {
                    this.purchaseQuoteData = Array.isArray(res.data?.value)
                                ? res.data.value.find(item => item.rfqNo === 'RFQ24-00015')
                                : res.data.value;

                    this.purchaseQuoteData.quotationValidDate = moment(this.purchaseQuoteData.quotationValidDate).format("YYYY-MM-DD")
                    console.log('purchaseQuote data',this.purchaseQuoteData);
                } else if (res.success && res.data) {
                    this.purchaseQuoteData = {};
                } else if (!res.message?.includes("Invalid scope")) {
                    this.$toast.error(res.message ?? "Something went wrong");
                }
            });
        },
    },

    computed: {
        itemTotal() {
            return this.form.items.map((data) => {
                let discount =
                    (data.offer_qty * data.cost * data.discount) / 100;
                let sst = (data.offer_qty * data.cost - discount) * (data.sst / 100);
                data.total = data.offer_qty * data.cost - discount + sst;
                return parseFloat(data.total).toFixed(2);
            });
        },

        grandTotal() {
            if (this.itemTotal.length !== 0) {
                let document_discount = this.form.document_discount;
                if (typeof document_discount && document_discount === "")
                    document_discount = 0;

                let total_sst = 0;
                // this.form.items.forEach((data) => {
                //     if (data.sst) {
                //         total_sst += (data.total * data.sst) / 100;
                //         total_sst.toFixed(2);
                //     }
                // });

                let discount =
                    (this.itemTotal.reduce(
                        (a, b) => parseFloat(a) + parseFloat(b),
                        total_sst
                    ) *
                        document_discount) /
                    100;

                let grandTotalVal = this.itemTotal.reduce((a, b) => {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

                grandTotalVal = grandTotalVal + total_sst;

                grandTotalVal = grandTotalVal - discount;

                return parseFloat(grandTotalVal).toFixed(2);
            }
        },
    },

    created() {
        const me = this;
        document.addEventListener("click", function (e) {
            if (e.target && e.target.matches(".remove-div, .remove-div *")) {
                me.removeFileUpload(e.target);
            }
        });
    },

    mounted() {
        this.getPurchaseQuoteData();
        this.getRfqDetails();
        this.initDatepicker();
        this.tnc_url = localStorage.getItem("tnc_url");
    },
};
</script>

<style scoped>
.mlc-1 {
    margin-left: 0.375rem;
}
.crsr-p {
    cursor: pointer;
}

.total-txt {
    text-align: right;
    margin: 10px 0;
}

.badge {
    color: #6c757d;
}
</style>
