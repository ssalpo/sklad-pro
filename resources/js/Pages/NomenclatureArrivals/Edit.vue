<template>
    <PageWrapper
        :header-title="!nomenclatureArrival?.id ? `Новый приход` : `Редактирование`"
    >
        <form @submit.prevent="submit">
            <card>
                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <TomSelectNomenclatures
                        label="Номенклатура"
                        label-required
                        :invalid-text="form.errors.nomenclature_id"
                        v-model="form.nomenclature_id"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <NumericField
                        v-model="form.quantity"
                        label="Кол-во"
                        label-required
                        :invalid-text="form.errors.quantity"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <NumericField
                        v-model="form.base_price"
                        label="Себестоимость"
                        label-required
                        placeholder="Введите сумму себестоимости"
                        :invalid-text="form.errors.base_price"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <NumericField
                        v-model="form.price_for_sale"
                        label="Цена продажи"
                        label-required
                        placeholder="Введите цену продажи"
                        :invalid-text="form.errors.price_for_sale"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <TextInput
                        label="Комментарий"
                        placeholder="Введите комментарий к приходу"
                        v-model="form.comment"
                        :invalid-text="form.errors.comment"
                    />
                </div>

                <div class="col col-sm-6 offset-sm-3 mb-3">
                    <AirDatePicker
                        label="Дата прихода"
                        placeholder="Выберите дату прихода"
                        :invalid-text="form.errors.arrival_at"
                        timepicker
                        v-model="form.arrival_at"
                    />
                </div>

                <template #cardFooter>
                    <div class="col col-sm-6 offset-sm-3">
                        <button :disabled="form.processing" type="submit" class="btn btn-primary me-2">
                            {{nomenclatureArrival?.id ? 'Изменить' : 'Добавить'}}
                        </button>
                        <Link :disabled="form.processing" :href="route('nomenclature-arrivals.index')" class="btn">Отменить</Link>
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
import TomSelectNomenclatures from "../../Shared/Form/TomSelectNomenclatures.vue";
import NumericField from "../../Shared/Form/NumericField.vue";
import AirDatePicker from "../../Shared/Form/AirDatePicker.vue";

export default {
    components: {AirDatePicker, NumericField, TomSelectNomenclatures, TextInput, Card, PageWrapper, Link},
    props: ['nomenclatureArrival'],
    data() {
        return {
            form: useForm({
                nomenclature_id: this.nomenclatureArrival?.nomenclature_id || "",
                quantity: this.nomenclatureArrival?.quantity,
                name: this.nomenclatureArrival?.name,
                base_price: this.nomenclatureArrival?.base_price,
                price_for_sale: this.nomenclatureArrival?.price_for_sale,
                comment: this.nomenclatureArrival?.comment,
                arrival_at: this.nomenclatureArrival?.arrival_at,
            })
        }
    },
    methods: {
        submit() {
            if (!this.nomenclatureArrival?.id) {
                this.form.post(route('nomenclature-arrivals.store'));
                return;
            }

            this.form.put(route('nomenclature-arrivals.update', this.nomenclatureArrival.id))
        }
    }
}
</script>
