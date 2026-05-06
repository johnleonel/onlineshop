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
              <img :src="img" class="w-full h-full object-cover opacity-100 transition-opacity duration-1000" alt="slideshow-img">
              <div class="absolute inset-0 bg-gradient-to-r from-white via-white/20 to-transparent"></div>
            </div>
          </transition-group>
        </div>

        <!-- Header Part -->
        <div class="relative z-10">
          <div class="flex items-center mb-2">
            <span class="text-7xl font-bold text-gray-900 tracking-tighter mr-6 leading-none">01</span>
            <div class="flex flex-col justify-center">
              <h2 class="text-2xl font-serif font-semibold text-gray-800 leading-none mb-1">STRGHTOTJLLY</h2>
              <div class="h-px bg-gray-200 w-full mt-1"></div>
            </div>
          </div>

          <div class="absolute top-0 right-0 bg-white/70 backdrop-blur-md rounded-2xl py-3 px-2 shadow-xl border border-gray-100">
            <p class="text-sm italic font-medium text-gray-700 tracking-tight">
              "In dressing well, self-confidence is quickly achieved."
            </p>
          </div>

          <div class="flex flex-col justify-center min-h-[400px] mt-4">
            <div class="text-left">
              <h1 class="text-8xl font-serif font-bold text-gray-900 tracking-tighter leading-[0.8]">
                CHLLERX
              </h1>
              <p class="mt-2 text-x2 font-small text-gray-600 max-w-md leading-relaxed">
                Style is more than fabric—it’s the story of confidence, courage, and character stitched together.
              </p>
            </div>
          </div>
        </div>

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
        <div class="bg-white rounded-3xl shadow-lg p-6 text-center">
          <h3 class="text-lg font-semibold mb-4">Popular color</h3>
          <div class="flex justify-center items-center gap-3">
            <div class="w-8 h-8 bg-[#5c3a21] rounded-full cursor-pointer border-2 border-gray-300"></div>
            <div class="w-8 h-8 bg-black rounded-full cursor-pointer border-2 border-gray-300"></div>
            <div class="w-8 h-8 bg-white rounded-full cursor-pointer border-2 border-gray-300"></div>
          </div>
        </div>

        <!-- NEW DROP AUTOMATIC CAROUSEL -->
        <div class="relative overflow-hidden bg-white shadow-lg rounded-3xl group cursor-pointer h-72 flex items-center">
          
          <!-- Carousel Wrapper -->
          <div class="flex w-full overflow-hidden">
            <!-- Scrolling Content -->
            <div class="flex gap-3 animate-scroll group-hover:[animation-play-state:paused]">
              <!-- Dinoble ang listahan para sa seamless infinite loop -->
              <div 
                v-for="(image, index) in [...newDropImages, ...newDropImages]" 
                :key="index" 
                class="flex-none w-36 h-52 relative overflow-hidden rounded-2xl shadow-sm transition-transform duration-500 hover:scale-110 hover:z-20"
              >
                <img 
                  :src="image" 
                  alt="Hoodie" 
                  class="w-full h-full object-cover transition-all duration-500 grayscale group-hover:grayscale-0"
                >
              </div>
            </div>
          </div>

          <!-- Overlay Text Container -->
          <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/20 transition-colors duration-500 rounded-3xl pointer-events-none z-10">
            <p class="px-4 text-xl font-black text-center text-white uppercase tracking-tighter md:text-2xl transform transition-transform duration-500 group-hover:scale-110 group-hover:tracking-widest">
              new drop limited only!
            </p>
          </div>
        </div>

        <!-- Camou Jorts Section -->
        <div class="bg-[#e2e2e2] rounded-3xl shadow-lg p-5 h-52 flex gap-4 items-center">
          <div class="flex flex-col justify-center h-full py-1 min-w-fit">
            <div class="flex flex-col">
              <h3 class="text-[#000000] font-serif font-bold text-sm uppercase whitespace-nowrap tracking-tight">
                More Products
              </h3>
              <p class="text-gray-700 text-[10px] italic">70+ items.</p>
            </div>
            <div class="flex items-center gap-2 mt-2">
              <button class="w-8 h-8 bg-gray-300/50 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17l10-10M7 7h10v10"/></svg>
              </button>
            </div>
          </div>

          <div class="w-[70%] h-full grid grid-cols-2 grid-rows-2 gap-1.5 rounded-2xl overflow-hidden">
            <img src="/images/more1.jpg" class="w-full h-full object-cover" alt="jorts-1">
            <img src="/images/more2.jpg" class="w-full h-full object-cover" alt="jorts-2">
            <img src="/images/more3.jpg" class="w-full h-full object-cover" alt="jorts-3">
            <img src="/images/more4.jpg" class="w-full h-full object-cover" alt="jorts-4">
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
 
  popularQuoteImage: { type: String, default: '' },
  featuredItemImages: { type: Array, default: () => [] }
});

const newDropImages = [
    '/images/hood1.jpg', 
    '/images/hood2.jpg', 
    '/images/hood3.jpg', 
    '/images/hood4.jpg', 
    '/images/hood2.jpg'
  ];

const currentSlide = ref(0);
const slideshowImages = ref([]);

let timer = null;

onMounted(() => {
  slideshowImages.value = [
    '/images/slide-1.jpg',
    '/images/slide-2.jpg',
    '/images/slide-3.jpg',
    '/images/slide-4.jpg'
  ];

  if (slideshowImages.value.length > 0) {
    timer = setInterval(() => {
      currentSlide.value = (currentSlide.value + 1) % slideshowImages.value.length;
    }, 4000);
  }
});

onUnmounted(() => {
  if (timer) clearInterval(timer);
});
</script>

<style scoped>
/* Keyframes para sa kaliwang pag-andar */
@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    /* Hinihila pabalik sa kalahati ng kabuuang width ng dinobleng listahan */
    transform: translateX(-50%);
  }
}

.animate-scroll {
  display: flex;
  width: max-content;
  animation: scroll 20s linear infinite;
}

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