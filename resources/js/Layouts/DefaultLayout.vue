<template>
    <div class="page">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Navbar -->
        <Navbar />

        <slot />
    </div>
</template>
<script>
import Sidebar from "../Shared/Sidebar.vue";
import Navbar from "../Shared/Navbar.vue";

export default {
    components: {Navbar, Sidebar }
}
</script>
