<template>
    <PageWrapper
        header-title="Список единиц измерения"
        header-pre-title="В списке отображается все ваши доступные единицы измерения"
    >

        <template #headerActions>
            <Link :href="route('units.create')" class="btn btn-primary">
                <IconCirclePlus :size="18" class="me-2" stroke-width="1.7" />
                Добавить
            </Link>
        </template>


        <card without-body>
            <EmptyResult v-if="!units.length" />

            <div class="table-responsive" v-else>
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
                    <tr v-for="unit in units">
                        <td>{{ unit.id }}</td>
                        <td>{{ unit.name }}</td>
                        <td class="text-muted">
                            {{ unit.created_at_formatted }}
                        </td>
                        <td class="text-end">
                            <EditLinkBtn
                                :url="route('units.edit', unit.id)"
                                class="me-2"
                            />

                            <delete-btn
                                :url="route('units.destroy', unit.id)"
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
import EditLinkBtn from "../../Shared/EditLinkBtn.vue";
import {IconCirclePlus} from "@tabler/icons-vue";
import EmptyResult from "../../Shared/EmptyResult.vue";

export default {
    components: {EmptyResult, IconCirclePlus, EditLinkBtn, DeleteBtn, Card, PageWrapper, Link},
    props: ['units']
}
</script>
