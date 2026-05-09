<template>
  <AppLayout>
    <Head title="New Drops | CHILLEROX" />

    <div class="max-w-7xl mx-auto px-4 py-12">
      <!-- Hero Banner -->
      <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-black to-slate-800 p-8 md:p-12 mb-12">
        <div class="relative z-10">
          <span class="inline-block px-4 py-1 bg-red-500 text-white text-xs font-bold uppercase tracking-wider rounded-full mb-4 animate-pulse">
            Limited Edition
          </span>
          <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-4">NEW DROPS</h1>
          <p class="text-slate-300 text-lg max-w-xl">Discover our latest collection of exclusive releases. Limited quantities available.</p>
        </div>
        <div class="absolute top-0 right-0 w-64 h-full opacity-20">
          <img src="/images/slide4.jpg" class="w-full h-full object-cover" alt="" />
        </div>
      </div>

      <!-- Filter Tabs -->
      <div class="flex flex-wrap gap-3 mb-8">
        <button
          v-for="filter in filters"
          :key="filter"
          @click="selectedFilter = filter"
          :class="[
            'px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300',
            selectedFilter === filter
              ? 'bg-black text-white'
              : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
          ]"
        >
          {{ filter }}
        </button>
      </div>

      <!-- Products Grid -->
      <div v-if="products.length" class="grid gap-6 grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div
          v-for="product in filteredProducts"
          :key="product.id"
          class="group flex flex-col overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm transition-all duration-500 hover:shadow-xl hover:-translate-y-1 cursor-pointer"
          @click="goToProduct(product.id)"
        >
          <!-- Image Container -->
          <div class="relative aspect-square w-full overflow-hidden bg-slate-50">
            <img
              :src="resolveImage(product.image) || '/images/placeholder.jpg'"
              :alt="product.name"
              class="h-full w-full object-contain transition-all duration-500 group-hover:scale-110"
            />
            <div class="absolute top-4 left-4">
              <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                NEW DROP
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-4 flex flex-col gap-2">
            <span class="text-xs uppercase tracking-wider text-slate-500 font-semibold">{{ product.category }}</span>
            <h3 class="font-bold text-slate-900 group-hover:text-black">{{ product.name }}</h3>
            <p class="text-sm text-slate-500 line-clamp-2">{{ product.description }}</p>
            <div class="flex items-center justify-between mt-2">
              <span class="text-lg font-black text-slate-900">₱{{ formatPrice(product.price) }}</span>
              <button
                @click.stop="handleAddToCart(product)"
                class="px-3 py-2 bg-black text-white text-xs font-semibold rounded-full transition-all duration-300 hover:bg-slate-800"
              >
                + Add to Cart
              </button>
              <button
                @click.stop="handleBuyNow(product)"
                class="px-3 py-2 bg-slate-900 text-white text-xs font-semibold rounded-full transition-all duration-300 hover:bg-slate-700"
              >
                Buy Now
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-20">
        <div class="text-6xl mb-4">📦</div>
        <h2 class="text-2xl font-bold text-slate-900 mb-2">No New Drops Available</h2>
        <p class="text-slate-500">Check back soon for our latest releases!</p>
        <Link
          :href="route('products.index')"
          class="inline-block mt-6 px-6 py-3 bg-black text-white font-semibold rounded-full hover:bg-slate-800 transition"
        >
          Browse All Products
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import useCart from '@/composables/useCart'
import { resolveImage } from '@/utils/imageHelper'

const props = defineProps({
  products: {
    type: Array,
    default: () => []
  }
})

const { addToCart, setBuyNowItem } = useCart()
const selectedFilter = ref('All')

const filters = ['All', 'Polo', 'Tshirt', 'Hoodie', 'Jackets', 'Pants']

const filteredProducts = computed(() => {
  if (selectedFilter.value === 'All') {
    return props.products
  }
  return props.products.filter(p => p.category && p.category.toLowerCase() === selectedFilter.value.toLowerCase())
})

const goToProduct = (productId) => {
  router.get('/products/' + productId)
}

const handleAddToCart = (product) => {
  addToCart(product)
}

const handleBuyNow = (product) => {
  setBuyNowItem(product, 1, null, null)
  router.visit('/checkout')
}

const formatPrice = (price) => {
  return parseFloat(price || 0).toFixed(2)
}
</script>