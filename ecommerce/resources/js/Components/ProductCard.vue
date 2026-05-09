<script setup>
import { computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import useCart from '@/composables/useCart'
import useAuthModal from '@/composables/useAuthModal'
import { resolveImage } from '@/utils/imageHelper'

const props = defineProps({
  product: {
    type: Object,
    required: true
  },
  variant: {
    type: String,
    default: 'grid'
  }
})

const page = usePage()
const isAuthenticated = computed(() => !!page.props.auth?.user)

const { addToCart, setBuyNowItem } = useCart()
const { openAuthModal } = useAuthModal()

const hasSale = computed(() => {
  return props.product.sale_price !== undefined &&
    props.product.sale_price !== null &&
    props.product.originalPrice !== undefined &&
    props.product.originalPrice !== null &&
    parseFloat(props.product.sale_price) < parseFloat(props.product.originalPrice)
})

const discountPercent = computed(() => {
  if (!hasSale.value) return 0
  const original = parseFloat(props.product.originalPrice)
  const sale = parseFloat(props.product.sale_price)
  if (!original || original === 0) return 0
  return Math.round(100 - (sale / original * 100))
})

const displayPrice = computed(() => {
  const price = hasSale.value ? parseFloat(props.product.sale_price) : parseFloat(props.product.price)
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price)
})

const originalPriceDisplay = computed(() => {
  if (!hasSale.value) return null
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(parseFloat(props.product.originalPrice))
})

// Build cart item object — always uses sale_price when on sale
const buildCartItem = () => ({
  id: props.product.id,
  name: props.product.name,
  price: hasSale.value ? parseFloat(props.product.sale_price) : parseFloat(props.product.price),
  originalPrice: props.product.originalPrice ? parseFloat(props.product.originalPrice) : null,
  image: props.product.image,
  category: props.product.category,
})

const goToProduct = () => {
  router.visit(`/products/${props.product.id}`)
}

const handleAddToCart = (e) => {
  e.stopPropagation()
  addToCart(buildCartItem())
}

const handleBuyNow = (e) => {
  e.stopPropagation()
  if (!isAuthenticated.value) {
    openAuthModal('/checkout')
    return
  }
  setBuyNowItem(buildCartItem(), 1, null, null)
  router.visit('/checkout')
}
</script>

<template>
  <!-- Floating white card — no border, no static shadow -->
  <div
    class="group cursor-pointer flex flex-col bg-white rounded-2xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
    :class="variant === 'list' ? 'flex-row' : ''"
    @click="goToProduct"
  >
    <!-- Image Container — white rounded area with padding -->
    <div
      class="relative overflow-hidden bg-white rounded-t-2xl"
      :class="variant === 'list' ? 'w-40 h-40 flex-shrink-0 rounded-l-2xl rounded-tr-none' : 'aspect-square w-full p-4'"
    >
      <img
        :src="resolveImage(product.image)"
        :alt="product.name"
        class="h-full w-full object-contain transition-all duration-300 group-hover:scale-105"
        :class="variant === 'list' ? 'object-cover rounded-l-2xl rounded-tr-none' : ''"
      />

      <!-- Sale Badge: top-right corner, red pill -->
      <div
        v-if="hasSale"
        class="absolute top-3 right-3 bg-red-500 text-white rounded-full px-2.5 py-1 text-[10px] font-black tracking-wide shadow-md flex items-center gap-1"
      >
        <span class="font-black">{{ discountPercent }}%</span>
        <span class="font-semibold">OFF</span>
      </div>
    </div>

    <!-- Content Section — clean, uniform text alignment -->
    <div
      class="p-4 flex flex-col flex-grow"
      :class="variant === 'list' ? 'py-3 pr-3' : ''"
    >
      <!-- Category -->
      <div class="text-[10px] uppercase tracking-wider text-slate-400 font-bold">
        {{ product.category }}
      </div>

      <!-- Product Name -->
      <h2 class="mt-1 text-sm font-bold text-slate-900 line-clamp-1">{{ product.name }}</h2>
      <p v-if="product.description" class="mt-1 text-[11px] leading-4 text-slate-400 line-clamp-2">{{ product.description }}</p>

      <!-- Price & Actions — uniform alignment -->
      <div class="mt-auto pt-3 flex items-center justify-between gap-2">
        <div class="flex flex-col">
          <span class="text-sm font-bold text-slate-900">₱{{ displayPrice }}</span>
          <span v-if="hasSale" class="text-[10px] text-slate-400 line-through font-medium">₱{{ originalPriceDisplay }}</span>
          <span v-if="product.rating" class="text-[10px] text-yellow-500 font-bold">{{ product.rating }} ★</span>
        </div>

        <div class="flex items-center gap-2">
          <!-- Add to Cart: circle with + sign only, no text -->
          <button
            @click="handleAddToCart($event)"
            class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-slate-900 text-white shadow-sm transition-all duration-300 hover:bg-black hover:scale-110 active:scale-95"
            title="Add to Cart"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
          </button>

          <!-- Buy Now: white bg, black text "BUY", no icon -->
          <button
            @click="handleBuyNow($event)"
            class="flex-shrink-0 rounded-full bg-white text-slate-900 px-4 py-1.5 text-[10px] font-bold shadow-sm border border-slate-200 transition-all duration-300 hover:bg-slate-900 hover:text-white hover:border-slate-900 hover:scale-105 active:scale-95"
            title="Buy Now"
          >
            BUY
          </button>
        </div>
      </div>
    </div>
  </div>
</template>