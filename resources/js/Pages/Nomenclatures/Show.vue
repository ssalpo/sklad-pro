<template>
    <PageWrapper
        header-inline
        :header-title="`${nomenclature.name}`"
        :back-url="route('nomenclatures.index')"
    >
        <template #headerActions>
            <EditLinkBtn
                :url="route('nomenclatures.edit', nomenclature.id)"
            />

            <DeleteBtn
                :url="route('nomenclatures.destroy', nomenclature.id)"
            />
        </template>

        <card class="mb-3" without-body>
            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap card-table">
                    <tbody>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">ID</td>
                        <td>{{ nomenclature.id }}</td>
                    </tr>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">Название</td>
                        <td>{{ nomenclature.name }}</td>
                    </tr>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">Ед. измерения</td>
                        <td>{{ nomenclature.unit.name }}</td>
                    </tr>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">Себестомость</td>
                        <td>{{ numberFormat(nomenclature.base_price) }} с.</td>
                    </tr>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">Цена продажи</td>
                        <td>{{ numberFormat(nomenclature.price_for_sale) }} с.</td>
                    </tr>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">Дата создания</td>
                        <td>{{ nomenclature.created_at_formatted }}</td>
                    </tr>
                    <tr>
                        <td width="150" class="text-start text-sm-end fw-bold">Штрихкод</td>
                        <td>
                            <NomenclatureBarcodeChangeModal
                                btn-size="btn-sm px-2"
                                :nomenclature="nomenclature"
                                :btn-text="nomenclature.barcode"
                            />

                            <div class="mt-2">
                                <svg id="barcode"></svg>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </card>
    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Card from "../../Shared/Card.vue";
import {numberFormat} from "../../functions";
import EditLinkBtn from "../../Shared/EditLinkBtn.vue";
import DeleteBtn from "../../Shared/DeleteBtn.vue";
import NomenclatureBarcodeChangeModal from "../../Shared/Modals/NomenclatureBarcodeChangeModal.vue";
import JsBarcode from "jsbarcode";

export default {
    components: {NomenclatureBarcodeChangeModal, DeleteBtn, EditLinkBtn, Card, PageWrapper, Link},
    props: ['nomenclature'],
    methods: {
        numberFormat
    },
    mounted() {
        if (this.nomenclature?.barcode) {
            JsBarcode("#barcode", this.nomenclature?.barcode, {
                format: "CODE128",
                width: 2,
                height: 50,
                margin: 0,
                displayValue: false
            });
        }
    }
}
</script>
