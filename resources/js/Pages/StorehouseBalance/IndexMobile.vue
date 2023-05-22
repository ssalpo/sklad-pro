<template>
    <card>
        <NomenclatureArrivalItems
            :items="balances"
        />
    </card>
</template>

<script>
import NomenclatureArrivalItems from "../../Shared/Mobile/NomenclatureArrivalItems.vue";
import Card from "../../Shared/Card.vue";

export default {
    name: "StorehouseBalanceIndexMobile",
    components: {Card, NomenclatureArrivalItems},
    props: ['balances']
}
</script>
