<template>
    <label class="form-label" :class="{required: labelRequired}" v-if="label">{{ label }}</label>

    <select :ref="`tomSelect${uid}`" v-bind="$attrs"></select>

    <div class="invalid-feedback-simple" v-if="invalidText && !withoutInvalidText">{{invalidText}}</div>
</template>

<script>
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.bootstrap5.min.css";
import Uuid from "../../Mixins/Uuid";

export default {
    mixins: [Uuid],
    props: {
        label: String,
        labelRequired: Boolean,
        invalidText: String,
        withoutInvalidText: Boolean,
        url: String,
        emptyLabel: String,
        modelValue: [Number, String],
        config: {
            type: Object,
            default: {}
        },
        searchable: {
            type: Boolean,
            default: true
        },
        options: {
            type: Array,
            default: []
        },
        preload: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            instance: null
        }
    },
    mounted() {
        let vm = this

        const options = {
            ...this.config,
            options: JSON.parse(JSON.stringify(this.options)),
            preload: this.preload,
            loadThrottle: 300,
            allowEmptyOption: true,
            plugins: ['clear_button'],
            onChange: (value) => {
                vm.$emit('update:modelValue', value)
            },
            load(query, callback) {
                if (vm.preload && !vm.url) {
                    alert('Please enter "url" property.');

                    return;
                }

                if (vm.preload && vm.url) {
                    axios.get(vm.url + `?q=${query}`)
                        .then((r) => {
                            callback(vm.emptyLabel ? [{value: "", text: vm.emptyLabel}, ...r.data] : r.data)

                            if (vm.modelValue) {
                                vm.instance.setValue(vm.modelValue)
                            }
                        })
                }
            }
        }

        if (!this.searchable) {
            options['controlInput'] = null;
        }

        this.instance = new TomSelect(this.$refs[`tomSelect${this.uid}`], options)

        this.instance.setValue(this.modelValue)
    },
    watch: {
        modelValue: {
            handler: function (v) {
                this.instance.setValue(v)
            }
        },
        options: {
            deep: true,
            handler: function (options) {
                this.instance.addOptions(options)
                this.instance.setValue(this.modelValue)
            }
        },
    },
    destroyed() {
        this.instance?.destroy();
    }
}
</script>
