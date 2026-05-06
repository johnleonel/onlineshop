<script setup>
const saleItems = [
  { id: 1, name: 'WIZARD LORD TEE', price: 750.00, image: '/images/hood1.jpg' },
  { id: 2, name: 'REMINDER TEE', price: 750.00, image: '/images/hood2.jpg' },
  { id: 3, name: 'SPIRITUAL BREATH TEE', price: 750.00, image: '/images/hood3.jpg' },
  { id: 4, name: 'GLOBAL GOLD TEE', price: 750.00, image: '/images/hood4.jpg' },
  { id: 5, name: 'BAKE SALE BLACK TEE', price: 750.00, image: '/images/hood5.jpg' },
  { id: 6, name: 'INK SLINGER TEE', price: 750.00, image: '/images/hood6.jpg' },
  { id: 7, name: 'VADER MESSENGER BAG', price: 1500.00, image: '/images/hood7.jpg' },
  { id: 8, name: 'VOODOO QUEEN TEE', price: 750.00, image: '/images/hood8.jpg' },
  { id: 9, name: 'HEART MOLD TEE', price: 750.00, image: '/images/hood9.jpg' },
  { id: 10, name: 'REDEMPTION TEE', price: 750.00, image: '/images/hood10.jpg' },
  { id: 11, name: 'MUTED TEE', price: 750.00, image: '/images/hood11.jpg' },
  { id: 12, name: 'SLOPE PANTS', price: 1000.00, image: '/images/hood12.jpg' },
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
        <div v-for="item in saleItems" :key="item.id" class="group overflow-hidden rounded-3xl bg-slate-50 p-4 text-center transition hover:-translate-y-1 hover:shadow-xl">
          <div class="aspect-square overflow-hidden rounded-3xl bg-white p-4">
            <img :src="item.image" :alt="item.name" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
          </div>
          <div class="mt-4">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-900">{{ item.name }}</p>
            <p class="mt-2 text-base font-bold text-slate-900">₱{{ formatPrice(item.price) }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
