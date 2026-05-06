<template>
  <AppLayout>
    <Head title="Products" />

    <div class="max-w-7xl mx-auto px-3 pt-0 pb-8">
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
        </div>
      </div>

      <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div class="flex flex-wrap items-center gap-3">
            <button
              type="button"
              :class="selectedTab === 'all' ? activeTabClass : tabClass"
              @click="router.get(route('products.index'))"
            >
              All
            </button>
            <button
              type="button"
              :class="selectedTab === 'polo' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'polo' }))"
            >
              Polo
            </button>
            <button
              type="button"
              :class="selectedTab === 'tshirt' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'tshirt' }))"
            >
              T-shirt
            </button>
            <button
              type="button"
              :class="selectedTab === 'hoodie' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'hoodie' }))"
            >
              Hoodie
            </button>
            <button
              type="button"
              :class="selectedTab === 'shorts' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'shorts' }))"
            >
              Shorts
            </button>
            <button
              type="button"
              :class="selectedTab === 'jackets' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'jackets' }))"
            >
              Jackets
            </button>

            <button
              type="button"
              :class="selectedTab === 'pants' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'pants' }))"
            >
              Pants
            </button>

            <button
              type="button"
              :class="selectedTab === 'accessories' ? activeTabClass : tabClass"
              @click="router.get(route('products.index', { category: 'accessories' }))"
            >
              Accessories
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


          <!-- Grid Section -->
          <div class="mt-6 grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            <div
              v-for="product in filteredProducts"
              :key="product.id"
              class="flex flex-col overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md cursor-pointer"
              @click="goToProduct(product.id)"
            >
              <!-- Image Container: Naka-Contain na para buo ang shirt -->
              <div class="aspect-square w-full overflow-hidden bg-white p-3"> 
                <img
                  :src="product.image"
                  :alt="product.name"
                  class="h-full w-full object-contain transition duration-500 hover:scale-105"
                />
              </div>

              <!-- Content Section: Binawasan ang padding mula p-4 gawing p-3 -->
              <div class="p-3 flex flex-col flex-grow">
                <div class="flex items-center justify-between gap-2 text-[10px] uppercase tracking-wider text-slate-500 font-bold">
                  <span>{{ product.category }}</span>
                  <span class="rounded-full bg-white px-2 py-0.5 text-green-600 border border-slate-100">{{ product.statusLabel }}</span>
                </div>

                <!-- Name: Ginawang text-sm at line-clamp para hindi humaba -->
                <h2 class="mt-2 text-sm font-bold text-slate-900 line-clamp-1">{{ product.name }}</h2>
                
                <!-- Description: Binawasan ang size para mag-fit -->
                <p class="mt-1 text-[11px] leading-4 text-slate-500 line-clamp-2">{{ product.description }}</p>
                
                <!-- Price & Actions -->
                <div class="mt-auto pt-3 flex items-center justify-between gap-2">
                  <div>
                    <p class="text-sm font-black text-slate-900">₱{{ formatPrice(product.price) }}</p>
                    <p class="text-[10px] text-yellow-500 font-bold">{{ product.rating }} ★</p>
                  </div>
                  
                  <div class="flex gap-1">
                    <!-- Compact Buy Button -->
                    <button
                      type="button"
                      class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-3 py-1.5 text-[11px] font-bold text-white transition hover:bg-slate-700"
                      @click.stop="handleBuy(product)"
                    >
                      Buy
                    </button>
                    
                    <!-- Compact Plus Button -->
                    <button
                      type="button"
                      class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-900 text-white transition hover:bg-slate-700"
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

const selectedTab = ref(props.selectedCategory || 'all')
const searchQuery = ref('')
const { addToCart } = useCart() 

// I-update ang handleAddToCart function para tawagin ang composable
const handleAddToCart = (product) => {
  addToCart(product);
  // Optional: Magdagdag ng notification dito kung gusto mo
 
};

const tabClass = 'rounded-full border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:text-slate-900'
const activeTabClass = 'rounded-full border border-slate-900 bg-slate-900 px-5 py-2 text-sm font-medium text-white transition'

const handleBuy = (product) => {
  // For now, same as add to cart - you can customize this to go to checkout or product page
  handleAddToCart(product);
};

const goToProduct = (productId) => {
  router.get(`/products/${productId}`);
};

const filteredProducts = computed(() => {
  let results = props.products;

  // 1. Filter gamit ang Tabs/Category
  if (selectedTab.value !== 'all') {
    results = results.filter((product) => {
      const category = product.category.toLowerCase();
      const tab = selectedTab.value.toLowerCase();
      if (tab === 'tshirt') {
        return category === 't-shirt' || category === 'tshirt';
      }
      return category === tab;
    });
  }

  // 2. Filter gamit ang Search Bar (Functional na kahit 1st letter lang)
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    results = results.filter((product) => {
      return (
        product.name.toLowerCase().includes(query) ||
        product.category.toLowerCase().includes(query)
      );
    });
  }

  return results;
});

const formatPrice = (price) => {
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price);
}
</script>

<style scoped>
/* no additional styles needed */
</style>