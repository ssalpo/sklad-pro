<template>
    <Modal
        ref="cancelModal"
        :header-title="`Отмена заказа №${order.id}`"
        with-btn
        btn-text="Отменить"
        :visibility="modalVisibility"
        btn-class="btn btn-danger"
    >
        <TextInput
            label="Причина отмены"
            label-required
            placeholder="Введите причину отмены"
            v-model="form.cancel_reason"
            @keydown.enter="submit"
            :invalid-text="form.errors.cancel_reason"
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
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "OrderCancelModal",
    components: {TextInput, Modal},
    props: {
        modalVisibility: false,
        order: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            form: useForm({
                cancel_reason: null
            })
        }
    },
    methods: {
        submit() {
            let vm = this;

            this.form.post(route('orders.cancel', this.order.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess() {
                    vm.$refs.cancelModal.close();
                }
            })

        }
    }
}
</script>
