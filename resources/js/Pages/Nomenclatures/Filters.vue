<template>
    <form class="row" @submit.prevent="submit">
        <div class="col-sm-6 position-relative" :class="[isFiltered ? 'col-8' : 'col-10']">
            <BarcodeScannerModal
                @detected="onDetectedBarcode"
                btn-positioned-absolute />

            <TextInput
                placeholder="Название номенклатуры, штрихкод"
                v-model="form.query"
            />
        </div>
        <div class="col-sm-6" :class="[isFiltered ? 'col-4' : 'col-2']">
            <button :disabled="form.processing" class="btn btn-primary btn-icon">
                <IconSearch size="16" stroke-width="3"/>
            </button>

            <Link v-if="isFiltered" :href="route('nomenclatures.index')" class="btn btn-danger btn-icon ms-2">
                <IconX size="16" stroke-width="2"/>
            </Link>
        </div>
    </form>
</template>

<script>
import TextInput from "../../Shared/Form/TextInput.vue";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import queryString from "query-string";
import {size} from "lodash/collection";
import {IconX, IconSearch} from "@tabler/icons-vue";
import BarcodeScannerModal from "../../Shared/Modals/BarcodeScannerModal.vue";

export default {
    name: "NomenclatureFilters",
    components: {BarcodeScannerModal, IconX, Link, TextInput, IconSearch},
    data() {
        return {
            isFiltered: false,
            form: useForm({
                query: null,
            }),
        }
    },
    created() {
        this.loadDefaultParams()
    },
    methods: {
        loadDefaultParams() {
            let params = queryString.parse(location.search);

            this.isFiltered = size(params) > 0

            this.form.query = params['query']
        },
        submit() {
            this.form.get(route('nomenclatures.index'))
        },
        onDetectedBarcode(code) {
            this.form.query = code

            this.submit();
        }
    }
}
</script>
