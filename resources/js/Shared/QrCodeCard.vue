<template>
    <div class="card">
        <div class="row align-items-center row-0">
            <div class="col-sm-auto col-md">
                <div class="card-body text-dark">
                    <h3>{{ company.name }}</h3>

                    <div class="text-info cursor-pointer">
                        <IconCopy :size="20" stroke-width="1.8"/> {{route('companies.edit', company.id)}}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-auto px-3 pb-3 pb-sm-3 pb-md-0">
                <div class="dropdown">
                    <a href="#" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Макеты</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Скачать QR-код</a>
                        <a class="dropdown-item" href="#">Скачать макет наклейки</a>
                        <a class="dropdown-item" href="#">Скачать макет A6</a>
                        <a class="dropdown-item" href="#">Наклейка на вход</a>
                        <a class="dropdown-item" href="#">Картинка для соц. сети</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {IconCopy} from "@tabler/icons-vue"
import {Link} from "@inertiajs/inertia-vue3"

export default {
    components: {IconCopy, Link},
    props: {
        company: {
            type: Object,
            required: true
        }
    }
}
</script>
