<script setup>
import { ref } from 'vue';

const lookbookImages = [
  '/images/pot1.jpg',
  '/images/pot2.jpg',
  '/images/pot3.jpg',
  '/images/pot4.jpg',
  '/images/pot5.jpg',
];

const activeIndex = ref(2);

const prevSlide = () => {
  activeIndex.value = (activeIndex.value - 1 + lookbookImages.length) % lookbookImages.length;
};

const nextSlide = () => {
  activeIndex.value = (activeIndex.value + 1) % lookbookImages.length;
};
</script>

<template>
  <section class="relative w-full bg-white py-16 px-4 md:px-8">
    <div class="max-w-7xl mx-auto text-center mb-10">
      <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-black">LOOKBOOK</h2>
    </div>

    <div class="relative max-w-6xl mx-auto">
      <div class="overflow-hidden rounded-[2rem] bg-slate-100 p-4">
        <div class="relative flex items-center justify-center">
          <button @click="prevSlide" class="absolute left-2 z-20 flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg ring-1 ring-slate-200 transition hover:bg-slate-50">
            <span class="text-xl">‹</span>
          </button>

          <div class="flex w-full items-center justify-center gap-4 overflow-hidden">
            <div
              v-for="(image, index) in lookbookImages"
              :key="index"
              class="relative transition-all duration-500"
              :class="{
                'w-36 opacity-40 scale-90': index !== activeIndex,
                'w-80 opacity-100 scale-100': index === activeIndex
              }"
            >
              <img :src="image" :alt="`Lookbook ${index + 1}`" class="h-[320px] w-full object-cover rounded-[1.5rem] shadow-2xl" />
            </div>
          </div>

          <button @click="nextSlide" class="absolute right-2 z-20 flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg ring-1 ring-slate-200 transition hover:bg-slate-50">
            <span class="text-xl">›</span>
          </button>
        </div>
      </div>
    </div>
  </section>
</template>
