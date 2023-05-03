<template>
    <label class="form-label" :class="{required: labelRequired}" :for="`datepicker-${uid}`" v-if="label">{{ label }}</label>

    <input :id="`datepicker-${uid}`" v-bind="$attrs" :ref="uid" class="form-control" v-show="!inline" type="text"/>

    <div class="invalid-feedback-simple" v-if="invalidText && !withoutInvalidText">{{invalidText}}</div>
</template>

<script>
import Uuid from "../../Mixins/Uuid";
import AirDatepicker from 'air-datepicker'
import 'air-datepicker/air-datepicker.css'

let instance = null;

export default {
    name: "AirDatePicker",
    mixins: [Uuid],
    props: {
        label: String,
        labelRequired: Boolean,
        invalidText: String,
        withoutInvalidText: Boolean,
        modelValue: {
            type: [String, Number, Array, Object, Boolean],
        },
        monthPicker: Boolean,
        dateFormat: {
            type: String,
            default: 'dd-MM-yyyy'
        },
        options: {
            type: Object,
            default: {}
        },
        selectCurrentDate: Boolean,
        autoClose: {
            type: Boolean,
            default: true
        },
        asModal: {
            type: Boolean,
            default: false
        },
        range: Boolean,
        timepicker: Boolean,
        timepickerFormat: {
            type: String,
            default: 'hh:mm'
        },
        inline: Boolean,
        selectedDates: [Date, Array],
        disabledDates: Array,

        multipleDates: [Boolean, Number],
        multipleDatesSeparator: {
            type: String,
            default: ' - '
        }
    },
    mounted() {
        instance = new AirDatepicker(this.$refs[this.uid], this.defaultOptions())

        if(this.modelValue) {
            instance.selectDate(new Date(this.modelValue))
        }

        this.selectCurrentDefaultDate()
    },
    methods: {
        selectCurrentDefaultDate() {
            if (!this.selectCurrentDate) return

            instance.selectDate(new Date)
        },
        onSelect({date, formattedDate, datepicker}) {
            this.$emit('update:modelValue', formattedDate)
        },
        onRenderCell({date, cellType}) {
            if (cellType === 'day' && this.disabledDates) {
                if (this.disabledDates.filter(item => item.getTime() === date.getTime()).length > 0) {
                    return {disabled: true}
                }
            }
        },
        defaultOptions() {
            let options = {
                ...this.options,
                onSelect: this.onSelect,
                onRenderCell: this.onRenderCell,
                dateFormat: this.dateFormat,
                autoClose: this.autoClose,

                range: this.range,
                multipleDatesSeparator: this.multipleDatesSeparator,

                timepicker: this.timepicker,
                timepickerFormat: this.timepickerFormat,

                inline: this.inline,

                selectedDates: this.selectedDates,

                multipleDates: this.multipleDates
            }

            // Config for month picker
            if (this.monthPicker) {
                options = {
                    ...options,
                    view: 'months',
                    minView: 'months'
                }
            }

            if (this.asModal) {
                options = {
                    ...options,
                    isMobile: true,
                    autoClose: true
                }
            }

            return options
        }
    },
    destroyed() {
        if (!instance) return;

        instance.destroy();
    }
}
</script>
