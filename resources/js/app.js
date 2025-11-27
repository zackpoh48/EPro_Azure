import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import Unicon from "vue-unicons";
import { registerPlugins } from "./components/commons/registerPlugins";
import Icons from "./components/commons/registerIcons.ts";
import moment from "moment";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

Unicon.add(Icons);

const app = createApp(App);
registerPlugins(app);

// Register Multiselect globally
app.component("Multiselect", Multiselect);

app.config.globalProperties.$filters = {
    formatDate(date) {
        return moment(date).format("MMM DD, YYYY");
    },
};

app.use(Unicon).mount("#app");
