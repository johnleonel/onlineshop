<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import useCart from '@/composables/useCart'
import useAuthModal from '@/composables/useAuthModal'
import { resolveImage } from '@/utils/imageHelper'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
  relatedProducts: {
    type: Array,
    default: () => []
  },
})

const { addToCart, setBuyNowItem } = useCart()
const { openAuthModal } = useAuthModal()
const page = usePage()
const quantity = ref(1)

// Check if user is authenticated
const isAuthenticated = computed(() => !!page.props.auth?.user)

// UI State
const selectedColor = ref('53 Green')
const selectedSize = ref('S')
const selectedTab = ref('')

// ── Unified sale detection ──────────────────────────────────
// A product is a "sale" item when it has an originalPrice set and > current price
const isSaleItem = computed(() =>
  props.product.originalPrice && props.product.originalPrice > props.product.price
)

const saleDiscount = computed(() =>
  isSaleItem.value
    ? Math.round(((props.product.originalPrice - props.product.price) / props.product.originalPrice) * 100)
    : 0
)

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
  resolveImage(props.product.image),
  resolveImage(props.product.image),
  resolveImage(props.product.image),
  resolveImage(props.product.image),
])
const moreThumbnails = 4

const originalPrice = computed(() => props.product.originalPrice || props.product.price + 34)

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
  addToCart(props.product, quantity.value, selectedSize.value, selectedColor.value)
  showAddedToast(props.product.name)
}

const handleBuyNow = () => {
  if (!selectedSize.value) {
    alert('Please select a size before proceeding.')
    return
  }
  if (!isAuthenticated.value) {
    openAuthModal('/checkout?source=direct_buy')
    return
  }
  setBuyNowItem(props.product, quantity.value, selectedSize.value, selectedColor.value)
  router.visit('/checkout?source=direct_buy')
}

const showAddedToast = (productName) => {
  addedToastName.value = productName
  toastVisible.value = true
  setTimeout(() => {
    toastVisible.value = false
  }, 2500)
}

const toastVisible = ref(false)
const addedToastName = ref('')
</script>

<template>
  <AppLayout>
    <Head :title="product.name" />

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
              :src="resolveImage(product.image)"
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

              <!-- Sale Badge – shown only for discounted products -->
              <div v-if="isSaleItem" class="mt-2 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                  <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                  </svg>
                  Sale – {{ saleDiscount }}% Off
                </span>
              </div>

              <div class="mt-3 flex items-center gap-3 text-xs">
                <span class="bg-slate-100 px-2 py-1 rounded-md font-semibold">5K+ Sold</span>
                <span class="text-amber-500 font-bold">★ 4.9</span>
                <span class="text-slate-400">(225 reviews)</span>
              </div>
            </div>

            <!-- Price Section – unified: shows strikethrough only for sale items -->
            <div class="mt-6 flex items-baseline gap-3">
              <span class="text-3xl font-black text-slate-900">₱{{ formatPrice(product.price) }}</span>
              <template v-if="isSaleItem">
                <span class="text-sm text-slate-400 line-through">₱{{ formatPrice(originalPrice) }}</span>
                <span class="text-sm font-bold text-red-500">-{{ saleDiscount }}%</span>
              </template>
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
              <button @click="handleBuyNow" class="bg-slate-900 text-white py-3 rounded-xl font-bold text-sm hover:bg-slate-800 transition">
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

    <!-- Toast notification -->
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="transform -translate-y-4 opacity-0"
      enter-to-class="transform translate-y-0 opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="transform translate-y-0 opacity-100"
      leave-to-class="transform -translate-y-4 opacity-0"
    >
      <div
        v-if="toastVisible"
        class="fixed top-24 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 bg-black text-white px-5 py-3 rounded-2xl shadow-xl"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
        </svg>
        <span class="text-sm font-semibold">"{{ addedToastName }}" added to cart</span>
      </div>
    </Transition>
  </AppLayout>
</template>
