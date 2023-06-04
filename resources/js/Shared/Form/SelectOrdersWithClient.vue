<template>
    <CustomSelect
        ref="selectOrders"
        v-bind="$attrs"
        searchable
        prefetch
        remote
        :remote-url="route('autocomplete.orders_with_client')"
        full
        placeholder="Выберите заказ"
    />
</template>

<script>
import CustomSelect from "./CustomSelect.vue";

export default {
    name: "SelectOrdersWithClient",
    components: {CustomSelect},
    methods: {
        refreshData() {
            this.$refs.selectOrders.refreshData()
        }
    }
}
</script>
