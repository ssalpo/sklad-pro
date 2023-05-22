<template>
    <card without-body>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="balance in balances">
                    <td>{{ balance.nomenclature.name }}</td>
                    <td>{{ numberFormat(balance.quantity) }} {{ balance.unit.name }}</td>
                    <td>{{ numberFormat(balance.quantity * balance.nomenclature.base_price) }} c.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </card>
</template>

<script>
import Card from "../../Shared/Card.vue";
import {numberFormat} from "../../functions";

export default {
    name: "StorehouseBalanceIndexDesktop",
    methods: {numberFormat},
    components: {Card},
    props: ['balances']
}
</script>
