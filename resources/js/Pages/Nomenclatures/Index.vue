<template>
    <PageWrapper
        header-title="Номенклатура"
        header-pre-title="В списке отображается все ваши доступные номенклатуры"
    >

        <template #headerActions>
            <Link :href="route('nomenclatures.create')" class="btn btn-primary">+ Добавить номенклатуру</Link>
        </template>


        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Название</th>
                        <th>Себестоимость</th>
                        <th>Цена продажи</th>
                        <th>Дата создания</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="nomenclature in nomenclatures.data">
                        <td>{{ nomenclature.id }}</td>
                        <td>{{ nomenclature.name }}</td>
                        <td>{{ numberFormat(nomenclature.base_price, 2) }} сом.</td>
                        <td>{{ numberFormat(nomenclature.price_for_sale, 2) }} сом.</td>
                        <td class="text-muted">
                            {{ nomenclature.created_at_formatted }}
                        </td>
                        <td class="text-end">
                            <Link :href="route('nomenclatures.edit', nomenclature.id)" class="btn btn-sm btn-outline-primary me-2">Ред.</Link>

                            <DeleteBtn
                                :url="route('nomenclatures.destroy', nomenclature.id)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <template #cardFooter v-if="nomenclatures.links.length > 3">
                <Pagination :links="nomenclatures.links"/>
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

export default {
    components: {Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['nomenclatures'],
    methods: {
        numberFormat
    }
}
</script>
