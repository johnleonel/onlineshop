<script setup>
import { Link } from '@inertiajs/vue3';

const saleItems = [

  { id: 1, name: 'WIZARD LORD TEE', price: 750.00, image: '/images/hood20.jpg' },
  { id: 2, name: 'REMINDER TEE', price: 750.00, image: '/images/hood2.jpg' },
  { id: 3, name: 'SPIRITUAL BREATH TEE', price: 750.00, image: '/images/hood3.jpg' },
  { id: 4, name: 'GLOBAL GOLD TEE', price: 750.00, image: '/images/hood4.jpg' },
  { id: 5, name: 'BAKE SALE BLACK TEE', price: 750.00, image: '/images/more7.jpg' },
  { id: 6, name: 'INK SLINGER TEE', price: 750.00, image: '/images/hood13.jpg' },
  { id: 7, name: 'VADER MESSENGER BAG', price: 1500.00, image: '/images/hood15.jpg' },
  { id: 8, name: 'VOODOO QUEEN TEE', price: 750.00, image: '/images/hood17.jpg' },
  { id: 9, name: 'HEART MOLD TEE', price: 750.00, image: '/images/more9.jpg' },
  { id: 10, name: 'REDEMPTION TEE', price: 750.00, image: '/images/hood14.jpg' },
  { id: 11, name: 'MUTED TEE', price: 750.00, image: '/images/hood16.jpg' },
  { id: 12, name: 'SLOPE PANTS', price: 1000.00, image: '/images/hood21.jpg' },
];

const formatPrice = (value) => value.toFixed(2);
</script>

<template>
  <section class="w-full bg-white py-12 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-10">
        <h2 class="text-4xl font-bold tracking-tight text-black">SALE</h2>
        <button class="inline-flex items-center justify-center rounded-full bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-900">
          VIEW ALL
        </button>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6">
        <!-- Container: White background, no border, with hover shadow -->
        <Link
          v-for="item in saleItems"
          :key="item.id"
          :href="`/products/${item.id}`"
          class="group block overflow-hidden rounded-3xl bg-white p-4 text-center transition hover:-translate-y-1 hover:shadow-xl"
        >

          <!-- Image Box: White background -->
          <div class="aspect-square overflow-hidden rounded-3xl bg-white p-4">
            <img
              :src="item.image"
              :alt="item.name"
              class="h-full w-full object-contain transition duration-300 group-hover:scale-105"
              loading="lazy"
            />
          </div>

          <div class="mt-4">
            <!-- Pinaliit na text size -->
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-900">{{ item.name }}</p>
            <p class="mt-1 text-sm font-bold text-slate-900">₱{{ formatPrice(item.price) }}</p>
          </div>
        </Link>
      </div>
    </div>
  </section>
</template>