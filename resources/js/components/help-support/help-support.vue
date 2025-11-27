<template>
    <div class="page-title-box d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">Help Support</li>
            </ol>
        </nav>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <table id="fixed-columns-datatable"
                class="table mb-0 table-hover nowrap row-border w-100 scroll-horizontal-datatable 100">
                <thead class="table-light">
                    <tr>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="line in tableData" :key="line.id">
                        <td>{{ line.name }} - {{ line.desc }}</td>
                        <td>
                            <a :href="line.url" :download="line.name + '.pdf'" type="button"
                                class="btn btn-outline-info rounded-2">
                                PDF
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            tableData: [
                {
                    id: 1,
                    name: "User manual",
                    desc: "A detailed guide that explains the functionalities of the software",
                    url: localStorage.user_manual_url,
                },
                {
                    id: 2,
                    name: "Troubleshooting guide",
                    desc: "A step-by-step guide to resolving common issues that users might encounter",
                    url: localStorage.troubleshooting_guide_url,
                },
            ],
        };
    },
};
</script>
