<template>
    <button v-if="type === 'navbar'" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-nav flex-row order-md-last" v-if="type === 'navbar'">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
                <span class="avatar avatar-sm">СС</span>
                <div class="d-none d-xl-block ps-2">
                    <div>Санжар Султонов</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="" class="dropdown-item">Выйти</a>
            </div>
        </div>
    </div>

    <a href="#" v-if="type === 'sidebar'" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
        <span class="avatar avatar-sm" ></span>
        <div class="d-none d-xl-block ps-2">
            <div>Paweł Kuna</div>
            <div class="mt-1 small text-muted">UI Designer</div>
        </div>
    </a>

    <div v-if="type === 'sidebar'" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <a href="" class="dropdown-item">Выйти</a>
    </div>
</template>

<script>
export default {
    props: {
        type: String
    }
}
</script>
