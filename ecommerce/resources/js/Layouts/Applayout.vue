<script setup>
import Header from '@/Components/Header.vue'
import AuthModal from '@/Components/AuthModal.vue'
import { onMounted } from 'vue'
import useCart from '@/composables/useCart'

const { initCart } = useCart()

onMounted(() => {
  initCart()
})
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

        <!-- Global Login Required Modal -->
        <AuthModal />
    </div>
</template>