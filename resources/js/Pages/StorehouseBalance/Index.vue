<template>
    <PageWrapper
        header-title="Остаток на складе"
        header-pre-title="В списке отображается все ваши остатки по товарам"
    >

        <StorehouseBalanceIndexDesktop
            :balances="balances"
            v-if="!isMobile"
        />

        <StorehouseBalanceIndexMobile
            :balances="balances"
            v-else
        />

    </PageWrapper>
</template>

<script>
import PageWrapper from "../../Shared/PageWrapper.vue";
import StorehouseBalanceIndexDesktop from "./IndexDesktop.vue";
import StorehouseBalanceIndexMobile from "./IndexMobile.vue";

export default {
    name: "StorehouseBalance",
    components: {StorehouseBalanceIndexMobile, StorehouseBalanceIndexDesktop, PageWrapper},
    props: ['balances']
}
</script>
