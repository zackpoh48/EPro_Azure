import Vue from "vue";
import moment from "moment";

export default {
    install(Vue) {
        Vue.filter("formatDate", function(date) {
            return moment(date).format("MMM DD, YYYY");
        });
    }
};
