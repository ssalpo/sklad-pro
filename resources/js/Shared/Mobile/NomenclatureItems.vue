<template>
    <div class="divide-y">
        <div v-for="item in items">
            <Link :href="route('nomenclatures.show', item.id)" class="text-decoration-none">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-truncate text-dark">
                            <strong>{{item.name}}</strong>
                        </div>
                        <div class="text-muted">
                            <small>Себестоимость: {{numberFormat(item.base_price)}} c.</small>
                        </div>
                    </div>
                    <div class="col-auto text-muted">
                        <span class="badge badge-outline text-green">
                            <small>{{numberFormat(item.price_for_sale)}} c.</small>
                        </span>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {numberFormat} from "../../functions";

export default {
    name: "NomenclatureItems",
    methods: {numberFormat},
    components: {Link},
    props: ['items']
}
</script>
