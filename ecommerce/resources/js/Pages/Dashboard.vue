<script setup>
import AppLayout from '@/Layouts/applayout.vue';
import { Head } from '@inertiajs/vue3';
import BentoGrid from '@/Components/BentoGrid.vue';

const mockProducts = [
    { id: 1, image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=250&fit=crop' },
    { id: 2, image: 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=400&h=250&fit=crop' },
    { id: 3, image: 'https://images.unsplash.com/photo-1626547149835-115844929e2e?w=400&h=250&fit=crop' },
    { id: 4, image: 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&h=250&fit=crop' },
];

const newDropImages = [
    'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=300&h=150&fit=crop',
    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=300&h=150&fit=crop',
];

const popularQuoteImage = 'https://images.unsplash.com/photo-1626547149835-115844929e2e?w=400&h=200&fit=crop';

const featuredItemImages = [
    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=300&h=150&fit=crop',
    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=300&h=150&fit=crop',
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <BentoGrid 
            :products="mockProducts"
            :stats="{ reviews: '4.8k+' }"
            :new-drop-images="newDropImages"
            :popular-quote-image="popularQuoteImage"
            :featured-item-images="featuredItemImages"
        />
    </AppLayout>
</template>
