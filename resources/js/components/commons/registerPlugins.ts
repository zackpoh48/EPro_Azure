import router from "./../../router";

// Types
import { App, provide, ref } from "vue";
import { useDateFormat } from "@vueuse/core";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";


export function registerPlugins(app: App) {
    app.use(router);
    app.config.globalProperties.$date = (value, format = "DD/MM/YYYY") => {
        return useDateFormat(value, format).value;
    };

    app.config.globalProperties.$getFile = (
        key,
        refrence,
        accept = "",
        isMultiple = false,
        append = false
    ) => {
        const input = document.createElement("input");
        input.type = "file";
        input.accept = accept;
        input.multiple = isMultiple;
        input.click();
        input.addEventListener(
            "change",
            ($event) => {
                if (append && typeof refrence[key][0] != "string") {
                    refrence[key] = [...refrence[key], ...$event.target?.files];
                } else {
                    refrence[key] = $event.target?.files;
                }
                input.removeEventListener("change", () => {});
            },
            false
        );
    };
    app.config.globalProperties.$getFileName = (key, refrence) => {
        if (!refrence[key]) return;
        let name: Array<string> = [];
        for (let i = 0; i < refrence[key].length; i++) {
            name.push(refrence[key][i]?.name);
        }
        return name.toString();
    };

    app.config.globalProperties.$loading = ref(false);
    app.config.globalProperties.$companyName = ref(
        localStorage.getItem("company_name")
    );
    app.config.globalProperties.$vendorNo = ref(
        localStorage.getItem("vendor_no")
    );
    app.config.globalProperties.$siteKey = document.body.dataset.sitekey;
    app.config.globalProperties.$loadingStart = () => {
        app.config.globalProperties.$loading.value = true;
    };
    app.config.globalProperties.$loadingStop = () => {
        app.config.globalProperties.$loading.value = false;
    };
    app.config.globalProperties.$formatNumber = (n) => {
        const number = parseFloat(n);

        const formatter = new Intl.NumberFormat("en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        if (number === 0) return number;
        else return formatter.format(number);
    };

    app.config.globalProperties.$toast = useToast({
        position: "top-right",
        dismissible: true,
        duration: 3000,
        pauseOnHover: true,
    });
    router.beforeResolve((to, from) => {
        app.config.globalProperties.$loadingStop();
    });
}
