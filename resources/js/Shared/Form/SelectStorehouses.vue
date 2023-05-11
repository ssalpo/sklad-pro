<template>
    <CustomSelect
        v-bind="$attrs"
        searchable
        prefetch
        remote
        :remote-url="route('autocomplete.storehouses')"
        full
        placeholder="Выберите склад"
    />
</template>

<script>
import CustomSelect from "./CustomSelect.vue";
export default {
    name: "SelectStorehouses",
    components: {CustomSelect}
}
</script>
