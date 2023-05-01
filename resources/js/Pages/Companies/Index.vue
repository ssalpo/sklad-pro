<template>
    <PageWrapper
        header-pre-title="Список ваших подключенных компаний"
        header-title="Мои компании"
    >
        <template #headerActions>
            <Link :href="route('companies.create')" class="btn btn-primary">
                <IconPlus :size="24" stroke-width="2" class="mr-2"/>
                Подключить компанию
            </Link>
        </template>

        <CompanyCard :company="company"
                     class="mb-3"
                     :key="company.id"
                     v-for="company in companies" />

    </PageWrapper>
</template>

<script>
import {
    IconPlus,
} from "@tabler/icons-vue";
import {Link} from '@inertiajs/inertia-vue3'
import PageWrapper from "../../Shared/PageWrapper.vue";
import CompanyCard from "../../Shared/CompanyCard.vue";

export default {
    components: {CompanyCard, PageWrapper, IconPlus, Link},
    props: ['companies']
}
</script>
