<template>
    <label class="form-label" :class="{required: labelRequired}" :for="uid" v-if="label">{{ label }}</label>

    <div v-bind="$attrs"
         class="dropdown d-block custom-select-wrapper"
         :class="{'full-width': full, 'is-invalid': invalidText}"
    >

        <button :class="['btn dropdown-toggle custom-select-btn', btnClass]"
                type="button"
                :id="`dropdownMenuButton${uid}`"
                data-bs-toggle="dropdown"
                aria-expanded="false"
        >
            <span v-if="selected">{{ selected }}</span>
            <span v-if="!selected && placeholder" class="text-muted">{{ placeholder }}</span>
        </button>

        <!-- Dropdown wrapper -->
        <div class="dropdown-menu" :aria-labelledby="`dropdownMenuButton${uid}`">
            <!-- Search Input -->

            <div class="custom-select-search-input" v-if="searchable">
                <input type="text"
                       @keyup="onSearch"
                       ref="searchInput"
                       class="form-control"
                       placeholder="Найти"
                />
            </div>

            <!-- Not found text -->
            <a class="dropdown-item disabled"
               v-if="!listOptions.length"
               href="javascript:void(0)">
                Ничего не найдено
            </a>

            <!-- List Item -->
            <a class="dropdown-item"
               href="javascript:void(0)"
               v-for="option in listOptions"
               :class="activeStateClasses(option)"
               @click.prevent="onChange(option)"
            >
                {{ option.text }}
            </a>
        </div>
    </div>

    <div class="invalid-feedback" v-if="invalidText && !withoutInvalidText">{{invalidText}}</div>
</template>

<script>
import find from "lodash/find";
import get from "lodash/get";
import debounce from "lodash/debounce";
import Uuid from "../../Mixins/Uuid";

export default {
    mixins: [Uuid],
    props: {
        label: String,
        labelRequired: Boolean,
        invalidText: String,
        withoutInvalidText: Boolean,

        searchable: Boolean,
        full: Boolean,
        prefetch: Boolean,
        remote: Boolean,
        remoteUrl: String,
        disabledValues: {
            type: Array,
            default: []
        },
        btnClass: {
            type: String,
            default: 'btn-default'
        },
        placeholder: {
            type: String,
            default: null
        },
        options: {
            type: Array,
            default: []
        },
        modelValue: {
            type: [String, Number],
            default: null
        }
    },
    data() {
        return {
            listOptions: this.options,
            searchQuery: '',
            selected: null
        }
    },
    created() {
        this.prefetchData()
    },
    methods: {
        onSearch: debounce(function (e) {
            this.searchQuery = e.target.value

            this.getData();
        }, 300),
        prefetchData() {
            if(!this.prefetch) return

            this.getData()
        },
        getData() {
            if (this.remote && this.remoteUrl) {
                axios.get(this.remoteUrl + `?q=${this.searchQuery}`)
                    .then((r) => {
                        this.listOptions = r.data

                        if (this.modelValue) {
                            this.setSelected(this.modelValue)
                        }
                    })

                return
            }

            const regex = new RegExp(this.searchQuery, 'ig')

            this.listOptions = this.options.filter(e => regex.test(e.text))
        },
        onChange(option) {
            this.clearSearchQuery()

            console.log(this.modelValue !== option.id ? option.id : null)

            this.$emit('update:modelValue', this.modelValue !== option.id ? option.id : null)
        },
        clearSearchQuery() {
            if (!this.searchable) return

            this.$refs.searchInput.value = this.searchQuery = '';
        },
        isDisabled(option) {
            let disabledValues = this.disabledValues.filter(item => item !== this.modelValue)

            return disabledValues.includes(option.id)
        },
        isActive(option) {
            return option.id === this.modelValue
        },
        activeStateClasses(option) {
            return {
                disabled: this.isDisabled(option),
                active: this.isActive(option)
            }
        },
        findLabel(v) {
            return get(find(this.listOptions, ['id', v]), 'text')
        },
        setSelected(v) {
            this.selected = this.findLabel(v)
        }
    },
    watch: {
        modelValue: {
            immediate: true,
            handler: function (v) {
                this.setSelected(v)
            }
        }
    }
}
</script>

<style scoped>
.custom-select-wrapper.full-width,
.custom-select-wrapper.full-width .custom-select-btn,
.custom-select-wrapper.full-width .dropdown-menu {
    width: 100%;
}

.custom-select-wrapper.is-invalid .custom-select-btn {
    border-color: #dc3545;
    /*padding-right: 2.25rem!important;*/
    /*background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");*/
    /*background-repeat: no-repeat;*/
    /*background-position: right calc(0.375em + 0.1875rem) center;*/
    /*background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);*/
}

.custom-select-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dropdown-menu {
    overflow-y: auto;
    max-height: 240px;
    min-width: 210px;
    padding: 0;
}


.custom-select-search-input input:focus {
    box-shadow: none;
}

.custom-select-search-input input {
    border-radius: 0;
    border-color: #fff;
    border-bottom: var(--tblr-border-width) solid var(--tblr-border-color);
    width: 100%;
}
</style>