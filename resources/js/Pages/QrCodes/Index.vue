<template>
    <PageWrapper
        header-title="QR-коды и ссылки"
    >

        <qr-code-card
            class="mb-3"
            :company="company"
            v-for="company in companies"
        />

    </PageWrapper>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import PageWrapper from "../../Shared/PageWrapper.vue";
import QrCodeCard from "../../Shared/QrCodeCard.vue";

export default {
    components: {QrCodeCard, PageWrapper, Link},
    props: ['companies']
}
</script>
