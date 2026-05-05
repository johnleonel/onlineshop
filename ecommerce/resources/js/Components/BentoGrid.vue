<template>
  <div class="bg-gray-100 min-h-screen p-4 font-sans">
    <div class="grid grid-cols-12 gap-5 max-w-7xl mx-auto">
      
      <!-- Hero Section -->
      <div class="col-span-12 md:col-span-8 bg-white rounded-[40px] shadow-2xl p-10 relative overflow-hidden flex flex-col justify-between min-h-[500px]">
        
        <!-- Background Slideshow (Right Side Only) -->
        <div class="absolute top-0 right-0 w-1/2 h-full overflow-hidden z-0">
          <transition-group name="fade">
            <div 
              v-for="(img, index) in slideshowImages" 
              :key="img"
              v-show="currentSlide === index"
              class="absolute inset-0"
            >
              <!-- BINAGO: Mula opacity-40 ginawang opacity-100 para malinaw -->
              <img :src="img" class="w-full h-full object-cover opacity-100 transition-opacity duration-1000" alt="slideshow-img">
              
              <!-- Gradient Overlay - pinanatili para mabasa pa rin yung text sa gitna -->
              <div class="absolute inset-0 bg-gradient-to-r from-white via-white/20 to-transparent"></div>
            </div>
          </transition-group>
        </div>

        <!-- Header Part -->
        <div class="relative z-10">
          <div class="flex items-center mb-6">
            <span class="text-7xl font-bold text-gray-900 tracking-tighter mr-6 leading-none">01</span>
            <div class="flex flex-col justify-center">
              <h2 class="text-2xl font-serif font-semibold text-gray-800 leading-none mb-1">Just a kid from</h2>
              <div class="h-px bg-gray-200 w-full mt-1"></div>
            </div>
          </div>

          <!-- Floating Quote (Right) -->
          <div class="absolute top-0 right-0 bg-white/70 backdrop-blur-md rounded-2xl py-3 px-6 shadow-xl border border-gray-100">
            <p class="text-sm italic font-medium text-gray-700 tracking-tight">
              "In dressing well, self-confidence is quickly achieved."
            </p>
          </div>

          <!-- Main Titles -->
          <div class="mt-4">
            <h1 class="text-8xl font-serif font-bold text-gray-900 tracking-tighter leading-none">Chill fam</h1>
            <p class="mt-4 text-xl font-medium text-gray-600 max-w-md leading-relaxed">
              Style is more than fabric—it’s the story of confidence, courage, and character stitched together.
            </p>
          </div>
        </div>

        <!-- Footer Part: Socials & Buttons -->
        <div class="relative z-10 flex flex-col md:flex-row items-end md:items-center justify-between gap-6">
          <div class="flex items-center space-x-3">
            <span class="text-gray-500 font-medium text-sm">follow us on:</span>
            <a href="#" class="w-10 h-10 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 border border-gray-200 hover:bg-white transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a>
            <a href="#" class="w-10 h-10 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 border border-gray-200 hover:bg-white transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
            </a>
            <a href="#" class="w-10 h-10 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 border border-gray-200 hover:bg-white transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
            </a>
          </div>

          <div class="flex items-center bg-white/80 backdrop-blur-md p-1 rounded-full border border-gray-200 shadow-lg">
            <Link href="/products" class="text-gray-700 px-6 py-2 rounded-full font-bold text-base hover:bg-gray-100 transition-all">
              View All Products
            </Link>
            <button class="w-10 h-10 bg-[#1a1f2b] text-white rounded-full flex items-center justify-center hover:scale-105 transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17l10-10M7 7h10v10"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-span-12 md:col-span-4 space-y-6">
        <div class="bg-white rounded-3xl shadow-lg p-6">
          <h3 class="text-lg font-semibold mb-4">Popular color</h3>
          <div class="flex space-x-3">
            <div class="w-8 h-8 bg-black rounded-full cursor-pointer border-2 border-gray-300"></div>
            <div class="w-8 h-8 bg-white rounded-full cursor-pointer border-2 border-gray-300"></div>
            <div class="w-8 h-8 bg-red-500 rounded-full cursor-pointer border-2 border-gray-300"></div>
            <div class="w-8 h-8 bg-green-500 rounded-full cursor-pointer border-2 border-gray-300"></div>
            <div class="w-8 h-8 bg-blue-500 rounded-full cursor-pointer border-2 border-gray-300"></div>
          </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6 relative h-52 overflow-hidden">
          <div class="grid grid-cols-2 gap-2 mb-4 opacity-30">
            <img v-for="(image, index) in newDropImages" :key="index" :src="image" alt="Hoodie" class="w-full h-20 object-cover rounded-lg">
          </div>
          <div class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-3xl">
            <p class="text-white font-bold text-lg uppercase tracking-wider">new drop limited only!</p>
          </div>
          <button class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">✏️</button>
        </div>

        <!-- Camou Jorts Section -->
        <div class="bg-[#e2e2e2] rounded-3xl shadow-lg p-5 h-52 flex gap-4 items-center">
          <div class="flex-1 flex flex-col justify-between h-full py-1">
            <div>
              <h3 class="text-[#2a4365] font-serif font-bold text-lg leading-tight uppercase">Camou Jorts</h3>
              <p class="text-gray-700 text-sm italic">Few Stocks Left</p>
            </div>
            <div class="w-full h-20 bg-gray-300 rounded-2xl overflow-hidden mt-2 border border-white/50">
                <img src="https://picsum.photos/seed/jorts/200/200" class="w-full h-full object-cover" alt="Preview">
            </div>
            <div class="flex items-center gap-2 mt-2">
               <button class="w-8 h-8 bg-gray-300/50 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17l10-10M7 7h10v10"/></svg>
               </button>
               <div class="flex gap-1">
                 <div class="w-5 h-5 rounded-full bg-white flex items-center justify-center text-[10px]">f</div>
                 <div class="w-5 h-5 rounded-full bg-white flex items-center justify-center text-[10px]">ig</div>
               </div>
            </div>
          </div>
          <div class="w-1/2 h-full grid grid-cols-2 gap-1 bg-gray-400/20 p-1 rounded-2xl overflow-hidden">
             <img src="https://picsum.photos/seed/11/100/100" class="w-full h-full object-cover rounded-lg" alt="jorts-1">
             <img src="https://picsum.photos/seed/12/100/100" class="w-full h-full object-cover rounded-lg" alt="jorts-2">
             <img src="https://picsum.photos/seed/13/100/100" class="w-full h-full object-cover rounded-lg" alt="jorts-3">
             <img src="https://picsum.photos/seed/14/100/100" class="w-full h-full object-cover rounded-lg" alt="jorts-4">
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  products: { type: Array, default: () => [] },
  stats: { type: Object, default: () => ({ reviews: '4.8' }) },
  newDropImages: { type: Array, default: () => [] },
  popularQuoteImage: { type: String, default: '' },
  featuredItemImages: { type: Array, default: () => [] }
});

const currentSlide = ref(0);
const slideshowImages = [
  'https://picsum.photos/seed/1/800/600',
  'https://picsum.photos/seed/2/800/600',
  'https://picsum.photos/seed/3/800/600',
  'https://picsum.photos/seed/4/800/600',
  'https://picsum.photos/seed/5/800/600',
  'https://picsum.photos/seed/6/800/600',
];

let timer = null;

onMounted(() => {
  timer = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slideshowImages.length;
  }, 4000);
});

onUnmounted(() => {
  if (timer) clearInterval(timer);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1.5s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.fade-leave-active {
  position: absolute;
}
</style>