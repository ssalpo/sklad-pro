<template>
    <PageWrapper
        :header-title="!storehouse?.id ? `Новый склад` : `Редактирование ${storehouse.name}`"
    >
        <form @submit.prevent="submit">
            <card>
                <div class="col col-sm-6 offset-sm-3">
                    <TextInput
                        label="Название склада"
                        label-required
                        placeholder="Введите название склада"
                        v-model="form.name"
                        :invalid-text="form.errors.name"
                    />
                </div>

                <template #cardFooter>
                    <div class="col col-sm-6 offset-sm-3">
                        <button :disabled="form.processing" type="submit" class="btn btn-primary me-2">
                            {{storehouse?.id ? 'Изменить' : 'Добавить'}}
                        </button>
                        <Link :disabled="form.processing" :href="route('storehouses.index')" class="btn">Отменить</Link>
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

export default {
    components: {TextInput, Card, PageWrapper, Link},
    props: ['storehouse'],
    data() {
        return {
            form: useForm({
                name: this.storehouse?.name
            })
        }
    },
    methods: {
        submit() {
            if (!this.storehouse?.id) {
                this.form.post(route('storehouses.store'));
                return;
            }

            this.form.put(route('storehouses.update', this.storehouse.id))
        }
    }
}
</script>
