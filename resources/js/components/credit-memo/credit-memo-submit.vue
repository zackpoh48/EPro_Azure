<template>
    <div class="page-title-box d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <router-link to="/purchase-credit-memo">Credit Memo</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Submit Credit Memo ({{ poNo }})
                </li>
            </ol>
        </nav>
        <div class="pa-0 d-flex justify-end">
            <button type="button" class="btn btn-primary min-w-20 rounded-5 mx-1">
                Print
            </button>
            <button type="button" class="btn btn-primary min-w-20 rounded-5 mx-1">
                Save as Draft
            </button>
            <button type="button" class="btn btn-success min-w-20 rounded-5 mx-1">
                Submit
            </button>
        </div>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Credit Memo</h4>

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Credit Note No</label>
                        </td>
                        <td class="pb-1">
                            <input readonly class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2" />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Date</label>
                        </td>
                        <td class="pb-1">
                            <input readonly class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2" />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Currency</label>
                        </td>
                        <td class="pb-1">
                            <input readonly class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2" />
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Amount Including SST</label>
                        </td>
                        <td class="pb-1">
                            <input readonly class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <div class="py-2 d-flex align-items-center justify-content-between">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="selectAll" />
                    <label class="form-check-label" for="inlineCheckbox1">Select All ({{ 0 }} Item(s))</label>
                </div>
                <button type="button" class="btn rounded-1 py-1" @click="deleteElement('')">
                    <unicon name="trash-alt" class="muted mx-1"></unicon>Delete
                </button>
            </div>
            <div class="width-100 overflow-auto">
                <table id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100">
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(line, index) in tableData" :key="line.no + '-' + index">
                            <td>{{ line["no"] }}</td>
                            <td class="min-w-50">{{ line["description"] }}</td>
                            <td class="text-center">
                                {{ line["location_name"] }}
                            </td>
                            <td class="text-center">
                                <input class="form-control py-1 text-end" type="number" min="0"
                                    oninput="validity.valid||(value={{line['qunatity']}});"
                                    v-model.number="line['quantity']" />
                            </td>
                            <td class="text-center">{{ line["uom"] }}</td>
                            <td class="text-center">
                                {{ line["unit_cost_incl_sst"] }}
                            </td>
                            <td class="text-center">
                                {{ line["amount_incl_sst"] }}
                            </td>
                            <td class="text-center">
                                {{ line["delivery_order_no"] }}
                            </td>
                            <td class="px-0">
                                <button type="button" @click="deleteElement(line.no)" class="btn rounded-5 btn-sm px-1">
                                    <unicon name="trash-alt"></unicon>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive-->

            <div class="card-footer text-center">
                <button type="button" class="btn btn-warning text-dark" @click="openDialog()">
                    Get Source Receipt
                </button>
            </div>
        </div>
        <!-- end card body-->
    </div>

    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Purchase Invoice Attachments</h4>

            <div>
                <table>
                    <tr>
                        <td class="pb-1">
                            <label class="me-2">Attachment-Credit Memo</label>
                        </td>
                        <td class="pb-1">
                            <input readonly @click="$getFile('creditMemoAttachment', $data)" :value="$getFileName('creditMemoAttachment', $data)
                                " class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="button" class="btn btn-primary min-w-20 rounded-5 mx-1">
                Print
            </button>
            <button type="button" class="btn btn-primary min-w-20 rounded-5 mx-1">
                Save as Draft
            </button>
            <button type="button" class="btn btn-success min-w-20 rounded-5 mx-1">
                Submit
            </button>
        </div>
    </div>
    <confirmation-dialog ref="confirmDialog"></confirmation-dialog>

    <template v-if="dialogOpen">
        <receiptDialog :show="dialogOpen" @close="dialogClose($event)"></receiptDialog>
    </template>
</template>
<script lang="ts">
import receiptDialog from "./get-source-receipt-dialog.vue";
import confirmationDialog from "./../commons/confirmationDialog.vue";
export default {
    expose: ["confirmDialog"],
    components: {
        receiptDialog,
        confirmationDialog,
    },
    data() {
        return {
            dialogOpen: false,
            openConfirm: false,
            poNo: "",
            deliveryOrderNo: "",
            invoice: "",
            invoiceNo: "",
            attachmentDelivery: [],
            attachmentInvoice: [],
            toBillInput: undefined,
            tableData: [
                {
                    no: 123,
                    description: "Some descriptive texts is written here",
                    location_name: "Delhi",
                    quantity: 5,
                    uom: "Kg",
                    unit_cost_incl_sst: 5000.5,
                    amount_incl_sst: 5000.0,
                    delivery_order_no: 5,
                },
            ],
        };
    },
    methods: {
        openDialog() {
            this.dialogOpen = true;
        },
        dialogClose(event) {
            console.log(event)
            if (event.action) {

            }
            this.dialogOpen = false;
        },
        async deleteElement(data) {
            const response = await this.$refs.confirmDialog.show({
                title: "Title",
            });

            if (response) {
                this.$toast.success("Item deleted");
            }
        },
    },
    mounted() {
        this.poNo = this.$route.params.doc_no;
    },
};
</script>
