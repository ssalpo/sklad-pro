<template>
    <NomenclatureArrivalFilters class="mb-3" />

    <card without-body>
        <EmptyResult v-if="!nomenclatureArrivals.data.length" />

        <div class="table-responsive" v-else>
            <table class="table table-vcenter text-nowrap card-table">
                <thead>
                <tr>
                    <th width="40">ID</th>
                    <th>Товар</th>
                    <th>Кол-во</th>
                    <th>Себестоимость</th>
                    <th>Цена продажи</th>
                    <th>Дата прихода</th>
                    <th>Дата создания</th>
                    <th>Комментарий</th>
                    <th width="120"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="nomenclatureArrival in nomenclatureArrivals.data">
                    <td>{{ nomenclatureArrival.id }}</td>
                    <td>{{ nomenclatureArrival.nomenclature.name }}</td>
                    <td>{{ nomenclatureArrival.quantity }} {{nomenclatureArrival.nomenclature.unit}}</td>
                    <td>{{ numberFormat(nomenclatureArrival.base_price, 2) }} с.</td>
                    <td>{{ numberFormat(nomenclatureArrival.price_for_sale, 2) }} с.</td>
                    <td>{{ nomenclatureArrival.arrival_at_formatted }}</td>
                    <td class="text-muted">{{ nomenclatureArrival.created_at_formatted }}</td>
                    <td class="text-muted">{{ nomenclatureArrival.comment }}</td>
                    <td class="text-end">
                        <EditLinkBtn
                            :url="route('nomenclature-arrivals.edit', nomenclatureArrival.id)"
                            class="me-2"
                        />

                        <DeleteBtn
                            :url="route('nomenclature-arrivals.destroy', nomenclatureArrival.id)"
                        />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <template #cardFooter v-if="nomenclatureArrivals.links.length > 3">
            <Pagination class="float-end" :links="nomenclatureArrivals.links"/>
        </template>
    </card>
</template>

<script>
import Card from "../../Shared/Card.vue";
import EditLinkBtn from "../../Shared/EditLinkBtn.vue";
import Pagination from "../../Shared/Pagination.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import {numberFormat} from "../../functions";
import EmptyResult from "../../Shared/EmptyResult.vue";
import NomenclatureArrivalFilters from "./Filters.vue";

export default {
    name: "NomenclatureArrivalsIndexDesktop",
    methods: {numberFormat},
    components: {NomenclatureArrivalFilters, EmptyResult, DeleteBtn, Pagination, EditLinkBtn, Card},
    props: {
        nomenclatureArrivals: {
            type: Array,
            required: true
        }
    }
}
</script>
