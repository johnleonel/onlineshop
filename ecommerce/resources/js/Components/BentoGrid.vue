<template>
  <div class="bg-gray-100 min-h-screen p-4 font-sans">
    <div class="grid grid-cols-12 gap-4 max-w-7xl mx-auto" :key="$page.url">
      
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
              <h2 class="text-1xl font-serif font-semibold text-gray-800 leading-none mb-1">STRGHTOJLLY</h2>
              <div class="h-px bg-gray-200 w-full mt-1"></div>
            </div>
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

         
        <!-- Follow us Icon Section -->
        <div class="relative z-10 flex flex-col md:flex-row items-end md:items-center justify-between gap-6">
          <div class="flex items-center space-x-3">
            <span class="text-gray-500 font-medium text-sm">follow us on:</span>

            <!-- Facebook Icon -->
            <a href="#" class="w-10 h-10 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 border border-gray-200 transition-all duration-300 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] hover:-translate-y-1 hover:shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a>

            <!-- Instagram Icon -->
            <a href="#" class="w-10 h-10 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 border border-gray-200 transition-all duration-300 hover:bg-gradient-to-tr hover:from-[#f9ce34] hover:via-[#ee2a7b] hover:to-[#6228d7] hover:text-white hover:border-transparent hover:-translate-y-1 hover:shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
            </a>

            <!-- Twitter/X Icon -->
            <a href="#" class="w-10 h-10 bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 border border-gray-200 transition-all duration-300 hover:bg-black hover:text-white hover:border-black hover:-translate-y-1 hover:shadow-lg">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
            </a>
          </div>

          <!-- View All Products Button -->
          <Link href="/products" class="group flex items-center bg-white/80 backdrop-blur-md p-1 rounded-full border border-gray-200 shadow-lg transition-all hover:scale-[1.05] hover:shadow-xl active:scale-95 cursor-pointer">
            
            <!-- Text Part -->
            <span class="text-gray-700 px-6 py-2 rounded-full font-bold text-base transition-all group-hover:text-black">
              View All Products
            </span>

            <!-- Black Circle Button Part -->
            <div class="w-10 h-10 bg-[#1a1f2b] text-white rounded-full flex items-center justify-center transition-all group-hover:bg-black group-hover:rotate-45">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M7 17l10-10M7 7h10v10"/>
              </svg>
            </div>
          </Link>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-span-12 md:col-span-4 space-y-2">
        <div class="bg-white rounded-3xl shadow-lg p-4 text-center">
          <h3 class="text-sm font-semibold mb-2">Popular color</h3>
          <div class="flex justify-center items-center gap-2">
            <div class="w-6 h-6 bg-[#5c3a21] rounded-full cursor-pointer border-2 border-gray-300 transition-all duration-300 hover:scale-125 hover:border-gray-500"></div>
            <div class="w-6 h-6 bg-black rounded-full cursor-pointer border-2 border-gray-300 transition-all duration-300 hover:shadow-md hover:border-gray-500"></div>
            <div class="w-6 h-6 bg-white rounded-full cursor-pointer border-2 border-gray-300 transition-all duration-300 hover:scale-110 hover:ring-2 hover:ring-black hover:border-transparent"></div>
          </div>
        </div>

             <!-- New drop -->       
          <div class="relative overflow-hidden bg-white shadow-lg rounded-3xl group cursor-pointer h-72 flex items-center transition-colors duration-500">
            
            <div class="flex w-full overflow-hidden px-5">
              <div class="flex gap-1 animate-scroll group-hover:[animation-play-state:paused]">
                <div 
                  v-for="(image, index) in [...newDropImages, ...newDropImages]" 
                  :key="index" 
                  class="flex-none w-52 h-64 relative flex items-center justify-center transition-transform duration-500 hover:scale-110 hover:z-20 p-2"
                >
                  <img 
                    :src="image" 
                    alt="Hoodie" 
                  
                    class="w-full h-full object-contain transition-all duration-500 grayscale group-hover:grayscale-0"
                  >
                </div>
              </div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-transparent transition-colors duration-500 rounded-3xl pointer-events-none z-10">
              <p 
                class="px-4 text-xl font-black text-center text-white uppercase tracking-tighter md:text-2xl 
                      transform transition-all duration-500 
                      group-hover:scale-110 group-hover:tracking-widest
                      drop-shadow-md 
                      group-hover:drop-shadow-[0_2px_10px_rgba(0,0,0,0.8)]"
              >
                new drop limited only!
              </p>
            </div>
          </div>
        
            <!-- Most Loved -->
          <div class="relative bg-white rounded-3xl shadow-xl p-5 h-60 flex flex-col overflow-hidden border border-gray-100">
    
              <div class="flex flex-1 justify-between items-center gap-2 min-h-0"> 
                
                <div class="flex-1 h-full flex items-center justify-center p-0.5">
                  <img src="/images/more6.jpg" class="max-w-full max-h-[95%] object-contain transition-transform hover:scale-110" alt="prod-1">
                </div>

                <div class="flex flex-col items-center justify-center h-full scale-90"> 
                  <div class="w-[1.5px] h-6 bg-black"></div>
                  <div class="w-[1.5px] flex items-center justify-center py-2">
                    <h3 class="uppercase font-bold text-[8px] tracking-[0.3em] [writing-mode:vertical-lr] rotate-180 text-gray-800 leading-none whitespace-nowrap">
                      Most Loved Products
                    </h3>
                  </div>
                  <div class="w-[1.5px] h-6 bg-black"></div>
                </div>

                <div class="flex-1 h-full flex items-center justify-center p-0.5">
                  <img src="/images/more9.jpg" class="max-w-full max-h-[95%] object-contain transition-transform hover:scale-110" alt="prod-2">
                </div>
              </div>

              <div class="flex flex-col w-full mt-2">
                <div class="text-center mb-2">
                  <p class="text-[8px] uppercase tracking-widest text-gray-400">Special Offer</p>
                  <h4 class="text-[10px] font-black uppercase text-gray-900 leading-tight">All Products 50% Off</h4>
                </div>
                
                <button class="w-full bg-black text-white py-2 rounded-xl font-bold text-[10px] uppercase flex items-center justify-center gap-2 transition-all hover:bg-zinc-800 active:scale-[0.98] group">
                  Shop Now
                  <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1">
                    <path d="M9 18l6-6-6-6"/>
                  </svg>
                </button>
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
    '/images/slide4.jpg',
    '/images/slide5.jpg',
    '/images/slide6.jpg',
    '/images/slide7.jpg',
    '/images/slide-2.jpg',
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