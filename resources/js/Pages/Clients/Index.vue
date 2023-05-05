<template>
    <PageWrapper
        header-title="Клиенты"
        header-pre-title="В списке отображается все ваши добавленные клиенты"
    >

        <template #headerActions>
            <Link :href="route('clients.create')" class="btn btn-primary">+ Добавить клиента</Link>
        </template>


        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Название</th>
                        <th>Телефон</th>
                        <th>Дата создания</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="client in clients.data">
                        <td>{{ client.id }}</td>
                        <td>{{ client.name }}</td>
                        <td>{{ client.phone }}</td>
                        <td class="text-muted">
                            {{ client.created_at_formatted }}
                        </td>
                        <td class="text-end">
                            <Link :href="route('clients.edit', client.id)" class="btn btn-sm btn-outline-primary me-2">Ред.</Link>

                            <delete-btn
                                :url="route('clients.destroy', client.id)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <template #cardFooter v-if="clients.links.length > 3">
                <Pagination :links="clients.links"/>
            </template>
        </card>

    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Card from "../../Shared/Card.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import Pagination from "../../Shared/Pagination.vue";

export default {
    components: {Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['clients']
}
</script>
