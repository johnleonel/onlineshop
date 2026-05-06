<script setup>
import { ref } from 'vue';

const props = defineProps({
  collections: {
    type: Array,
    default: () => [
      {
        name: 'ALL DESIGN',
        items: [
          { id: 1, name: 'TROPICAL POLO', price: 875.00, image: '/images/hood1.jpg', category: 'POLO' },
          { id: 2, name: 'DJ ', price: 1000.00, image: '/images/hood2.jpg', category: 'Longsleeves' },
          { id: 3, name: 'RACISM', price: 1000.00, image: '/images/hood3.jpg', category: 'Longsleeves' },
          { id: 4, name: 'BMW (BLACK) TEE', price: 850.00, image: '/images/hood4.jpg', category: 'Tee' },
          { id: 5, name: 'REDBULL RACING', price: 850.00, image: '/images/hood5.jpg', category: 'Tee' },
          { id: 6, name: 'FERARI RACING', price: 800.00, image: '/images/hood6.jpg', category: 'Tee', discount: 5 },
          { id: 7, name: 'DUCATI RACING', price: 750.00, image: '/images/hood7.jpg', category: 'Tee' },
          { id: 8, name: 'CLASSIC TEE', price: 700.00, image: '/images/hood8.jpg', category: 'Tee' },
        ]
      },
      {
        name: 'STREET STYLE',
        items: [
          { id: 13, name: 'SUMMER HOODIE', price: 2100.00, image: '/images/hood2.jpg', category: 'Hoodie' },
          { id: 14, name: 'TROPICAL TEE', price: 900.00, image: '/images/hood10.jpg', category: 'Tee' },
        ]
      },
      {
        name: 'BASIC',
        items: [
          { id: 15, name: 'FIRE TEE', price: 950.00, image: '/images/hood11.jpg', category: 'Tee' },
        ]
      },
      {
        name: 'STRAIN',
        items: [
          { id: 16, name: 'ATHLETIC WEAR', price: 1200.00, image: '/images/hood1.jpg', category: 'Athletic' },
        ]
      },
      {
        name: 'GRATEFUL',
        items: [
          { id: 17, name: 'PEACE TEE', price: 850.00, image: '/images/hood12.jpg', category: 'Tee' },
        ]
      },
      {
        name: 'ITS ALL WORTH IT',
        items: [
          { id: 18, name: 'WORTH IT TEE', price: 950.00, image: '/images/hood8.jpg', category: 'Tee' },
        ]
      },
    ]
  }
});

const activeCollectionIndex = ref(0);
const activeCollection = ref(props.collections[0]);

const selectCollection = (index) => {
  activeCollectionIndex.value = index;
  activeCollection.value = props.collections[index];
};

const formatPrice = (price) => {
  return price.toFixed(2);
};
</script>

<template>
  <div class="w-full bg-white py-12 px-4 md:px-8">
    <!-- Section Title -->
    <div class="max-w-7xl mx-auto mb-8">
      <h2 class="text-4xl md:text-5xl font-bold text-center text-gray-900 tracking-tight mb-10">
        COLLECTIONS
      </h2>

      <!-- Collection Tabs -->
      <div class="flex flex-wrap gap-3 md:gap-6 justify-center mb-12 border-b border-gray-200 pb-6">
        <button
          v-for="(collection, index) in collections"
          :key="index"
          @click="selectCollection(index)"
          :class="[
            'text-sm md:text-base font-medium tracking-wide px-2 md:px-4 py-2 transition-all duration-300',
            activeCollectionIndex === index
              ? 'text-gray-900 border-b-2 border-gray-900'
              : 'text-gray-400 hover:text-gray-600'
          ]"
        >
          {{ collection.name }}
        </button>
      </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="item in activeCollection.items"
          :key="item.id"
          class="group cursor-pointer"
        >
          <!-- Product Image Container -->
          <div class="relative overflow-hidden rounded-lg bg-gray-100 mb-4 aspect-square">
            <img
              :src="item.image"
              :alt="item.name"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
            
            <!-- Discount Badge -->
            <div
              v-if="item.discount"
              class="absolute top-3 right-3 bg-red-500 text-white rounded-full px-3 py-1 text-xs font-bold"
            >
              -{{ item.discount }}%
            </div>
          </div>

          <!-- Product Info -->
          <div class="text-center">
            <h3 class="text-sm md:text-base font-semibold text-gray-900 mb-2 line-clamp-2">
              {{ item.name }}
            </h3>
            <p class="text-base md:text-lg font-bold text-gray-900">
              ₱{{ formatPrice(item.price) }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
