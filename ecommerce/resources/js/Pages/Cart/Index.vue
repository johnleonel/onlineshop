<template>
  <AppLayout>
    <Head title="Shopping Cart | CHILLEROX" />

    <div class="max-w-5xl mx-auto px-4 py-12">
      <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-black text-slate-900">Shopping Cart</h1>
        <button
          v-if="items.length"
          @click="toggleSelectAll"
          class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition"
        >
          {{ allSelected ? 'Deselect All' : 'Select All' }}
        </button>
      </div>

      <div v-if="items.length" class="grid gap-8 lg:grid-cols-[1fr_380px]">
        <!-- Cart Items -->
        <div class="space-y-4">
          <div
            v-for="item in items"
            :key="itemKey(item)"
            :class="[
              'flex gap-4 p-4 rounded-3xl border shadow-sm transition-all',
              isSelected(item) ? 'border-black bg-slate-50' : 'border-slate-200 bg-white'
            ]"
          >
            <!-- Selective Toggle -->
            <div class="flex items-center">
              <button
                @click="toggleItem(item)"
                :class="[
                  'w-6 h-6 rounded border-2 flex items-center justify-center transition-all',
                  isSelected(item)
                    ? 'bg-black border-black'
                    : 'border-slate-300 hover:border-slate-500'
                ]"
              >
                <svg
                  v-if="isSelected(item)"
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-4 h-4 text-white"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <img
              :src="resolveImage(item.image) || 'data:image/svg+xml,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%22112%22 height%3D%22112%22 viewBox%3D%220 0 112 112%22%3E%3Crect width%3D%22112%22 height%3D%22112%22 fill%3D%22%23e5e7eb%22%2F%3E%3Ctext x%3D%2256%22 y%3D%2260%22 font-family%3D%22sans-serif%22 font-size%3D%2212%22 font-weight%3D%22bold%22 fill%3D%22%236b7280%22 text-anchor%3D%22middle%22 dominant-baseline%3D%22middle%22%3E%3C%2Ftext%3E%3C%2Fsvg%3E'"
              :alt="item.name"
              class="w-28 h-28 rounded-2xl object-cover"
            />
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <h3 class="font-bold text-slate-900">{{ item.name }}</h3>
                <p class="text-sm text-slate-500 mt-1">
                  <span v-if="item.size">Size: {{ item.size }}</span>
                  <span v-if="item.size && item.color"> | </span>
                  <span v-if="item.color">Color: {{ item.color }}</span>
                </p>
              </div>
              <div class="flex items-center justify-between mt-4">
                <div class="flex items-center gap-3">
                  <button
                    @click="updateQuantity(item.id, item.quantity - 1, item.size, item.color)"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 transition"
                  >
                    -
                  </button>
                  <span class="font-semibold w-8 text-center">{{ item.quantity }}</span>
                  <button
                    @click="updateQuantity(item.id, item.quantity + 1, item.size, item.color)"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 transition"
                  >
                    +
                  </button>
                </div>
                <p class="font-bold text-slate-900">₱{{ formatPrice(item.price * item.quantity) }}</p>
              </div>
            </div>
            <button
              @click="handleRemove(item)"
              class="text-slate-400 hover:text-red-500 transition self-start"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm h-fit sticky top-24">
          <h2 class="text-lg font-bold text-slate-900 mb-6">Order Summary</h2>

          <!-- Selection summary -->
          <div v-if="items.length" class="mb-4 text-sm text-slate-500">
            <span v-if="selectedIds.length === 0">No items selected</span>
            <span v-else>{{ selectedIds.length }} of {{ items.length }} items selected</span>
          </div>

          <div class="space-y-4 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-600">Subtotal (Selected)</span>
              <span class="font-semibold">₱{{ formatPrice(selectedSubtotal) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600">Shipping Fee</span>
              <span class="font-semibold">₱{{ formatPrice(selectedShippingFee) }}</span>
            </div>
            <div class="border-t border-slate-200 pt-4 flex justify-between text-base font-bold">
              <span>Total</span>
              <span>₱{{ formatPrice(selectedTotal) }}</span>
            </div>
          </div>

          <button
            @click="handleCheckout"
            :disabled="selectedIds.length === 0"
            :class="[
              'w-full mt-6 py-4 rounded-2xl font-bold transition',
              selectedIds.length > 0
                ? 'bg-black text-white hover:bg-slate-800'
                : 'bg-slate-200 text-slate-400 cursor-not-allowed'
            ]"
          >
            {{ selectedIds.length > 0 ? `Checkout (${selectedIds.length})` : 'Select items to checkout' }}
          </button>

          <button
            @click="clearCart"
            class="w-full mt-3 text-slate-500 text-sm hover:text-red-500 transition"
          >
            Clear Cart
          </button>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-20">
        <div class="text-6xl mb-4">🛒</div>
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Your Cart is Empty</h2>
        <p class="text-slate-500">Looks like you haven't added any items yet.</p>
        <Link
          :href="route('products.index')"
          class="inline-block mt-6 px-6 py-3 bg-black text-white font-semibold rounded-full hover:bg-slate-800 transition"
        >
          Browse Products
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { computed, watch, onMounted } from 'vue'
import useCart from '@/composables/useCart'
import useAuthModal from '@/composables/useAuthModal'
import { resolveImage } from '@/utils/imageHelper'

const { items, updateQuantity, removeFromCart, clearCart, selectedIds, toggleSelectedId, selectAllIds, deselectAllIds, setCheckoutSource, itemKey, removeSelectedByItemKey, syncItemsFromServer } = useCart()

onMounted(() => {
  console.log('[Cart/Index] mounted, syncing from server...')
  syncItemsFromServer().then(() => {
    console.log('[Cart/Index] sync complete, items:', JSON.parse(JSON.stringify(items.value)))
  })
})

// Debug: log items whenever they change
watch(items, (newItems) => {
  console.log('[Cart/Index] items changed:', JSON.parse(JSON.stringify(newItems)))
}, { deep: true })

console.log('[Cart/Index] mounted, current items:', JSON.parse(JSON.stringify(items.value)))
const { openAuthModal } = useAuthModal()
const page = usePage()
const isAuthenticated = computed(() => !!page.props.auth?.user)

// Selection helpers
const isSelected = (item) => selectedIds.value.includes(itemKey(item))

const toggleItem = (item) => {
  toggleSelectedId(itemKey(item))
}

const allSelected = computed(() =>
  items.value.length > 0 && selectedIds.value.length === items.value.length
)

const toggleSelectAll = () => {
  if (allSelected.value) {
    deselectAllIds()
  } else {
    selectAllIds()
  }
}

// Dynamic totals based on selected items
const selectedItems = computed(() =>
  items.value.filter((item) => selectedIds.value.includes(itemKey(item)))
)

const selectedSubtotal = computed(() =>
  selectedItems.value.reduce((sum, item) => sum + (item.price || 0) * item.quantity, 0)
)
const selectedShippingFee = computed(() => (selectedItems.value.length ? 200 : 0))
const selectedTotal = computed(() => selectedSubtotal.value + selectedShippingFee.value)

// All totals (for reference)
const subtotal = computed(() =>
  items.value.reduce((sum, item) => sum + (item.price || 0) * item.quantity, 0)
)
const shippingFee = computed(() => (items.value.length ? 200 : 0))
const total = computed(() => subtotal.value + shippingFee.value)

const formatPrice = (price) => {
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(price || 0)
}

const handleRemove = (item) => {
  removeSelectedByItemKey(itemKey(item))
  removeFromCart(item.id, item.size, item.color)
}

const handleCheckout = () => {
  if (!isAuthenticated.value) {
    const selected = selectedIds.value.join(',')
    openAuthModal(`/checkout?source=cart_checkout&selected=${selected}`)
    return
  }
  setCheckoutSource('cart_checkout')
  const selected = selectedIds.value.join(',')
  router.visit(`/checkout?source=cart_checkout&selected=${selected}`)
}
</script>
