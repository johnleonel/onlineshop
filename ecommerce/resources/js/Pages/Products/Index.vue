<template>
  <AppLayout>
    <Head title="Products" />

    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
          <p class="text-sm uppercase tracking-[0.28em] text-slate-500">Management Product</p>
          <h1 class="mt-2 text-3xl font-semibold text-slate-900">Add Product to your store</h1>
          <p class="mt-2 text-sm text-slate-500">Showing {{ selectedCategory === 'all' ? 'All Products' : selectedCategory.charAt(0).toUpperCase() + selectedCategory.slice(1) }}</p>
        </div>
        <button
          type="button"
          class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
        >
          Add Product
        </button>
      </div>

      <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div class="flex flex-wrap items-center gap-3">
            <button
              type="button"
              :class="selectedTab === 'all' ? activeTabClass : tabClass"
              @click="selectedTab = 'all'"
            >
              All
            </button>
            <button
              type="button"
              :class="selectedTab === 'active' ? activeTabClass : tabClass"
              @click="selectedTab = 'active'"
            >
              Active
            </button>
            <button
              type="button"
              :class="selectedTab === 'non-active' ? activeTabClass : tabClass"
              @click="selectedTab = 'non-active'"
            >
              Non Active
            </button>
          </div>

          <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between w-full lg:w-auto">
            <div class="flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-4 py-2 shadow-sm">
              <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1111.196 3.342l3.33 3.33a1 1 0 01-1.414 1.415l-3.33-3.33A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search Product"
                class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
              />
            </div>
          </div>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
          <div
            v-for="product in filteredProducts"
            :key="product.id"
            class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md cursor-pointer"
            @click="goToProduct(product.id)"
          >
            <div class="overflow-hidden bg-slate-900">
              <img
                :src="product.image"
                :alt="product.name"
                class="h-36 w-full object-cover transition duration-300 hover:scale-105"
              />
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between gap-2 text-xs text-slate-500">
                <span>{{ product.category }}</span>
                <span class="rounded-full bg-white px-2 py-1 text-slate-700">{{ product.statusLabel }}</span>
              </div>
              <h2 class="mt-3 text-lg font-semibold text-slate-900">{{ product.name }}</h2>
              <p class="mt-2 text-sm leading-5 text-slate-600 line-clamp-2">{{ product.description }}</p>
              <div class="mt-3 flex items-center justify-between gap-3 text-xs">
                <div>
                  <p class="text-base font-semibold text-slate-900">${{ formatPrice(product.price) }}</p>
                  <p class="text-[11px] text-slate-500">{{ product.rating }} ★</p>
                </div>
                <button
                  type="button"
                  class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-900 text-white transition hover:bg-slate-700"
                  aria-label="Add product"
                  @click.stop="handleAddToCart(product)"
                >
                  <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-if="filteredProducts.length === 0" class="mt-8 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
          No products found.
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import useCart from '@/composables/useCart'

const props = defineProps({
  products: {
    type: Array,
    default: () => []
  },
  selectedCategory: {
    type: String,
    default: 'all'
  }
})

const selectedTab = ref('all')
const searchQuery = ref('')

const tabClass = 'rounded-full border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:text-slate-900'
const activeTabClass = 'rounded-full border border-slate-900 bg-slate-900 px-5 py-2 text-sm font-medium text-white transition'

const { addToCart } = useCart();

const handleAddToCart = (product, quantity = 1) => {
  addToCart(product, quantity);
};

const goToProduct = (productId) => {
  router.get(`/products/${productId}`);
};

const filteredProducts = computed(() => {
  return props.products
    .filter((product) => {
      if (selectedTab.value === 'active') {
        return product.status === 'active'
      }
      if (selectedTab.value === 'non-active') {
        return product.status === 'non-active'
      }
      return true
    })
    .filter((product) => {
      if (!searchQuery.value) return true
      const query = searchQuery.value.toLowerCase()
      return (
        product.name.toLowerCase().includes(query) ||
        product.category.toLowerCase().includes(query) ||
        product.description.toLowerCase().includes(query)
      )
    })
})

const formatPrice = (price) => parseFloat(price).toFixed(2)
</script>

<style scoped>
/* no additional styles needed */
</style>