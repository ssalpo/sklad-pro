<template>
    <PageWrapper
        header-title="Продажи"
        header-pre-title="В списке отображается все приходы по товарам"
    >

        <template #headerActions>
            <Link :href="route('orders.create')" class="btn btn-primary">
                <IconCirclePlus :size="18" class="me-2" stroke-width="1.7" />
                Новый заказ
            </Link>
        </template>


        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter table-hover text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">Номер заказа</th>
                        <th width="40" v-if="showcasesCount > 0">Витрина</th>
                        <th>Сумма</th>
                        <th>Прибыль</th>
                        <th>Клиент</th>
                        <th>Статус</th>
                        <th>Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="cursor-pointer"
                            v-for="order in orders.data"
                            @click="$inertia.visit(route('orders.show', order.id))"
                        >
                            <td>{{order.id}}</td>
                            <td v-if="showcasesCount > 0">{{order.showcase?.name || '-'}}</td>
                            <td>{{numberFormat(order.amount, 2)}} сом.</td>
                            <td>{{numberFormat(order.profit, 2)}} сом.</td>
                            <td>{{order.client?.name || '-'}}</td>
                            <td :class="{'text-danger': order.status === 2, 'text-success': order.status === 1}">{{shared.order.statuses[order.status]}}</td>
                            <td width="160">{{order.created_at_formatted}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <template #cardFooter v-if="orders.links.length > 3">
                <Pagination class="float-end" :links="orders.links"/>
            </template>
        </card>

    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Card from "../../Shared/Card.vue";
import {numberFormat} from "../../functions";
import Pagination from "../../Shared/Pagination.vue";
import {IconCirclePlus} from "@tabler/icons-vue";

export default {
    components: {IconCirclePlus, Pagination, Card, PageWrapper, Link},
    props: ['orders', 'showcasesCount', 'shared'],
    methods: {
        numberFormat
    }
}
</script>
