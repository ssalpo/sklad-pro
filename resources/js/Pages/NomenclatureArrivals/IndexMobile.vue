<template>
    <NomenclatureArrivalFilters class="mb-3" />

    <card>
        <EmptyResult v-if="!items.length" />

        <NomenclatureOperationItems
            :items="items"
        />

        <template #cardFooter v-if="nomenclatureArrivals.links.length > 3">
            <Pagination class="float-end" :links="nomenclatureArrivals.links"/>
        </template>
    </card>
</template>

<script>
import NomenclatureOperationItems from "../../Shared/Mobile/NomenclatureOperationItems.vue";
import Card from "../../Shared/Card.vue";
import Pagination from "../../Shared/Pagination.vue";
import EmptyResult from "../../Shared/EmptyResult.vue";
import NomenclatureArrivalFilters from "./Filters.vue";

export default {
    name: "NomenclatureArrivalsIndexMobile",
    components: {NomenclatureArrivalFilters, EmptyResult, Pagination, Card, NomenclatureOperationItems},
    props: {
        nomenclatureArrivals: {
            type: Array,
            required: true
        }
    },
    computed: {
        items() {
            return this.nomenclatureArrivals.data.map(item => ({
                id: item.id,
                title: item.nomenclature.name,
                quantity: item.quantity,
                unit: item.nomenclature.unit,
                date: item.arrival_at_formatted
            }))
        }
    }
}
</script>
