<script setup>
import Header from '@/Components/Header.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <!-- The Custom CHILLEROX Header -->
        <Header />

        <!-- Dynamic Page Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Basic Footer -->
        <footer class="bg-white border-t border-gray-200 py-8 text-center text-gray-500 text-sm">
            &copy; 2026 CHILLEROX. All rights reserved.
        </footer>
    </div>
</template>