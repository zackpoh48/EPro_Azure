<template>
    <loader v-if="$loading.value"></loader>
    <router-view></router-view>
</template>

<script lang="ts">
import Layout from "./components/layouts/layout.vue";
import Loader from "./components/commons/Loader.vue";
export default {
    components: {
        Layout,
        Loader,
    },
    mounted() {
        this.onScreenUpdate();
        this.updateLayout();
    },
    methods: {
        onScreenUpdate() {
            window.addEventListener("resize", () => {
                this.updateLayout();
            });
        },
        updateLayout() {
            let size = "default";
            if (window.innerWidth < 767) {
                size = "full";
            } else if (window.innerWidth >= 767 && window.innerWidth <= 1140) {
                size = "condensed";
            }
            document
                .getElementsByTagName("html")[0]
                .setAttribute("data-sidenav-size", size);
        },
    },
};
</script>
