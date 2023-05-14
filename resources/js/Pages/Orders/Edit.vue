<template>
    <PageWrapper
        header-title="Новая продажа"
    >
        <form @submit.prevent="submit">
            <card>
                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <SelectClients
                        ref="selectClients"
                        v-model="form.client_id"
                        :invalid-text="form.errors.client_id"
                        label="Клиент"
                    />

                    <NewClientModal @success="setClient" />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3" v-if="showcasesCount > 1">
                    <SelectShowcases
                        v-model="form.showcase_id"
                        label-required
                        :invalid-text="form.errors.showcase_id"
                        label="Витрина"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <label class="form-label required">Товары</label>

                    <OrderNomenclatures
                        :class="{'mb-2': form.orderItems.length > index + 1}"
                        v-for="(orderItem, index) in form.orderItems"
                        :nomenclatures="nomenclatures"
                        :selected-nomenclatures="selectedNomenclatures"
                        :currentIndex="index"
                        :key="index"
                        :orderItem="orderItem"
                        @removeItem="removeOrderItem"
                        :form-data="form"
                    />

                    <div class="invalid-feedback-simple" v-if="form.errors.orderItems">
                        {{form.errors.orderItems}}
                    </div>

                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <button type="button" v-if="this.canAddNomenclature" @click="addOrderItem" class="btn btn-sm btn-outline-success">
                                <IconPlus :size="14" stroke-width="2" /> Добавить товар
                            </button>
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0" v-if="this.form.orderItems.length > 0">
                            Итого: {{ numberFormat(totalSum, 2) }} сом.
                        </div>
                    </div>
                </div>

                <template #cardFooter>
                    <div class="col col-sm-6 offset-sm-3">
                        <button :disabled="form.processing" type="submit" class="btn btn-primary me-2">
                            Добавить
                        </button>
                        <Link :disabled="form.processing" :href="route('orders.index')" class="btn">
                            Отменить
                        </Link>
                    </div>
                </template>
            </card>
        </form>
    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue"
import Card from "../../Shared/Card.vue"
import TextInput from "../../Shared/Form/TextInput.vue"
import {useForm, Link} from "@inertiajs/inertia-vue3"
import NumericField from "../../Shared/Form/NumericField.vue"
import {IconPlus} from "@tabler/icons-vue"
import keyBy from "lodash/keyBy";
import compact from "lodash/compact";
import map from "lodash/map";
import {numberFormat} from "../../functions";
import SelectClients from "../../Shared/Form/SelectClients.vue";
import OrderNomenclatures from "../../Shared/Form/OrderNomenclatures.vue";
import SelectShowcases from "../../Shared/Form/SelectShowcases.vue";
import NewClientModal from "../../Shared/Modals/NewClientModal.vue";

export default {
    props: ['nomenclatures', 'showcasesCount', 'lastSelectedShowcase'],
    components: {
        NewClientModal,
        SelectShowcases,
        OrderNomenclatures,
        SelectClients,
        NumericField,
        TextInput,
        Card,
        PageWrapper,
        Link,
        IconPlus
    },
    data() {
        return {
            form: useForm({
                showcase_id: this.lastSelectedShowcase,
                client_id: null,
                orderItems: [
                    {nomenclature_id: null, quantity: null, price_for_sale: null}
                ]
            })
        }
    },
    computed: {
        totalSum() {
            return this.form.orderItems.reduce((a, e) => {
                if (!e.nomenclature_id) return a;

                return a + (e.price_for_sale * parseInt(e.quantity) || 0);
            }, 0)
        },
        groupedNomenclatures() {
            return keyBy(this.nomenclatures, 'id')
        },
        selectedNomenclatures() {
            return compact(map(this.form.orderItems, 'nomenclature_id'))
        },
        canAddNomenclature() {
            return this.nomenclatures.length > this.form.orderItems.length;
        }
    },
    methods: {
        numberFormat,
        submit() {
            this.form.post(route('orders.store'))
        },
        addOrderItem() {
            if (!this.canAddNomenclature) return;

            this.form.orderItems.push({nomenclature_id: null, quantity: null, price_for_sale: null})
        },
        removeOrderItem(index) {
            this.form.orderItems.splice(index, 1)
        },
        setClient(client) {
            this.$refs.selectClients.refreshData();

            this.form.client_id = parseInt(client.id)
        }
    }
}
</script>
