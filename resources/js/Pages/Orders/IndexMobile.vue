<template>
    <card class="mb-5" card-body-class="px-3">
        <EmptyResult v-if="!orders.data.length" />

        <OrderItems :orders="orders.data" v-else />

        <template #cardFooter v-if="orders.links.length > 3">
            <Pagination class="float-end" :links="orders.links"/>
        </template>
    </card>
</template>

<script>
import Card from "../../Shared/Card.vue";
import OrderItems from "../../Shared/Mobile/OrderItems.vue";
import Pagination from "../../Shared/Pagination.vue";
import EmptyResult from "../../Shared/EmptyResult.vue";

export default {
    name: "OrdersIndexMobile",
    props: ['orders', 'showcasesCount'],
    components: {EmptyResult, Pagination, OrderItems, Card}
}
</script>
