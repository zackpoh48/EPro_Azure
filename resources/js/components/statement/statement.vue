<template>
    <div class="page-title-box">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">
                    Statement
                </li>
            </ol>
        </nav>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <h4 class="card-title">Statement</h4>
            <div
                class="py-2 d-flex flex-column gap-2 flex-sm-row justify-content-between"
            >
                <div class="d-flex align-items-center gap-1">
                    <label>Filter:</label>
                    <input
                        class="form-control"
                        type="date"
                        v-model="start_date"
                        placeholder="Start Date"
                    />
                    <span> To </span>
                    <input
                        class="form-control"
                        type="date"
                        v-model="end_date"
                        placeholder="End Date"
                    />
                    <button
                        type="button"
                        class="btn btn-light btn-sm rounded px-3"
                        @click="
                            start_date = '';
                            end_date = '';
                        "
                    >
                        Clear
                    </button>
                </div>
                <button
                    type="button"
                    class="btn btn-primary btn-sm rounded-pill px-3"
                    @click="getExcel()"
                >
                    Export
                </button>
            </div>
            <div class="width-100 overflow-auto">
                <table
                    id="fixed-columns-datatable"
                    class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100"
                >
                    <thead class="table-light">
                        <tr>
                            <!-- <th>Posting Date</th> -->
                            <th class="text-center">Document Date</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Document Type</th>
                            <th class="text-center">Document No.</th>
                            <th class="text-start">Description</th>
                            <th class="text-start">Currency</th>
                            <th class="text-end">Original Amount</th>
                            <th class="text-end">Remaining Amount</th>
                            <th class="text-center">Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="filteredTableData.length > 0">
                            <tr
                                v-for="(line, index) in filteredTableData"
                                :key="index"
                            >
                                <!-- <td>{{ $date(line["Posting_Date"]) }}</td> -->
                                <td class="text-center">{{ $date(line["documentDate"]) }}</td>
                                <td class="text-center">{{ line["PONo"] }}</td>
                                <td class="text-center">{{ line["documentType"] }}</td>
                                <td class="text-center">{{ line["documentNo"] }}</td>
                                <td class="text-start">{{ line["description"] }}</td>
                                <td class="text-start">{{ line["currency"] }}</td>
                                <td class="text-end">
                                    {{
                                        $formatNumber(
                                            String(
                                                line["documentType"] ==
                                                    "Credit Memo" ||
                                                    line["documentType"] ==
                                                        "Credit memo"
                                                    ? line["originalAmount"]
                                                    : line["originalAmount"]
                                            ).replace("-", "")
                                        )
                                    }}
                                </td>
                                <td class="border-e-sm text-end">
                                    {{
                                        $formatNumber(
                                            String(
                                                line["documentType"] ==
                                                    "Credit Memo" ||
                                                    line["documentType"] ==
                                                        "Credit memo"
                                                    ? line["remainingAmount"]
                                                    : line["remainingAmount"]
                                            ).replace("-", "")
                                        )
                                    }}
                                </td>
                                <td>{{ line["lastPaymentDate"] }}</td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot v-if="filteredTableData.length > 0">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-start"><b>Total Remaining Amount</b></td>
                            <td class="text-end">
                                {{
                                    filteredTableData.length > 0
                                        ? $formatNumber(
                                              totalRemainingAmountSum().toString()
                                          )
                                        : "00"
                                }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <template v-if="filteredTableData.length == 0">
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
<script>
import { ref } from "vue";
import moment from "moment";
import apiService from "../commons/apiService";
export default {
    data() {
        return {
            apiService: new apiService(),
            searchInput: "",
            tableData: ref([]),
            start_date: "",
            end_date: "",
        };
    },
    created() {
        console.log(moment("2023-09-29").isBetween("", ""));
        this.$loadingStart();
        this.apiService
            .Get(
                `/api/users/companies/${localStorage.getItem(
                    "id"
                )}/vendor-statements`
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
                    this.$toast.error(res.message ?? "Something went wrong");
                }
            });
    },
    methods: {
        getExcel() {
            this.$loadingStart();
            this.apiService
                .GetFile(
                    `/api/users/companies/${localStorage.getItem(
                        "id"
                    )}/vendor-statements/export`
                )
                .then((res) => {
                    this.$loadingStop();
                    if (!res.hasOwnProperty("message")) {
                        const url = URL.createObjectURL(new Blob([res]));
                        const link = document.createElement("a");
                        link.href = url;
                        link.setAttribute("download", "vendor-statement.pdf");
                        document.body.appendChild(link);
                        link.click();
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
        totalRemainingAmountSum() {
            return this.filteredTableData
                ?.map((a) => {
                    return a.remainingAmount;
                })
                .reduce((a, b) => Number(a) + Number(b));
        },
    },
    computed: {
        filteredTableData() {
            if (this.start_date == "" && this.end_date == "")
                return this.tableData;
            else if (this.start_date != "" && this.end_date == "")
                return this.tableData.filter((ele) =>
                    moment(ele.documentDate).isSameOrAfter(this.start_date)
                );
            else if (this.start_date == "" && this.end_date != "")
                return this.tableData.filter((ele) =>
                    moment(ele.documentDate).isSameOrBefore(this.end_date)
                );
            else {
                return this.tableData.filter((ele) =>
                    moment(ele.documentDate).isBetween(
                        moment(this.start_date).subtract(
                            moment.duration({ days: 1 })
                        ),
                        moment(this.end_date).add(moment.duration({ days: 1 })),
                        []
                    )
                );
            }
        },
    },
};
</script>
