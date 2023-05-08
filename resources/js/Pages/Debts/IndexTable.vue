<template>
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
            <Pagination class="float-end" :links="debts.links"/>
        </template>
    </card>
</template>

<script>
import Card from "../../Shared/Card.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Pagination from "../../Shared/Pagination.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import {numberFormat} from "../../functions";

export default {
    name: "IndexTable",
    props: ['debts'],
    methods: {numberFormat},
    components: {DeleteBtn, Pagination, Link, Card}
}
</script>

<style scoped>

</style>
