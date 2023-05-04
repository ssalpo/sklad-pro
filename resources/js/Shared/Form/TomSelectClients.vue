<template>
    <TomSelect
        empty-label="Выберите клиента"
        placeholder="Выберите клиента"
        preload
        :url="route('autocomplete.clients')"
        v-bind="$attrs"
    />
</template>

<script>
import TomSelect from "./TomSelect.vue";
export default {
    components: {TomSelect}
}
</script>
