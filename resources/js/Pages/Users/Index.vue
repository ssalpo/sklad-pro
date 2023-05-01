<template>
    <PageWrapper
        header-title="Пользователи"
    >

        <template #headerActions>
            <Link :href="route('users.create')" class="btn btn-primary">+ Добавить пользователя</Link>
        </template>


        <card without-body>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Имя</th>
                        <th>Логин</th>
                        <th>Дата создания</th>
                        <th width="120"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.username }}</td>
                        <td class="text-muted">
                            {{ user.created_at_formatted }}
                        </td>
                        <td class="text-end">
                            <Link :href="route('users.edit', user.id)" class="btn btn-sm btn-outline-primary me-2">Ред.</Link>

                            <delete-btn
                                :url="route('users.destroy', user.id)"
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
    props: ['users']
}
</script>
