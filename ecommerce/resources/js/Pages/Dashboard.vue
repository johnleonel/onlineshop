<script setup>
import AppLayout from '@/Layouts/Applayout.vue';
import { Head } from '@inertiajs/vue3';
import BentoGrid from '@/Components/BentoGrid.vue';
import Collections from '@/Components/Collections.vue';
import SaleSection from '@/Components/SaleSection.vue';
import LookbookSection from '@/Components/LookbookSection.vue';

// Props passed from ProductController::home() via Inertia
const props = defineProps({
  homeProducts: {
    type: Array,
    default: () => []
  },
  homeCollections: {
    type: Object,
    default: () => ({})
  }
});

const newDropImages = [
  '/images/new1.jpg',
  '/images/new2.jpg',
];

const popularQuoteImage = 'https://images.unsplash.com/photo-1626547149835-115844929e2e?w=400&h=200&fit=crop';

const featuredItemImages = [
  'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=300&h=150&fit=crop',
  'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=300&h=150&fit=crop',
];

// Use homeProducts for BentoGrid highlights (fallback to empty if none)
const bentoProducts = props.homeProducts.length > 0
  ? props.homeProducts.slice(0, 4)
  : [];
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout>
    <BentoGrid
      :products="bentoProducts"
      :stats="{ reviews: '4.8k+' }"
      :new-drop-images="newDropImages"
      :popular-quote-image="popularQuoteImage"
      :featured-item-images="featuredItemImages"
    />
    <Collections :collections="homeCollections" />
    <SaleSection :products="homeProducts" />
    <LookbookSection />
  </AppLayout>
</template>
