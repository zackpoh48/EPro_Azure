<template>
    <div v-if="show" @click="onClose(false)" class="modal-backdrop"></div>
    <div class="modal fade" :class="{ 'show d-block': show }" tabindex="-1" :aria-hidden="!show" :aria-modal="show"
        role="dialog" @click.self="onClose(false)">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable min-75-p">
            <div class="modal-content">
                <div class="modal-header border-0 pt-3">
                    <div class="h4 w-100 m-0 text-center">
                        Get Source Receipt
                    </div>
                </div>

                <div class="modal-body py-0">
                    <div class="d-flex align-items-center my-3">
                        <label>Search</label>
                        <input class="form-control-plaintext py-1 px-2 bg-secondary-subtle ms-2 w-25"
                            v-model="searchInput" />
                    </div>
                    <input type="checkbox" class="form-check-input" :checked="allSelected"
                        @change="selectAll($event.target.checked)" />
                    <label class="form-check-label mx-2 pb-2">SELECT ALL ({{ tableData.length }} ITEMS)</label>
                    <div class="width-100 overflow-auto">
                        <table id="fixed-columns-datatable"
                            class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center w-2 p-0"></th>
                                    <th class="text-center">
                                        Delivery Order No.
                                    </th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">
                                        Purchase Order No.
                                    </th>
                                    <th class="text-center">Item Code</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Qunatity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="filteredData.length > 0">
                                    <tr v-for="(line, index) in filteredData" :key="index">
                                        <td class="text-center px-0 w-2">
                                            <input class="form-check-input" type="checkbox"
                                                :checked="selectedList.indexOf(line.delivery_order_no) > -1"
                                                @change="selectionToggle(line.delivery_order_no)" />
                                        </td>
                                        <td class="text-center">
                                            {{ line["delivery_order_no"] }}
                                        </td>
                                        <td class="text-center">
                                            {{ $date(line["date"]) }}
                                        </td>
                                        <td class="text-center">
                                            {{ line["purchase_order_no"] }}
                                        </td>
                                        <td class="text-center">
                                            {{ line["item_code"] }}
                                        </td>
                                        <td class="min-w-50 text-center">
                                            {{ line["description"] }}
                                        </td>
                                        <td class="text-center">
                                            {{ line["uom"] }}
                                        </td>
                                        <td class="text-center">
                                            {{ line["quantity"] }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center py-2 gap-2 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" @click="onClose(false)">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill" @click="onClose('save')">
                        Add to Purchase Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "receiptDialogCredit",
    emits: ["close"],
    props: {
        show: {
            default: false,
            type: Boolean,
        },
    },
    data() {
        return {
            searchInput: '',
            selectedList: [],
            tableData: [
                {
                    delivery_order_no: "1001",
                    date: "2023-04-25",
                    purchase_order_no: "2002",
                    item_code: "1001",
                    description: "Apples",
                    uom: "Pcs",
                    quantity: 5,
                    selected: false,
                },
                {
                    delivery_order_no: "1002",
                    date: "2023-04-25",
                    purchase_order_no: "2002",
                    item_code: "1002",
                    description: "Apples",
                    uom: "Pcs",
                    quantity: 5,
                    selected: false,
                },
                {
                    delivery_order_no: "1003",
                    date: "2023-04-25",
                    purchase_order_no: "2002",
                    item_code: "1003",
                    description: "Apples",
                    uom: "Pcs",
                    quantity: 5,
                    selected: false,
                },
            ],
        };
    },
    methods: {
        onClose(action) {
            let data = {}
            if (action == 'save') {
                data = { action: true, data: this.tableData.filter(ele => this.selectedList.indexOf(ele.delivery_order_no) > -1) }
            } else {
                data = {
                    action: false, data: []
                }
            }
            this.$emit("close", { data: data });
        },
        selectAll(state) {
            if (state) {
                this.selectedList = this.tableData.map(ele => ele.delivery_order_no)
            } else {
                this.selectedList = [];
            }
            // this.tableData.map((data) => {
            //     data.selected = state;
            // });
        },
        selectionToggle(key) {
            let index = this.selectedList.indexOf(key);
            if (index > -1) {
                this.selectedList.splice(index, 1)
            } else {
                this.selectedList.push(key)
            }
        }
    },
    computed: {
        allSelected() {
            // return this.tableData?.filter((ele) => !ele.selected).length == 0;
            return this.tableData.length == this.selectedList.length && this.tableData.length > 0
        },
        filteredData() {
            if (!this.tableData.length) return []
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
