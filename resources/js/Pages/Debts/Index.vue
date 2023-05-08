<template>
    <PageWrapper
        header-title="Долги клиентов"
    >
        <template #headerActions>
            <Link :href="route('debts.create')" class="btn btn-primary">+ Добавить</Link>
        </template>

        <IndexMobile :debts="debts" v-if="isMobile" />

        <IndexTable :debts="debts" v-else />
    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Card from "../../Shared/Card.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import {numberFormat} from "../../functions";
import Pagination from "../../Shared/Pagination.vue";
import Modal from "../../Shared/Modal.vue";
import IndexMobile from "./IndexMobile.vue";
import IndexTable from "./IndexTable.vue";

export default {
    components: {IndexTable, IndexMobile, Modal, Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['debts'],
    methods: {
        numberFormat
    },
}
</script>
