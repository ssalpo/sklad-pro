<template>
    <Modal :visibility="true"
           @close="form.reset()"
           :header-title="`Погашение по долгу №${debt?.id}`"
           v-bind="$attrs">

        <TextInput
            label="Сумма погашения"
            label-required
            placeholder="Введите сумму"
            @keydown.enter="submit"
            v-model="form.amount"
            :invalid-text="form.errors.amount"
        />

        <template #footer="{close}">
            <button @click="submit" class="btn btn-primary" data-bs-dismiss="modal">
                Добавить
            </button>

            <button type="button" @click="close" class="btn btn-link link-secondary ms-auto"
                    data-bs-dismiss="modal">
                Отменить
            </button>
        </template>
    </Modal>
</template>

<script>
import Modal from "../Modal.vue";
import TextInput from "./TextInput.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {useToast} from 'vue-toastification';

export default {
    name: "DebtPaymentModal",
    props: ['debt'],
    components: {TextInput, Modal},
    data() {
        return {
            form: useForm({
                amount: null
            })
        }
    },
    methods: {
        submit() {
            let vm = this;

            this.form
                .post(route('debts.payments.store', this.debt.id), {
                    onSuccess() {
                        vm.$emit('close')
                        vm.form.reset()
                    },
                    preserveScroll: true,
                    preserveState: true
                })
        }
    }
}
</script>
