<template>
    <fieldset class="form-fieldset">
<!--        <TomSelectNomenclatures
            :preload="false"
            :options="nomenclatures"
            :invalid-text="formData.errors['orderItems.' + currentIndex + '.nomenclature_id']"
            v-model="orderItem.nomenclature_id"
        />-->

        <TomSelect
            :preload="false"
            :options="nomenclatures"
            :invalid-text="formData.errors['orderItems.' + currentIndex + '.nomenclature_id']"
            v-model="orderItem.nomenclature_id"
        />

<!--        <select v-model="orderItem.nomenclature_id">
            <option :value="nomenclature.id" v-for="nomenclature in nomenclatures">{{nomenclature.text}}</option>
        </select>-->

        <div class="row mt-3">
            <div class="col-4">
                <NumericField
                    only-integer
                    placeholder="Кол-во"
                    :class="{'is-invalid': formData.errors['orderItems.' + currentIndex + '.quantity']}"
                    v-model="orderItem.quantity"
                />
            </div>

            <div class="col-6">
                <numeric-field
                    :precision="2"
                    placeholder="Сумма"
                    :class="{'is-invalid': formData.errors['orderItems.' + currentIndex + '.price_for_sale']}"
                    v-model="orderItem.price_for_sale"/>
            </div>

            <div class="col-2">
                <button type="button" class="btn btn-danger btn-icon"
                        @click="$emit('removeItem', currentIndex)">
                    <IconTrash :size="18" stroke-width="1.5"/>
                </button>
            </div>
        </div>

        <div v-if="formData.errors['orderItems.' + currentIndex + '.nomenclature_id'] || formData.errors['orderItems.' + currentIndex + '.quantity']">
            <div class="error invalid-feedback mt-2" style="display: block !important;">
                Заполните все поля корректно
            </div>
        </div>
    </fieldset>
</template>

<script>
import NumericField from "./NumericField.vue";
import {IconTrash} from "@tabler/icons-vue";
import TomSelectNomenclatures from "./TomSelectNomenclatures.vue";
import TomSelect from "./TomSelect.vue";

export default {
    name: "OrderNomenclatures",
    emits: ['removeItem'],
    components: {TomSelect, TomSelectNomenclatures, IconTrash, NumericField},
    props: {
        currentIndex: Number,
        formData: {
            type: Object,
            required: true
        },
        orderItem: {
            type: Object,
            required: true
        },
        nomenclatures: {
            type: Array,
            required: true
        },
        selectedNomenclatures: {
            type: Array,
            default: []
        }
    }
}
</script>
