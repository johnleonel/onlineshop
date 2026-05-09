<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { resolveImage } from '@/utils/imageHelper';

// Products passed from the backend (HomeController/Dashboard)
const props = defineProps({
  products: {
    type: Array,
    default: () => []
  }
});

const formatPrice = (value) => value.toFixed(2);

const saleItems = computed(() => {
  // If products are passed, use them; otherwise fall back to empty (no hardcoded items)
  return props.products.length > 0 ? props.products : [];
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

      <div v-if="saleItems.length === 0" class="text-center text-slate-400 py-12">
        No sale items available.
      </div>

      <div v-else class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6">
        <div
          v-for="item in saleItems"
          :key="item.id"
          @click="goToProduct(item.id)"
          class="group block overflow-hidden rounded-3xl bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-xl cursor-pointer"
        >
          <div class="aspect-square overflow-hidden rounded-3xl bg-white p-4">
            <img
              :src="resolveImage(item.image)"
              :alt="item.name"
              class="h-full w-full object-contain transition duration-300 group-hover:scale-105"
              loading="lazy"
            />
          </div>
          <div class="mt-4">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-900">{{ item.name }}</p>
            <p class="mt-1 text-sm font-bold text-slate-900">₱{{ formatPrice(item.price) }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
