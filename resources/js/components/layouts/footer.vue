<template>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="py-4 text-center">
                    <!-- <img :src="companyLogoUrl" class="ch-13" /><br /> -->
                    ©{{ new Date().getFullYear() }}, All Rights
                    Reserved.
                </div>
                <div class="text-center"></div>
            </div>
        </div>
    </footer>
</template>
<script lang="ts">
import apiService from "../commons/apiService";
export default {
    name: "footer",
    props: {
        companyLogoUrl: {
            type: String,
            default: "",
        },
    },
};
</script>
