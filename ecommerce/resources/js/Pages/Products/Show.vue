<template>
  <AppLayout>
    <Head :title="product.name" />

    <div class="max-w-7xl mx-auto px-4 py-10">
      <div class="mb-6 flex items-center gap-3 text-sm text-slate-500">
        <Link href="/products" class="hover:text-slate-900 font-medium">Products</Link>
        <span>/</span>
        <span class="text-slate-900">{{ product.name }}</span>
      </div>

      <div class="grid gap-10 lg:grid-cols-[1.45fr_0.95fr]">
        <section class="space-y-6">
          <div class="rounded-[2rem] bg-white p-6 shadow-sm">
            <img
              :src="product.image"
              :alt="product.name"
              class="w-full rounded-[2rem] object-cover"
            />

            <div class="mt-5 grid gap-3 sm:grid-cols-5">
              <button
                v-for="(thumb, index) in thumbnailImages"
                :key="index"
                type="button"
                class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 transition hover:border-slate-300"
              >
                <img :src="thumb" :alt="`${product.name} preview ${index + 1}`" class="h-20 w-full object-cover" />
              </button>
              <button
                v-if="moreThumbnails > 0"
                type="button"
                class="group overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 text-center text-slate-500 transition hover:border-slate-300"
              >
                <div class="flex h-20 flex-col items-center justify-center">
                  <span class="text-xl font-semibold">+{{ moreThumbnails }}</span>
                  <span class="text-xs">more</span>
                </div>
              </button>
            </div>
          </div>

          <div class="rounded-[2rem] bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
              <div>
                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Peanuts Long Sleeve Sweatshirt</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">{{ product.name }}</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600">
                  A baseball-themed collection, a favorite of the Peanuts friends. This collection features Snoopy and his friends enjoying baseball...
                </p>
              </div>

              <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex items-center gap-3 text-sm text-slate-700">
                  <span class="font-semibold">5K+ Sold</span>
                  <span class="flex items-center gap-1 text-amber-500">4.9</span>
                  <span class="text-slate-400">(225 reviews)</span>
                </div>
              </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_auto] lg:items-end">
              <div>
                <div class="flex items-center gap-4">
                  <p class="text-4xl font-bold text-slate-900">${{ formatPrice(product.price) }}</p>
                  <p class="text-sm text-slate-400 line-through">${{ formatPrice(originalPrice) }}</p>
                </div>
              </div>
              <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-4 py-2 text-sm text-slate-600">
                <span class="font-semibold text-slate-900">Color:</span>
                <span>{{ selectedColorLabel }}</span>
              </div>
            </div>

            <div class="mt-8 grid gap-4">
              <div>
                <div class="flex items-center gap-3 text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">Color</div>
                <div class="mt-4 flex items-center gap-3">
                  <button
                    v-for="color in colors"
                    :key="color.name"
                    type="button"
                    :class="['h-11 w-11 rounded-full border transition', color.name === selectedColor ? 'border-slate-900' : 'border-slate-200']"
                    :style="{ backgroundColor: color.code }"
                    @click="selectedColor = color.name"
                    :aria-label="color.name"
                  ></button>
                </div>
              </div>

              <div>
                <div class="flex items-center gap-3 text-sm font-semibold uppercase tracking-[0.28em] text-slate-500">Size</div>
                <div class="mt-4 flex flex-wrap gap-3">
                  <button
                    v-for="size in sizes"
                    :key="size"
                    type="button"
                    @click="selectedSize = size"
                    :class="[
                      'min-w-[46px] rounded-2xl border px-3 py-2 text-sm font-semibold transition',
                      selectedSize === size ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-200 bg-white text-slate-700'
                    ]"
                  >
                    {{ size }}
                  </button>
                </div>
              </div>
            </div>

            <div class="mt-8 grid gap-3 sm:grid-cols-[1fr_auto]">
              <button
                type="button"
                class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-6 py-4 text-sm font-semibold text-white transition hover:bg-emerald-700"
                @click="handleAddToCart"
              >
                + Add to Cart
              </button>
              <button
                type="button"
                class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-4 text-sm font-semibold text-slate-900 transition hover:bg-slate-50"
              >
                Buy this Item
              </button>
            </div>

            <div class="mt-6 flex flex-wrap gap-3 text-sm text-slate-500">
              <button type="button" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 transition hover:border-slate-300">
                <span>💬</span>
                Chat
              </button>
              <button type="button" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 transition hover:border-slate-300">
                <span>🤍</span>
                Wishlist
              </button>
              <button type="button" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 transition hover:border-slate-300">
                <span>↗</span>
                Share
              </button>
            </div>
          </div>

          <div class="rounded-[2rem] bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center gap-4 border-b border-slate-200 pb-4">
              <button
                v-for="tab in tabs"
                :key="tab"
                type="button"
                @click="selectedTab = tab"
                :class="[
                  'rounded-full px-4 py-2 text-sm font-semibold transition',
                  selectedTab === tab ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                ]"
              >
                {{ tab }}
              </button>
            </div>

            <div class="mt-6">
              <div v-if="selectedTab === 'Reviews'" class="grid gap-6 xl:grid-cols-[0.95fr_0.65fr]">
                <div class="space-y-4">
                  <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center gap-4">
                      <div class="text-5xl font-bold text-slate-900">4.9</div>
                      <div>
                        <div class="text-sm text-slate-500">Rating</div>
                        <div class="mt-1 text-sm text-slate-500">225 reviews</div>
                      </div>
                    </div>
                  </div>

                  <div class="space-y-4">
                    <div class="rounded-[1.75rem] border border-slate-200 p-5">
                      <div class="flex items-start justify-between gap-4">
                        <div>
                          <p class="text-sm font-semibold text-slate-900">James Gouse</p>
                          <p class="mt-1 text-xs text-slate-500">Oct 13, 2024</p>
                        </div>
                        <div class="flex items-center gap-1 text-amber-500">
                          <span>★★★★★</span>
                        </div>
                      </div>
                      <p class="mt-4 text-sm leading-6 text-slate-600">
                        A simple Sweater but makes the user seem neat and beautiful, the material is soft, but when worn it often wrinkles because of sitting for too long.
                      </p>
                    </div>
                  </div>
                </div>

                <div class="space-y-4">
                  <div v-for="rating in ratingBars" :key="rating.label" class="space-y-2">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                      <span>{{ rating.label }}</span>
                      <span>{{ rating.count }}</span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-200">
                      <div :style="{ width: rating.width }" class="h-full rounded-full bg-emerald-600"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-else class="text-sm text-slate-600">
                <p>More information will appear here for the selected tab.</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import useCart from '@/composables/useCart'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const { addToCart } = useCart()
const quantity = ref(1)
const selectedColor = ref('Green')
const selectedSize = ref('S')
const colors = [
  { name: '53 Green', code: '#8AA491' },
  { name: '12 Peach', code: '#E0C7B0' },
  { name: '88 Gray', code: '#D9D9D9' },
]
const sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL']
const tabs = ['Details', 'Reviews', 'Discussion']
const selectedTab = ref('Reviews')

const thumbnailImages = [
  props.product.image,
  props.product.image,
  props.product.image,
  props.product.image,
]
const moreThumbnails = 4

const originalPrice = computed(() => props.product.price + 34)
const selectedColorLabel = computed(() => selectedColor)

const ratingBars = [
  { label: '5', count: 184, width: '75%' },
  { label: '4', count: 63, width: '45%' },
  { label: '3', count: 29, width: '25%' },
  { label: '2', count: 7, width: '12%' },
  { label: '1', count: 2, width: '5%' },
]

const formatPrice = (price) => parseFloat(price).toFixed(2)

const handleAddToCart = () => {
  addToCart(props.product, quantity.value)
}

const increaseQuantity = () => {
  quantity.value += 1
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value -= 1
  }
}
</script>

<style scoped>
button:focus {
  outline: none;
}
</style>
