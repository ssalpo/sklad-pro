<template>
    <PageWrapper
        header-title="Долги клиентов"
    >
        <template #headerActions>
            <Link :href="route('debts.create')" class="btn btn-primary">+ Добавить</Link>
        </template>

        <card v-if="isMobile" class="mb-3">
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
                            <div class="text-muted">
                                {{debt.created_at_formatted}}
                            </div>
                            <div class="text-muted" v-if="debt.comment">{{debt.comment}}</div>
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

                            <div>
                                <a href="" @click.prevent="showMore(debt)">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <template #cardFooter v-if="debts.links.length > 3">
                <Pagination class="float-end" :links="debts.links"/>
            </template>
        </card>

        <card v-else without-body>
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

        <Modal
            :header-title="`Долг №${selectedDebt?.id}`"
            :visibility="showMoreContent"
            @close="showMoreContent = false"
        >
            <dl class="row">
                <dt class="col-5">Сумма долга:</dt>
                <dd class="col-7 text-danger">{{numberFormat(selectedDebt?.amount || 0, 2)}} сом.</dd>

                <dt class="col-5">Комментарий:</dt>
                <dd class="col-7 text-muted">{{selectedDebt?.comment || '-'}}</dd>

                <dt class="col-5">Дата создания:</dt>
                <dd class="col-7">{{selectedDebt?.created_at_formatted}}</dd>
            </dl>
        </Modal>
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

export default {
    components: {Modal, Pagination, DeleteBtn, Card, PageWrapper, Link},
    props: ['debts'],
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
