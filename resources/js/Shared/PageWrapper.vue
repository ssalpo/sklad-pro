<template>
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none" v-if="headerTitleIsShow">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle" v-if="$slots.headerPreTitle || headerPreTitle">
                            <slot v-if="!headerPreTitle" name="headerPreTitle"/>

                            <span v-else>{{ headerPreTitle }}</span>
                        </div>

                        <h2 class="page-title" v-if="$slots.headerTitle || headerTitle">
                            <slot v-if="!headerTitle" name="headerTitle"/>

                            <span v-else>{{ headerTitle }}</span>
                        </h2>
                    </div>

                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none" v-if="$slots.headerActions">
                        <div class="btn-list">
                            <slot name="headerActions"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        headerPreTitle: String,
        headerTitle: String
    },
    computed: {
        headerTitleIsShow() {
            return this.$slots.headerPreTitle || this.$slots.headerTitle || this.headerTitle || this.headerPreTitle;
        }
    }
}
</script>
