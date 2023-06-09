<template>
    <BsModal
        ref="scannerModal"
        @show="initCodeReader = true"
        @hidden="initCodeReader = false"
        with-btn centered
        title="Сканер"
    >
        <template #btn="{show}">
            <button type="button" @click="show" class="btn btn-icon main-barcode-btn"
                    :class="[btnClass, btnPositionedAbsolute ? 'btn-default btn-link position-absolute' : 'btn-outline-primary']">
                <IconBarcode :size="iconSize" stroke-width="1.5" />

                <span v-if="iconText" class="ms-1">Сканер</span>
            </button>
        </template>

        <BarcodeReader
            :visible="initCodeReader"
            @detected="onDetect"
        />
    </BsModal>
</template>

<script>
import BsModal from "../BsModal.vue";
import BarcodeReader from "../BarcodeReader.vue";
import {IconBarcode} from "@tabler/icons-vue";

export default {
    emits: ['detected'],
    name: "BarcodeScannerModal",
    components: {IconBarcode, BarcodeReader, BsModal},
    props: {
        btnClass: String,
        iconText: {
            type: Boolean,
            default: false
        },
        iconSize: {
            type: Number,
            default: 18
        },
        btnPositionedAbsolute: Boolean
    },
    data() {
        return {
            initCodeReader: false
        }
    },
    methods: {
        onDetect(code) {
            this.$emit('detected', code);
            this.$refs.scannerModal.hide();
            this.initCodeReader = false;
        }
    }
}
</script>

<style scoped>
    .main-barcode-btn {
        right: 15px
    }
</style>
