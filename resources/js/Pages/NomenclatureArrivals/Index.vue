<template>
    <PageWrapper
        header-title="Приход"
        header-pre-title="В списке отображается все приходы по товарам"
    >

        <template #headerActions>
            <Link :href="route('nomenclature-arrivals.create')" class="btn btn-primary">
                <IconCirclePlus :size="18" class="me-2" stroke-width="1.7" />
                Новый приход
            </Link>
        </template>


        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Товар</th>
                        <th>Кол-во</th>
                        <th>Себестоимость</th>
                        <th>Цена прихода</th>
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
                        <td>{{ numberFormat(nomenclatureArrival.base_price, 2) }} сом.</td>
                        <td>{{ numberFormat(nomenclatureArrival.price_for_sale, 2) }} сом.</td>
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

    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Card from "../../Shared/Card.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import {numberFormat} from "../../functions";
import Pagination from "../../Shared/Pagination.vue";
import EditLinkBtn from "../../Shared/EditLinkBtn.vue";
import {IconCirclePlus} from "@tabler/icons-vue";

export default {
    components: {IconCirclePlus, EditLinkBtn, Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['nomenclatureArrivals'],
    methods: {
        numberFormat
    }
}
</script>
