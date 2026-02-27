<script setup>
import { Link } from '@inertiajs/vue3';
import EChart from '../../../components/EChart.vue';
import dayjs from 'dayjs';
import { onMounted } from 'vue';

const props = defineProps(['river', 'data', 'history', 'height'])

// async function fetchWarnings() {
//     const warnings = await fetch(`https://warnungen.zamg.at/wsapp/api/getWarningsForCoords?lon=${props.river.data.Key.cLon}&lat=${props.river.data.Key.cLat}&lang=de`)
// }

// onMounted(async () => {
//     await fetchWarnings()
// })
</script>

<template>
    <header class="py-3 px-6 rounded-t grid grid-cols-12 items-center">
        <div class="col-span-6">
            <h2 class="text-lg">
                <Link :href="`/pegel/${river.name}`">
                    {{ data.Key.cPegel }}
                </Link>
            </h2>
            <p v-if="$slots.subtitle" class="m-0 text-gray-400 text-sm">
                <slot name="subtitle"></slot>
            </p>
        </div>

        <div class="col-span-6 text-right">
            <div
                class="text-lg font-bold"
                :class="{
                    'text-yellow-300': +(data.Value?.Value) >= +data.Key.cLinie1 && +(data.Value?.Value) < +data.Key.cLinie2,
                    'text-orange-300': +(data.Value?.Value) >= +data.Key.cLinie2 && +(data.Value?.Value) < +data.Key.cLinie3,
                    'text-red-500': +(data.Value?.Value) >= +data.Key.cLinie3,
                }"
            >
                {{ (+(data.Value?.Value ?? null)).toLocaleString() }} cm
            </div>
            <div class="text-gray-400 text-sm">
                {{ dayjs(data.Value?.Key).format('DD.MM.YYYY HH:mm') }}
            </div>
        </div>
    </header>

    <div class="py-3 px-3">
        <e-chart
            class="border-0"
            :height="height ?? 400"
            :options="{
                grid: {
                    left: 32,
                    right: 8,
                },
                xAxis: [
                    {
                        type: 'time',
                    }
                ],
                yAxis: {
                    name: `Pegel in ${data.Key.cKurzeinheit}`,
                    min: 0,
                    max: Math.max(+data.Key.cLinie3, ...history.map((it) => +it.value)) * 1.1,
                },
                tooltip: {
                    trigger: 'axis',
                },
                toolbox: {
                    feature: {
                        dataZoom: {
                            yAxisIndex: 'none'
                        },
                        restore: {},
                        saveAsImage: {}
                    }
                },
                dataZoom: [
                    {
                        type: 'inside',
                        start: 0,
                        end: 100
                    },
                    {
                        start: 0,
                        end: 100
                    }
                ],
                series: [
                    {
                        name: `Pegel ${data.Key.cPegel}`,
                        type: 'line',
                        step: true,
                        data: history.map((it) => (
                            [+dayjs(it.timestamp), it.value]
                        )),
                        symbolSize: 0,
                        markLine: {
                            symbol: ['none', 'none'],
                            label: {
                                formatter: '{b}',
                                position: 'insideStartTop',
                                color: 'rgba(255, 255, 255, 0.5)',
                            },
                            lineStyle: {
                                opacity: 0.8,
                            },
                            data: [
                                {
                                    name: 'Vorwarnstufe',
                                    yAxis: +data.Key.cLinie1,
                                    lineStyle: {
                                        color: 'yellow',
                                    },
                                    symbol: 'none',
                                },
                                {
                                    name: 'Hochwasserwarnstufe',
                                    yAxis: +data.Key.cLinie2,
                                    lineStyle: {
                                        color: 'orange',
                                    },
                                    symbol: 'none',
                                },
                                {
                                    name: 'Hochwasseralarmstufe',
                                    yAxis: +data.Key.cLinie3,
                                    lineStyle: {
                                        color: 'red',
                                    },
                                    symbol: 'none',
                                },
                            ]
                        }
                    }
                ]
            }"
        />
        <details class="mt-3 mx-3">
            <summary class="text-gray-500 text-sm">Rohdaten</summary>
            <pre class="text-xs"><code>{{ data }}</code></pre>
            <pre class="text-xs"><code>{{ history }}</code></pre>
        </details>
    </div>
</template>
