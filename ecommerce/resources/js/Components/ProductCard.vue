<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'
import useCart from '@/composables/useCart'
import useAuthModal from '@/composables/useAuthModal'
import { resolveImage } from '@/utils/imageHelper'

const props = defineProps({
  product: {
    type: Object,
    required: true
  },
  // Layout variant: 'grid' (default) for standard card grid
  // 'list' for a horizontal/list style
  variant: {
    type: String,
    default: 'grid'
  }
})

const { addToCart, setBuyNowItem } = useCart()
const { openAuthModal } = useAuthModal()

// Determine if product is on sale
const hasSale = computed(() => {
  return props.product.sale_price !== undefined &&
    props.product.sale_price !== null &&
    props.product.originalPrice !== undefined &&
    props.product.originalPrice !== null &&
    props.product.sale_price < props.product.originalPrice
})

// Calculate discount percentage: 100 - (sale_price / original_price * 100)
const discountPercent = computed(() => {
  if (!hasSale.value) return 0
  const original = parseFloat(props.product.originalPrice)
  const sale = parseFloat(props.product.sale_price)
  if (!original || original === 0) return 0
  return Math.round(100 - (sale / original * 100))
})

// Format price for display
const displayPrice = computed(() => {
  if (hasSale.value) {
    return new Intl.NumberFormat('en-PH', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(parseFloat(props.product.sale_price))
  }
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(parseFloat(props.product.price))
})

const originalPriceDisplay = computed(() => {
  if (!hasSale.value) return null
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(parseFloat(props.product.originalPrice))
})

// Navigation
const goToProduct = () => {
  router.visit(`/products/${props.product.id}`)
}

// Cart actions
const handleAddToCart = (e) => {
  e.stopPropagation()
  const item = {
    id: props.product.id,
    name: props.product.name,
    price: hasSale.value ? parseFloat(props.product.sale_price) : parseFloat(props.product.price),
    originalPrice: props.product.originalPrice ? parseFloat(props.product.originalPrice) : null,
    image: props.product.image,
    category: props.product.category,
  }
  console.log('[ProductCard] handleAddToCart item prepared:', item)
  addToCart(item)
  console.log('[ProductCard] addToCart called')
}

const handleBuyNow = (e) => {
  e.stopPropagation()
  const item = {
    id: props.product.id,
    name: props.product.name,
    price: hasSale.value ? parseFloat(props.product.sale_price) : parseFloat(props.product.price),
    originalPrice: props.product.originalPrice ? parseFloat(props.product.originalPrice) : null,
    image: props.product.image,
    category: props.product.category,
  }
  setBuyNowItem(item, 1, null, null)
  router.visit('/checkout')
}
</script>

<template>
  <div
    class="group cursor-pointer flex flex-col overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    :class="variant === 'list' ? 'flex-row' : ''"
    @click="goToProduct"
  >
    <!-- Image Container -->
    <div
      class="relative overflow-hidden bg-white"
      :class="variant === 'list' ? 'w-40 h-40 flex-shrink-0 rounded-l-[1.5rem]' : 'aspect-square w-full p-3'"
    >
      <img
        :src="resolveImage(product.image)"
        :alt="product.name"
        class="h-full w-full object-contain transition duration-500 group-hover:scale-105"
        :class="variant === 'list' ? 'object-cover rounded-l-[1.5rem]' : ''"
      />

      <!-- Sale Badge: top-right corner, red pill -->
      <div
        v-if="hasSale"
        class="absolute top-2 right-2 bg-red-500 text-white rounded-full px-2.5 py-1 text-[10px] font-black tracking-wide shadow-md flex items-center gap-1"
      >
        <span class="font-black">{{ discountPercent }}%</span>
        <span class="font-semibold">OFF</span>
      </div>
    </div>

    <!-- Content Section -->
    <div
      class="p-3 flex flex-col flex-grow"
      :class="variant === 'list' ? 'py-3 pr-3' : ''"
    >
      <!-- Category + Sale status -->
      <div class="flex items-center justify-between gap-2 text-[10px] uppercase tracking-wider text-slate-500 font-bold">
        <span>{{ product.category }}</span>
      </div>

      <h2 class="mt-2 text-sm font-bold text-slate-900 line-clamp-1">{{ product.name }}</h2>
      <p v-if="product.description" class="mt-1 text-[11px] leading-4 text-slate-500 line-clamp-2">{{ product.description }}</p>

      <!-- Price & Actions -->
      <div class="mt-auto pt-3 flex items-center justify-between gap-2">
        <div class="flex flex-col">
          <span class="text-sm font-black text-slate-900">₱{{ displayPrice }}</span>
          <span v-if="hasSale" class="text-[10px] text-slate-400 line-through font-medium">₱{{ originalPriceDisplay }}</span>
          <span v-if="product.rating" class="text-[10px] text-yellow-500 font-bold">{{ product.rating }} ★</span>
        </div>

        <div class="flex items-center gap-1.5">
          <button
            @click="handleAddToCart($event)"
            class="flex-shrink-0 rounded-full bg-black p-2 text-white shadow-md transition hover:bg-slate-800 hover:scale-105 active:scale-95"
            title="Add to Cart"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
          </button>
          <button
            @click="handleBuyNow($event)"
            class="flex-shrink-0 rounded-full bg-slate-900 p-2 text-white shadow-md transition hover:bg-slate-700 hover:scale-105 active:scale-95"
            title="Buy Now"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3.75a.75.75 0 01.75.75v3.5h3.5a.75.75 0 010 1.5h-3.5v3.5a.75.75 0 01-1.5 0v-3.5h-3.5a.75.75 0 010-1.5h3.5v-3.5A.75.75 0 0110 3.75z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>