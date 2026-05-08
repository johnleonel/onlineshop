<template>
  <AppLayout>
    <Head :title="product.name" />

    <!-- Binabaan ang max-width para mas "compact" ang tingin sa screen -->
    <div class="max-w-6xl mx-auto px-4 py-8">
      
      <!-- Breadcrumbs -->
      <div class="mb-6 flex items-center gap-3 text-xs text-slate-500">
        <Link href="/products" class="hover:text-slate-900 font-medium">Products</Link>
        <span>/</span>
        <span class="text-slate-900">{{ product.name }}</span>
      </div>

      <!-- Main Product Grid -->
      <div class="grid gap-8 lg:grid-cols-2 items-start">
        
        <!-- LEFT: Image Section -->
        <section>
          <div class="rounded-[2rem] bg-white p-4 shadow-sm border border-slate-100">
            <img
              :src="product.image"
              :alt="product.name"
              class="w-full rounded-[1.5rem] object-cover aspect-square"
            />

            <!-- Thumbnails (Pinaliit din) -->
            <div class="mt-4 grid gap-2 grid-cols-5">
              <button
                v-for="(thumb, index) in thumbnailImages"
                :key="index"
                class="overflow-hidden rounded-xl border border-slate-200 transition hover:border-slate-400"
              >
                <img :src="thumb" class="h-14 w-full object-cover" />
              </button>
            </div>
          </div>
        </section>

        <!-- RIGHT: Product Info -->
        <section class="flex flex-col gap-5">
          <div class="rounded-[2rem] bg-white p-6 shadow-sm border border-slate-100">
            <div>
              <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400">Classic Collection</p>
              <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ product.name }}</h1>
              
              <div class="mt-3 flex items-center gap-3 text-xs">
                <span class="bg-slate-100 px-2 py-1 rounded-md font-semibold">5K+ Sold</span>
                <span class="text-amber-500 font-bold">★ 4.9</span>
                <span class="text-slate-400">(225 reviews)</span>
              </div>
            </div>

            <div class="mt-6 flex items-baseline gap-3">
              <span class="text-3xl font-black text-slate-900">₱{{ formatPrice(product.price) }}</span>
              <span class="text-sm text-slate-400 line-through">₱{{ formatPrice(originalPrice) }}</span>
            </div>

            <!-- Selectors -->
            <div class="mt-6 space-y-5">
              <div>
                <label class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">Select Color</label>
                <div class="mt-2 flex gap-2">
                  <button
                    v-for="color in colors"
                    :key="color.name"
                    @click="selectedColor = color.name"
                    :class="['h-8 w-8 rounded-full border-2 transition', selectedColor === color.name ? 'border-slate-900 scale-110' : 'border-transparent']"
                    :style="{ backgroundColor: color.code }"
                  ></button>
                </div>
              </div>

              <div>
                <label class="text-[11px] font-bold uppercase text-slate-400 tracking-wider">Size</label>
                <div class="mt-2 flex flex-wrap gap-2">
                  <button
                    v-for="size in sizes"
                    :key="size"
                    @click="selectedSize = size"
                    :class="['h-10 w-12 rounded-xl border text-xs font-bold transition', 
                      selectedSize === size ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400']"
                  >
                    {{ size }}
                  </button>
                </div>
              </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 grid grid-cols-2 gap-3">
              <button @click="handleAddToCart" class="bg-emerald-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-emerald-700 transition">
                + Add to Cart
              </button>
              <button class="bg-slate-900 text-white py-3 rounded-xl font-bold text-sm hover:bg-slate-800 transition">
                Buy Now
              </button>
            </div>
          </div>

          <!-- Tab Toggles (Dito pipindutin para lumabas ang review) -->
          <div class="flex gap-2">
            <button 
              v-for="tab in tabs" 
              :key="tab"
              @click="selectedTab = (selectedTab === tab ? '' : tab)"
              :class="['px-5 py-2 rounded-full text-xs font-bold transition', 
                selectedTab === tab ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 border border-slate-200']"
            >
              {{ tab }}
            </button>
          </div>
        </section>
      </div>

      <!-- CONDITIONAL SECTION: Lalabas lang ito sa ibaba pag may selectedTab -->
      <transition name="fade">
        <div v-if="selectedTab === 'Reviews'" class="mt-8 rounded-[2rem] bg-white p-8 shadow-sm border border-slate-100">
          <h3 class="text-xl font-bold mb-6">Customer Reviews</h3>
          
          <div class="grid gap-8 lg:grid-cols-[250px_1fr]">
            <!-- Rating Stats -->
            <div class="space-y-3">
              <div class="text-5xl font-black text-slate-900">4.9</div>
              <p class="text-sm text-slate-500">Average Rating</p>
              <div v-for="rating in ratingBars" :key="rating.label" class="flex items-center gap-2">
                <span class="text-xs font-bold w-3">{{ rating.label }}</span>
                <div class="h-1.5 flex-1 bg-slate-100 rounded-full overflow-hidden">
                  <div :style="{ width: rating.width }" class="h-full bg-emerald-500"></div>
                </div>
              </div>
            </div>

            <!-- Actual Review List -->
            <div class="space-y-6">
              <div class="border-b border-slate-100 pb-6">
                <div class="flex justify-between items-center">
                  <p class="font-bold text-slate-900">James Gouse</p>
                  <span class="text-amber-500 text-xs">★★★★★</span>
                </div>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                  Material is very soft and premium. Fits perfectly!
                </p>
              </div>
            </div>
          </div>
        </div>
      </transition>
      
      <div v-if="selectedTab === 'Details'" class="mt-8 rounded-[2rem] bg-white p-8 shadow-sm border border-slate-100">
         <p class="text-slate-600">Detailed product specifications and material info here...</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import useCart from '@/composables/useCart'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

// Logic para sa Cart
const { addToCart } = useCart()
const quantity = ref(1)

// UI State
const selectedColor = ref('53 Green')
const selectedSize = ref('S')
const selectedTab = ref('') // Naka-empty para nakatago ang reviews sa simula

// Data
const colors = [
  { name: '53 Green', code: '#8AA491' },
  { name: '12 Peach', code: '#E0C7B0' },
  { name: '88 Gray', code: '#D9D9D9' },
]
const sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL']
const tabs = ['Details', 'Reviews', 'Discussion']

// Computed Properties
const thumbnailImages = computed(() => [
  props.product.image,
  props.product.image,
  props.product.image,
  props.product.image,
])
const moreThumbnails = 4

const originalPrice = computed(() => props.product.price + 34)

const ratingBars = [
  { label: '5', count: 184, width: '75%' },
  { label: '4', count: 63, width: '45%' },
  { label: '3', count: 29, width: '25%' },
  { label: '2', count: 7, width: '12%' },
  { label: '1', count: 2, width: '5%' },
]

// Methods
const formatPrice = (price) => parseFloat(price).toFixed(2)

const handleAddToCart = () => {
  addToCart(props.product, quantity.value)
}
</script>