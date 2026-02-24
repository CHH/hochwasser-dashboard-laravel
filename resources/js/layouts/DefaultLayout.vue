<script setup>
</script>

<template>
    <div class="p-3 xl:p-6">
        <header>
            <h1 class="font-bold text-lg">Hochwasser Dashboard Ybbsitz</h1>
        </header>
        <slot/>
        <footer class="mt-3">
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
            <div class="space-x-3 flex">
                <a href="https://hochstrasser.io">Website &rarr;</a>
                <a href="https://hochstrasser.io/privacy">Datenschutz &rarr;</a>
            </div>
        </footer>
    </div>
</template>
