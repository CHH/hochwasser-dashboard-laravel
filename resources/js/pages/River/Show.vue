<script setup>
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import River from '../Home/Partials/River.vue';

defineProps(['river'])

defineOptions({
    layout: DefaultLayout
})
</script>

<template>
    <div class="rounded-xl bg-gray-800">
        <River
            :river="river"
            :data="river.data"
            :history="river.levels"
            :height="600"
        >
            <template #subtitle>8 Tage</template>
        </River>
    </div>
</template>
