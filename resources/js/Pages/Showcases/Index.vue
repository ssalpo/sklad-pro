<template>
    <PageWrapper
        header-title="Витрины"
        header-pre-title="В списке отображается все ваши доступные витрины"
    >

        <template #headerActions>
            <Link :href="route('showcases.create')" class="btn btn-primary">+ Добавить витрину</Link>
        </template>


        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Название</th>
                        <th>Дата создания</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="showcase in showcases">
                        <td>{{ showcase.id }}</td>
                        <td>{{ showcase.name }}</td>
                        <td class="text-muted">
                            {{ showcase.created_at_formatted }}
                        </td>
                        <td class="text-end">
                            <Link :href="route('showcases.edit', showcase.id)" class="btn btn-sm btn-outline-primary me-2">Ред.</Link>

                            <delete-btn
                                :url="route('showcases.destroy', showcase.id)"
                            />
                        </td>
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
import DeleteBtn from "../../Shared/DeleteBtn.vue";

export default {
    components: {DeleteBtn, Card, PageWrapper, Link},
    props: ['showcases']
}
</script>
