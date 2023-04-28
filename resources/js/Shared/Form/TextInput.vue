<template>
    <label class="form-label" :for="uid" v-if="label">{{ label }}</label>
    <input type="text"
           :id="uid"
           v-bind="$attrs"
           @input="$emit('update:modelValue', $event.target.value)"
           :value="modelValue"
           class="form-control" :class="{'is-invalid': invalidText}" />

    <div class="invalid-feedback" v-if="invalidText">{{invalidText}}</div>
</template>

<script>
import Uuid from "../../Mixins/Uuid";
export default {
    mixins: [Uuid],
    props: {
        label: String,
        modelValue: [Number, String],
        invalidText: String
    }
}
</script>
