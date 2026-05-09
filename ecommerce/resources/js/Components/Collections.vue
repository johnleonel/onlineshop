<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import ProductCard from '@/Components/ProductCard.vue'
import useCart from '@/composables/useCart'

const { addToCart } = useCart()

const props = defineProps({
  collections: {
    type: Object,
    default: () => ({})
  }
})

const collectionNames = computed(() => Object.keys(props.collections))
const activeCollectionIndex = ref(0)
const activeCollectionName = computed(() => collectionNames.value[activeCollectionIndex.value] || '')
const activeCollectionItems = computed(() => props.collections[activeCollectionName.value] || [])

const selectCollection = (index) => {
  activeCollectionIndex.value = index
}

const goToProducts = () => {
  router.visit('/products')
}
</script>

<template>
  <div class="w-full bg-white py-12 px-4 md:px-8">
    <div class="max-w-7xl mx-auto mb-8">
      <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-900 tracking-tight mb-10">
        COLLECTIONS
      </h2>

      <div v-if="collectionNames.length > 0" class="flex flex-wrap gap-3 md:gap-6 justify-center mb-12 border-b border-gray-200 pb-6">
        <button
          v-for="(name, index) in collectionNames"
          :key="index"
          @click="selectCollection(index)"
          :class="[
            'text-sm md:text-base font-medium tracking-wide px-2 md:px-4 py-2 transition-all duration-300',
            activeCollectionIndex === index
              ? 'text-gray-900 border-b-2 border-gray-900'
              : 'text-gray-400 hover:text-gray-600'
          ]"
        >
          {{ name }}
        </button>
      </div>
    </div>

    <div class="max-w-7xl mx-auto">
      <div v-if="activeCollectionItems.length === 0" class="text-center text-slate-400 py-12">
        No items in this collection.
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <ProductCard
          v-for="item in activeCollectionItems"
          :key="item.id"
          :product="item"
        />
      </div>

      <div class="mt-16 flex justify-center">
        <button
          @click="goToProducts"
          class="group relative overflow-hidden px-10 py-4 bg-black text-white font-bold tracking-widest transition-all duration-300 ease-in-out hover:bg-gray-900 hover:shadow-2xl hover:-translate-y-1 active:scale-95 rounded-sm uppercase text-sm"
        >
          <span class="relative z-10">View All Collection</span>
          <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes shimmer {
  100% {
    transform: translateX(100%);
  }
}

.group:hover .group-hover:animate-[shimmer_1.5s_infinite] {
  animation: shimmer 1.5s infinite;
}
</style>