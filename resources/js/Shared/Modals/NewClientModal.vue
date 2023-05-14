<template>
    <Modal
        ref="modal"
        header-title="Новый клиент"
        with-btn
    >
        <template #btn="{open}">
            <button type="button" @click="open" class="btn btn-link">
                + Новый клиент
            </button>
        </template>

        <div class="mb-3">
            <TextInput
                label="Имя"
                label-required
                placeholder="Введите имя"
                v-model="form.name"
                @keydown.enter="submit"
                :invalid-text="form.errors.get('name')"
            />
        </div>

        <TextInput
            label="Телефон"
            placeholder="Введите номер телефона"
            v-model="form.phone"
            @keydown.enter="submit"
            :invalid-text="form.errors.get('phone')"
        />

        <template #footer="{close}">
            <button @click="submit" class="btn btn-primary">
                Добавить
            </button>

            <button type="button" @click="close" class="btn btn-link link-secondary ms-auto">
                Отменить
            </button>
        </template>
    </Modal>
</template>

<script>
import Modal from "../Modal.vue";
import TextInput from "../Form/TextInput.vue";
import Form from 'vform'
import {useToast} from "vue-toastification";

export default {
    emits: ['success'],
    name: "NewClientModal",
    components: {TextInput, Modal},
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
                const {data} = await this.form.post(route('clients.store', {modal: 1}))

                this.$emit('success', data)

                this.form.reset()

                this.$refs.modal.close()
            } catch (e) {
                useToast().error('Ошибка добавления нового клиента.')
            }
        }
    }
}
</script>
