<template>
    <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <h1 class="navbar-brand navbar-brand-autodark">
                <a href="">
                    <img src="../../img/logo-white.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>

            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item dropdown">
                    <UserDropdown v-if="$page.props.shared.isAuth" type="sidebar"/>
                </div>
            </div>

            <div class="navbar-collapse collapse" id="sidebar-menu" style="">
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconBlockquote :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                Отзывы
                            </span>
                        </a>

                        <a class="nav-link" href="">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconMessage :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                Диалоги
                            </span>
                        </a>

                        <Link class="nav-link"
                              :class="{ active : $page.url.startsWith('/companies') }"
                              :href="route('companies.index')">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconBuildingSkyscraper :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                Мои компании
                            </span>
                        </Link>

                        <Link class="nav-link"
                              :href="route('qr-codes.index')"
                              :class="{ active : $page.url.startsWith('/qr-codes') }"
                        >
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconQrcode :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                QR-коды и ссылки
                            </span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<script>
import {
    IconHome,
    IconBlockquote,
    IconMessage,
    IconBuildingSkyscraper,
    IconQrcode,
} from "@tabler/icons-vue"
import UserDropdown from "./UserDropdown.vue"
import {Link} from "@inertiajs/inertia-vue3"

export default {
    components: {
        UserDropdown,
        IconHome,
        IconBlockquote,
        IconMessage,
        IconBuildingSkyscraper,
        IconQrcode,
        Link
    }
}
</script>
