<template>
    <card class="mb-3">
        <div class="divide-y">
            <div v-for="debt in debts.data">
                <div class="row">
                    <div class="col">
                        <div class="text-truncate fw-bolder">
                            Долг №{{debt.id}}
                        </div>
                        <div class="fw-bold my-1">
                            Сумма: <span class="text-danger">{{numberFormat(debt.amount)}} сом.</span>
                        </div>

                        <div>
                            <a href="" @click.prevent="showMore(debt)">Подробнее</a>
                        </div>
                    </div>
                    <div class="col-auto fw-bold text-red d-flex flex-column justify-content-around">
                        <div>
                            <Link :href="route('debts.edit', debt.id)" class="btn btn-sm btn-outline-primary me-2">
                                Ред.
                            </Link>

                            <DeleteBtn
                                :url="route('debts.destroy', debt.id)"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template #cardFooter v-if="debts.links.length > 3">
            <Pagination class="float-end" :links="debts.links"/>
        </template>
    </card>

    <Modal
        :header-title="`Долг №${selectedDebt?.id}`"
        :visibility="showMoreContent"
        @close="showMoreContent = false"
    >
        <dl class="row">
            <dt class="col-12">Сумма долга:</dt>
            <dd class="col-12 text-danger mt-1">{{numberFormat(selectedDebt?.amount || 0, 2)}} сом.</dd>

            <dt class="col-12 mt-2">Комментарий:</dt>
            <dd class="col-12 text-muted mt-1">{{selectedDebt?.comment || '-'}}</dd>

            <dt class="col-12 mt-2">Дата создания:</dt>
            <dd class="col-12 mt-1">{{selectedDebt?.created_at_formatted}}</dd>
        </dl>
    </Modal>
</template>

<script>
import Card from "../../Shared/Card.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Pagination from "../../Shared/Pagination.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import Modal from "../../Shared/Modal.vue";
import {numberFormat} from "../../functions";

export default {
    name: "IndexMobile",
    props: ['debts'],
    components: {Modal, DeleteBtn, Pagination, Link, Card},
    data() {
        return {
            showMoreContent: false,
            selectedDebt: null
        }
    },
    methods: {
        numberFormat,
        showMore(debt) {
            this.showMoreContent = true
            this.selectedDebt = debt
        }
    },
}
</script>
