<template>
    <div class="card">
        <Link :href="route('companies.edit', company.id)" class="text-decoration-none">
            <div class="row align-items-center row-0">
                <div class="col-auto">
                    <img :src="company.logo_url || 'https://placehold.co/80'" class="rounded-start" alt="Shape of You" width="80" height="80">
                </div>

                <div class="col-auto col-md">
                    <div class="card-body text-dark">
                        {{company.name}}

                        <div class="d-block d-md-none text-dark">
                            Редактирование.
                        </div>


    <!--                    <div class="text-muted">
                            Muted text
                        </div>-->
                    </div>
                </div>

                <div class="d-none d-md-block col-md-auto px-3">
                    <Link :href="route('companies.edit', company.id)">
                        <IconPencil :size="24" stroke-width="2" />
                    </Link>
                </div>
            </div>
        </Link>
    </div>
</template>

<script>
import {IconPencil, IconPlus} from "@tabler/icons-vue"
import {Link} from "@inertiajs/inertia-vue3"
export default {
    components: {IconPlus, IconPencil, Link},
    props: {
        company: {
            type: Object,
            required: true
        }
    }
}
</script>
