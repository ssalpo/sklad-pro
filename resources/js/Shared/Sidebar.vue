<template>
    <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <h1 class="navbar-brand navbar-brand-autodark">
                <a href="">
                    <img src="../../img/logo-white.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>

            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item dropdown">
                    <UserDropdown type="sidebar" />
                </div>
            </div>

            <div class="navbar-collapse collapse" id="sidebar-menu" style="">
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconHome :size="24" stroke-width="1" />
                            </span>

                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<script>
import {IconHome} from "@tabler/icons-vue";
import UserDropdown from "./UserDropdown.vue";

export default {
    components: {UserDropdown, IconHome}
}
</script>
