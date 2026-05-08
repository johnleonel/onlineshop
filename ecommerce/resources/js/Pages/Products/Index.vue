<template>
  <AppLayout>
    <Head title="Products" />

    <div class="max-w-7xl mx-auto px-3 pt-0 pb-8">
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
        </div>
      </div>

      <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
          <!-- Tabs Section -->
          <div class="relative inline-block text-left">
            <div>
              <button
                @click="isDropdownOpen = !isDropdownOpen"
                type="button"
                class="inline-flex w-full justify-between items-center gap-x-2 rounded-full border border-slate-900 bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all focus:outline-none"
              >
                <!-- Dinamiko na label base sa napili -->
                Category: {{ categories.find(c => c.id === selectedTab)?.label || 'All' }}
                <svg class="-mr-1 h-5 w-5 text-slate-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <!-- Dropdown Menu -->
            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="isDropdownOpen"
                class="absolute left-0 z-50 mt-2 w-56 origin-top-left rounded-2xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
              >
              <div class="py-1">
                <button
                  v-for="category in categories"
                  :key="category.id"
                  @click="selectCategory(category.id)"
                  class="block w-full text-left px-4 py-3 text-sm transition-colors hover:bg-slate-50"
                  :class="selectedTab === category.id ? 'bg-slate-50 font-bold text-slate-900' : 'text-slate-600'"
                >
                  {{ category.label }}
                </button>
              </div>
            </div>
          </transition>
        </div>

          <!-- Modern Search Bar Section -->
          <div class="relative w-full lg:w-80 group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
              <svg 
                class="h-5 w-5 text-slate-400 group-focus-within:text-slate-900 transition-colors duration-200" 
                viewBox="0 0 20 20" 
                fill="currentColor"
              >
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1111.196 3.342l3.33 3.33a1 1 0 01-1.414 1.415l-3.33-3.33A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search products..."
              class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-10 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-slate-900 focus:bg-white focus:ring-4 focus:ring-slate-900/5 outline-none shadow-sm"
            />

            <!-- Clear Button -->
            <button 
              v-if="searchQuery"
              @click="searchQuery = ''"
              type="button"
              class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition-colors"
            >
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Grid Section -->
        <div class="mt-8 grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
          <div
            v-for="product in filteredProducts"
            :key="product.id"
            class="flex flex-col overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md cursor-pointer"
            @click="goToProduct(product.id)"
          >
            <!-- Image Container -->
            <div class="aspect-square w-full overflow-hidden bg-white p-3"> 
              <img
                :src="product.image"
                :alt="product.name"
                class="h-full w-full object-contain transition duration-500 hover:scale-105"
              />
            </div>

            <!-- Content Section -->
            <div class="p-3 flex flex-col flex-grow">
              <div class="flex items-center justify-between gap-2 text-[10px] uppercase tracking-wider text-slate-500 font-bold">
                <span>{{ product.category }}</span>
                <span class="rounded-full bg-white px-2 py-0.5 text-green-600 border border-slate-100">{{ product.statusLabel }}</span>
              </div>

              <h2 class="mt-2 text-sm font-bold text-slate-900 line-clamp-1">{{ product.name }}</h2>
              <p class="mt-1 text-[11px] leading-4 text-slate-500 line-clamp-2">{{ product.description }}</p>
              
              <!-- Price & Rating -->
              <div class="mt-auto pt-3">
                <p class="text-sm font-black text-slate-900">₱{{ formatPrice(product.price) }}</p>
                <p class="text-[10px] text-yellow-500 font-bold">{{ product.rating }} ★</p>
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

// --- DITO MO ILALAGAY ANG MGA BAGONG REFS ---
const isDropdownOpen = ref(false)
const selectedTab = ref(props.selectedCategory || 'all')
const searchQuery = ref('')

// Listahan para sa loop ng dropdown
const categories = [
  { id: 'all', label: 'All Products' },
  { id: 'polo', label: 'Polo' },
  { id: 'tshirt', label: 'T-shirt' },
  { id: 'hoodie', label: 'Hoodie' },
  { id: 'shorts', label: 'Shorts' },
  { id: 'jackets', label: 'Jackets' },
  { id: 'pants', label: 'Pants' },
]

// Function para sa pagpili sa dropdown
const selectCategory = (categoryId) => {
  selectedTab.value = categoryId;
  isDropdownOpen.value = false;
  
  // Tatawag sa backend para sa filtering
  if (categoryId === 'all') {
    router.get(route('products.index'));
  } else {
    router.get(route('products.index', { category: categoryId }));
  }
}
// ------------------------------------------

const { addToCart } = useCart()

const handleAddToCart = (product) => {
  addToCart(product);
};

const goToProduct = (productId) => {
  router.get(`/products/${productId}`);
};

const filteredProducts = computed(() => {
  let results = props.products;

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