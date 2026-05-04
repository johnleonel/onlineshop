<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4 text-center">Welcome to your CHILLEROX Account</h2>
                    <p class="text-center text-gray-500">Your orders and profile will appear here.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>