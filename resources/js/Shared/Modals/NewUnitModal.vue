<template>
    <BsModal
        ref="modal"
        title="Новая единица измерения"
        with-btn
        centered
        @hidden="form.reset()"
        @submit="submit"
    >
        <template #btn="{show}">
            <div class="mt-2">
                <button type="button" @click="show" class="btn btn-sm btn-link">
                    <IconCirclePlus :size="18" class="me-1" stroke-width="1" />
                    Новая единица измерения
                </button>
            </div>
        </template>

        <div class="mb-3">
            <TextInput
                label="Название"
                label-required
                placeholder="Введите название"
                v-model="form.name"
                :invalid-text="form.errors.get('name')"
            />
        </div>

        <template #footer="{hide}">
            <button class="btn btn-primary" :disabled="form.busy">
                Добавить
            </button>

            <button type="button" @click="hide" class="btn btn-link link-secondary ms-auto">
                Отменить
            </button>
        </template>
    </BsModal>
</template>

<script>
import TextInput from "../Form/TextInput.vue";
import Form from 'vform'
import {useToast} from "vue-toastification";
import BsModal from "../BsModal.vue";
import {IconCirclePlus} from "@tabler/icons-vue";

export default {
    emits: ['success'],
    name: "NewUnitModal",
    components: {IconCirclePlus, BsModal, TextInput},
    data() {
        return {
            form: new Form({
                name: null
            })
        }
    },
    methods: {
        async submit() {
            try {
                const {data} = await this.form.post(route('units.store', {modal: 1}))

                this.$emit('success', data)

                this.form.reset()

                this.$refs.modal.hide()

                useToast().success('Единица измерения успешно добавлена.')
            } catch (e) {
                useToast().error('Ошибка добавления единицы измерения.')
            }
        }
    }
}
</script>
