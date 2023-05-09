<template>
    <PageWrapper
        header-title="Долги клиентов"
    >
        <template #headerActions>
            <Link :href="route('debts.create')" class="btn btn-primary">+ Добавить</Link>
        </template>

        <IndexMobile
            @debtSelect="onDebtSelect"
            :debts="debts"
            v-if="isMobile"
        />

        <IndexTable
            @debtSelect="onDebtSelect"
            :debts="debts" v-else
        />
    </PageWrapper>

    <DebtPaymentModal
        :debt="selectedDebt"
        :visibility="modalVisibility"
        @close="modalVisibility = false"
    />
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
import DebtPaymentModal from "../../Shared/Form/DebtPaymentModal.vue";

export default {
    components: {DebtPaymentModal, IndexTable, IndexMobile, Modal, Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['debts'],
    data() {
        return {
            selectedDebt: null,
            modalVisibility: false
        }
    },
    methods: {
        numberFormat,
        onDebtSelect(debt) {
            this.selectedDebt = debt
            this.modalVisibility = true;
        }
    },
}
</script>
