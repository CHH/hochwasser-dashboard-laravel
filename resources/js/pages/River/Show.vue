<script setup>
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import RiverCard from '../Home/Partials/River.vue';
import { Deferred, Link } from '@inertiajs/vue3';

defineProps(['river'])

defineOptions({
    layout: DefaultLayout
})
</script>

<template>
    <div>
        <div class="mb-3">
            <Link href="/" class="text-gray-400 hover:text-white">&larr; Zurück</Link>
        </div>

        <Deferred data="river">
            <template #fallback>
                <div class="rounded bg-gray-800 p-6">
                    Pegelstand wird geladen…
                </div>
            </template>

            <div class="rounded-xl bg-gray-800">
                <RiverCard
                    :data="river.data"
                    :history="river.levels"
                />
            </div>
        </Deferred>
    </div>
</template>
