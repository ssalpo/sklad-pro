<template>
    <Modal
        with-btn
        header-title="Фильтрация"
        @submit="submit"
    >
        <template #btn="{open}">
            <button class="btn btn-primary px-2" @click="open">
                <IconFilter :size="18" stroke-width="1.5"/>

                <span class="d-none d-sm-block">Фильтр</span>
            </button>
        </template>

        <div class="input-group mb-3">
            <AirDatePicker
                :as-modal="isMobile"
                v-model="form.start"
                placeholder="Дата начала"
            />
            <span class="input-group-text">-</span>
            <AirDatePicker
                :as-modal="isMobile"
                v-model="form.end"
                placeholder="Дата конечная"
            />
        </div>

        <SelectShowcases
            auto-position
            v-model="form.showcase"
            :invalid-text="form.errors.showcase"
        />

        <template #footer="{submit, close}">
            <button @click="submit" class="btn btn-primary">
                Найти
            </button>

            <Link v-if="isFiltered" :href="route('dashboard.index')" class="btn btn-danger px-2 ms-auto">
                <IconX size="20" stroke-width="2"/>
            </Link>

            <button v-else type="button" @click="close" class="btn btn-link link-secondary ms-auto">
                Отменить
            </button>
        </template>
    </Modal>
</template>

<script>
import Card from "../../Shared/Card.vue";
import AirDatePicker from "../../Shared/Form/AirDatePicker.vue";
import {useForm, Link} from "@inertiajs/inertia-vue3";
import queryString from 'query-string';
import {IconFilter, IconSearch, IconX} from "@tabler/icons-vue"
import {size} from "lodash/collection";
import Modal from "../../Shared/Modal.vue";
import SelectShowcases from "../../Shared/Form/SelectShowcases.vue";

export default {
    name: "DashboardFilters",
    components: {SelectShowcases, IconFilter, Modal, AirDatePicker, Card, IconSearch, IconX, Link},
    data() {
        return {
            isFiltered: false,
            form: useForm({
                start: null,
                end: null,
                showcase: null
            })
        }
    },
    created() {
        this.loadDefaultParams()
    },
    methods: {
        loadDefaultParams() {
            let params = queryString.parse(location.search);

            this.isFiltered = size(params) > 0

            this.form.start = params['start']
            this.form.end = params['end']
            this.form.showcase = params['showcase'] ? parseInt(params['showcase']) : null
        },
        submit() {
            this.form.get(route('dashboard.index'))
        }
    }
}
</script>
