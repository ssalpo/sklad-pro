<template>
    <PageWrapper
        :header-title="!debt?.id ? `Новый долг` : `Редактирование долга №${debt.id}`"
    >
        <form @submit.prevent="submit">
            <card>
                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <SelectOrdersWithClient
                        @selected="onOrderSelected"
                        v-model="form.order_id"
                        :invalid-text="form.errors.order_id"
                        label="Заказ"
                        label-required
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <NumericField
                        label="Сумма долга"
                        label-required
                        placeholder="Введите сумму долга"
                        v-model="form.amount"
                        :invalid-text="form.errors.amount || amountValidation"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <TextInput
                        label="Комментарий"
                        placeholder="Введите комментарий"
                        v-model="form.comment"
                        :invalid-text="form.errors.comment"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3" v-if="!clientSetFromOrder">
                    <SelectClients
                        ref="selectClients"
                        v-model="form.client_id"
                        :invalid-text="form.errors.client_id"
                        label="Клиент"
                        label-required
                    />

                    <NewClientModal @success="setClient"/>
                </div>

                <template #cardFooter>
                    <div class="col col-sm-6 offset-sm-3">
                        <button :disabled="form.processing" type="submit" class="btn btn-primary me-2">
                            {{ debt?.id ? 'Изменить' : 'Добавить' }}
                        </button>
                        <Link :disabled="form.processing" :href="route('debts.index')" class="btn">Отменить</Link>
                    </div>
                </template>
            </card>
        </form>
    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import Card from "../../Shared/Card.vue";
import TextInput from "../../Shared/Form/TextInput.vue";
import {useForm, Link} from "@inertiajs/inertia-vue3";
import NumericField from "../../Shared/Form/NumericField.vue";
import SelectClients from "../../Shared/Form/SelectClients.vue";
import NewClientModal from "../../Shared/Modals/NewClientModal.vue";
import SelectOrdersWithClient from "../../Shared/Form/SelectOrdersWithClient.vue";
import {numberFormat} from "../../functions";

export default {
    components: {
        SelectOrdersWithClient,
        NewClientModal,
        SelectClients,
        NumericField,
        TextInput,
        Card,
        PageWrapper,
        Link
    },
    props: ['debt'],
    data() {
        return {
            selectedOrder: null,
            clientSetFromOrder: false,
            form: useForm({
                order_id: this.debt?.order_id,
                client_id: this.debt?.client_id,
                amount: this.debt?.amount,
                comment: this.debt?.comment
            })
        }
    },
    methods: {
        numberFormat,
        submit() {
            if (!this.debt?.id) {
                this.form.post(route('debts.store'));
                return;
            }

            this.form.put(route('debts.update', this.debt.id))
        },
        setClient(client) {
            this.$refs.selectClients.refreshData()

            this.form.client_id = parseInt(client.id)

            this.form.clearErrors()
        },
        onOrderSelected(order) {
            this.selectedOrder = order
            this.clientSetFromOrder = order.client_id !== null
            this.form.client_id = order.client_id
        }
    },
    computed: {
        amountValidation() {
            if(this.selectedOrder?.amount && this.selectedOrder.amount < this.form.amount) {
                return `Сумма долга должно быть меньше или равно сумме заказа (${numberFormat(this.selectedOrder.amount)} c.)`
            }

            return null;
        }
    },
    watch: {
        ['form.order_id'](val) {
            if (val === null) {
                if (this.clientSetFromOrder && this.form.client_id) this.form.client_id = null

                this.clientSetFromOrder = false
            }
        }
    }
}
</script>
