<template>
    <div>
        <purchase-quote-list
            v-if="!selectedLine"
            :quotes="filteredData"
            @view-details="selectedLine = $event"
        />

        <purchase-quote-view-details
            v-else
            :line="selectedLine"
            @back="selectedLine = null"
        />
    </div>
</template>

<script>
import purchaseQuoteList from "./purchase-quote-list.vue";
import purchaseQuoteViewDetails from "./purchase-quote-view-details.vue";

export default {
    components: { purchaseQuoteList, purchaseQuoteViewDetails },
    data() {
        return {
            selectedLine: null,
        };
    },
};
</script>
