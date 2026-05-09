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
          <ProductCard
            v-for="product in filteredProducts"
            :key="product.id"
            :product="product"
          />
        </div>

        <div v-if="filteredProducts.length === 0" class="mt-8 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
          No products found.
        </div>
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

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import ProductCard from '@/Components/ProductCard.vue'

const page = usePage()
const isAuthenticated = computed(() => !!page.props.auth?.user)

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

const toastVisible = ref(false)
const addedToastName = ref('')

const showAddedToast = (productName) => {
  addedToastName.value = productName
  toastVisible.value = true
  setTimeout(() => {
    toastVisible.value = false
  }, 2500)
}

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