<script setup>
import * as echarts from 'echarts'
import { inject, onBeforeUnmount, onMounted, onUpdated, ref, watch } from 'vue';
import langDE from 'echarts/lib/i18n/langDE.js'
import merge from 'lodash/merge'
import debounce from 'lodash/debounce'

echarts.registerLocale('DE', langDE)

const emit = defineEmits(['init', 'set-options'])

const props = defineProps({
	echartInitOptions: {
		type: Object,
		default: () => ({}),
	},
	options: {
		type: Object,
	},
	title: {
		type: String,
	},
	height: {
		type: [String, Number],
		default: null,
	},
	width: {
		type: [String, Number],
		default: null,
	},
	group: {
		type: String,
	},
	renderer: {
		type: String,
		default: 'canvas',
	},
	breakInside: {
		type: Boolean,
		default: false,
	}
})

const globalInitOptions = inject('echarts.globalInitOptions', {})
const globalOptions = inject('echarts.globalOptions', {})
const chartElement = ref(null)

let chart = null
let resizeObserver = null

onMounted(() => {
	chart = echarts.init(chartElement.value, null, {
		width: props.width,
		height: props.height,
		renderer: props.renderer,
		locale: 'DE',
		...globalInitOptions,
		...props.echartInitOptions,
	})

	if (props.group) {
		chart.group = group
	}

	chart.setOption(merge({}, globalOptions, props.options))

	watch(() => props.options, (newValue) => {
		chart.setOption(merge({}, globalOptions, newValue), true)
		emit('set-options', { chart })
	})

	const resize = debounce(() => chart.resize(), 250)

	resizeObserver = new ResizeObserver(() => resize())
	resizeObserver.observe(chartElement.value)

	emit('init', { chart })
})

onBeforeUnmount(() => {
	resizeObserver.disconnect()
	echarts.dispose(chart)
})
</script>

<template>
	<div class="border p-2 echart-container" :class="{ 'echart-avoid-break': !breakInside }">
		<div v-if="$slots.title || title" class="echart-title text-center font-weight-bold text-muted mb-0">
			<slot name="title">{{ title }}</slot>
		</div>

		<div
			class="echart"
			:class="{ 'echart-avoid-break': !breakInside }"
			ref="chartElement"
		></div>
	</div>
</template>

<style scoped>
.echart-title {
	font-size: 0.8rem;
}
.echart-avoid-break {
	break-inside: avoid;
}
</style>
