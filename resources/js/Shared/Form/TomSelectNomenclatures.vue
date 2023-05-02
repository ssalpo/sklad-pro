<template>
    <TomSelect
        empty-label="Выберите номенклатуру"
        preload
        :searchable="false"
        :url="route('autocomplete.nomenclatures')"
        v-bind="$attrs"
    />
</template>

<script>
import TomSelect from "./TomSelect.vue";

export default {
    components: {TomSelect}
}
</script>
