<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="p-3 xl:px-6">
        <header>
            <h1 class="font-bold text-lg py-6">
                <Link href="/">
                    Hochwasser Dashboard Ybbsitz
                </Link>
            </h1>
        </header>
        <slot/>
        <footer class="py-6">
            <div>
                <b>Version: </b> {{ $page.props.pegel.version }}
            </div>
            <div class="mt-3">
                <b>Impressum: </b>
            </div>
            <div>
                Ing. Christoph Hochstrasser
            </div>
            <div>
                Haselgraben 23
            </div>
            <div>
                3341 Ybbsitz
            </div>
            <div class="space-x-3 flex mt-3">
                <a href="https://github.com/CHH/hochwasser-dashboard-laravel">GitHub &rarr;</a>
                <a href="https://hochstrasser.io">Website &rarr;</a>
                <a href="https://hochstrasser.io/privacy">Datenschutz &rarr;</a>
            </div>
        </footer>
    </div>
</template>
