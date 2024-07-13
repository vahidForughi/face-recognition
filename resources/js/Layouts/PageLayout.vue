<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    title: String,
});
</script>

<template>
    <div class="dir-rtl">
        <Head :title="title" />

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
