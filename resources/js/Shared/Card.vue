<template>
    <div class="card">
        <div class="card-header" v-if="$slots.cardTitle || cardTitle">
            <slot v-if="!cardTitle" name="cardTitle"/>

            <h3 v-else class="card-title">{{ cardTitle }}</h3>
        </div>
        <div class="card-body">
            <slot/>
        </div>
        <div class="card-footer" v-if="$slots.cardFooter">
            <slot name="cardFooter"/>
        </div>
    </div>
</template>

<script>
import {IconPlus} from "@tabler/icons-vue"
import {Link} from "@inertiajs/inertia-vue3"

export default {
    components: {IconPlus, Link},
    props: {
        cardTitle: String
    }
}
</script>
