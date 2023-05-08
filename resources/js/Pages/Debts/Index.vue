<template>
    <PageWrapper
        header-title="Долги клиентов"
    >
        <template #headerActions>
            <Link :href="route('debts.create')" class="btn btn-primary">+ Добавить</Link>
        </template>

        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Сумма долга</th>
                        <th>Клиент</th>
                        <th>Комментарий</th>
                        <th>Дата создания</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="debt in debts.data">
                        <td>{{ debt.id }}</td>
                        <td>{{ numberFormat(debt.amount, 2) }} сом.</td>
                        <td>{{ debt.client?.name || '-' }}</td>
                        <td>{{ debt.comment }}</td>
                        <td class="text-muted">{{ debt.created_at_formatted }}</td>
                        <td class="text-end">
                            <Link :href="route('debts.edit', debt.id)" class="btn btn-sm btn-outline-primary me-2">
                                Ред.
                            </Link>

                            <DeleteBtn
                                :url="route('debts.destroy', debt.id)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <template #cardFooter v-if="debts.links.length > 3">
                <Pagination :links="debts.links"/>
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
    methods: {numberFormat},
    components: {Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['debts']
}
</script>
