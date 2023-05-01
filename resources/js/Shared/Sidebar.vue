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
                        <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown"
                           data-bs-auto-close="false" role="button" aria-expanded="true">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconChartHistogram :size="24" stroke-width="1.5"/>
                              </span>

                            <span class="nav-link-title">
                                Аналитика
                              </span>
                        </a>

                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="#">
                                        Общая
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        За период
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconListDetails :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                Продажи
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconCalculator :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                Остатки
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconBusinessplan :size="24" stroke-width="1.5"/>
                            </span>

                            <span class="nav-link-title">
                                Долги клиентов
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown"
                           data-bs-auto-close="false" role="button" aria-expanded="true">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconBuildingStore :size="24" stroke-width="1.5"/>
                              </span>

                            <span class="nav-link-title">
                                Склад
                              </span>
                        </a>

                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="#">
                                        Приход
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        Списание
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        Инвентаризация
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item" :class="{active: directoriesIsActive}">
                        <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown"
                           data-bs-auto-close="false" role="button" aria-expanded="true">
                              <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconList :size="24" stroke-width="1.5"/>
                              </span>

                            <span class="nav-link-title">
                                Справочники
                              </span>
                        </a>

                        <div class="dropdown-menu" :class="{show: directoriesIsActive}">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="#">
                                        Клиенты
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        Номенклатура
                                    </a>
                                    <Link class="dropdown-item"
                                          :class="{active: $page.component.startsWith('Showcases')}"
                                          :href="route('showcases.index')">
                                        Витрины
                                    </Link>
                                    <a class="dropdown-item" href="#">
                                        Пользователи
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<script>
import {
    IconChartHistogram,
    IconListDetails,
    IconCalculator,
    IconBuildingStore,
    IconList,
    IconBusinessplan,
} from "@tabler/icons-vue"
import UserDropdown from "./UserDropdown.vue"
import {Link} from "@inertiajs/inertia-vue3"

export default {
    components: {
        Link,
        UserDropdown,
        IconList,
        IconChartHistogram,
        IconListDetails,
        IconCalculator,
        IconBuildingStore,
        IconBusinessplan,
    },
    computed: {
        directoriesIsActive() {
            return this.$page.component.startsWith('Showcases');
        }
    }
}
</script>
