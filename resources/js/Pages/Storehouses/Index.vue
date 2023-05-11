<template>
    <PageWrapper
        header-title="Склады"
        header-pre-title="В списке отображается все ваши доступные склады"
    >

        <template #headerActions>
            <Link :href="route('storehouses.create')" class="btn btn-primary">
                <IconCirclePlus :size="18" class="me-2" stroke-width="1.7" />
                Добавить склад
            </Link>
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
                    <tr v-for="storehouse in storehouses">
                        <td>{{ storehouse.id }}</td>
                        <td>{{ storehouse.name }}</td>
                        <td class="text-muted">
                            {{ storehouse.created_at_formatted }}
                        </td>
                        <td class="text-end">
                            <EditLinkBtn
                                :url="route('storehouses.edit', storehouse.id)"
                                class="me-2"
                            />

                            <delete-btn
                                v-if="storehouses.length > 1"
                                :url="route('storehouses.destroy', storehouse.id)"
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

export default {
    components: {IconCirclePlus, EditLinkBtn, DeleteBtn, Card, PageWrapper, Link},
    props: ['storehouses']
}
</script>
