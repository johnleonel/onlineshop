<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
  products: {
    type: Array,
    default: () => []
  }
});

const goToProduct = (productId) => {
  router.visit('/products/' + productId);
};
</script>

<template>
  <section class="w-full bg-white py-12 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-10">
        <h2 class="text-4xl font-bold tracking-tight text-black">SALE</h2>
        <Link
          href="/products"
          class="inline-flex items-center justify-center rounded-full bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-900"
        >
          VIEW ALL
        </Link>
      </div>

      <div v-if="products.length === 0" class="text-center text-slate-400 py-12">
        No sale items available.
      </div>

      <div v-else class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6">
        <ProductCard
          v-for="item in products"
          :key="item.id"
          :product="item"
        />
      </div>
    </div>
  </section>
</template>