<template>
    <PageWrapper
        :header-title="`Заказ №${order.id}`"
        :back-url="route('orders.index')"
    >
        <card card-title="Данные заказа" class="mb-3" without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <tbody>
                        <tr v-if="showcasesCount">
                            <td width="250" class="text-start text-sm-end fw-bold">Витрина</td>
                            <td>{{order.showcase.name || '-'}}</td>
                        </tr>
                        <tr>
                            <td width="250" class="text-start text-sm-end fw-bold">Клиент</td>
                            <td>{{order.client.name || '-'}}</td>
                        </tr>
                        <tr>
                            <td width="250" class="text-start text-sm-end fw-bold">
                                Общая сумма
                            </td>
                            <td>{{numberFormat(order.amount)}} сом.</td>
                        </tr>
                        <tr>
                            <td width="250" class="text-start text-sm-end fw-bold">
                                Прибыль
                            </td>
                            <td>{{numberFormat(order.profit)}} сом.</td>
                        </tr>
                        <tr>
                            <td width="250" class="text-start text-sm-end fw-bold">
                                Статус
                            </td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </card>

        <card card-title="Товары" without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">Номенклатура</th>
                        <th>Цена за ед.</th>
                        <th>Кол-во</th>
                        <th>Сумма продажи</th>
                        <th>Сумма прибыли</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in order.items">
                        <td>{{item.nomenclature.name}}</td>
                        <td>{{item.price_for_sale}} сом.</td>
                        <td>{{ item.quantity}}</td>
                        <td>{{item.total_amount}} сом.</td>
                        <td>{{item.total_profit}} сом.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </card>

    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Card from "../../Shared/Card.vue";
import {numberFormat} from "../../functions";

export default {
    components: {Card, PageWrapper, Link},
    props: ['order', 'showcasesCount'],
    methods: {
        numberFormat
    }
}
</script>
