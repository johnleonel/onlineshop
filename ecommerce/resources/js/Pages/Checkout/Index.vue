<template>
  <AppLayout>
    <Head title="Checkout | CHILLEROX" />

    <div class="max-w-5xl mx-auto px-4 py-12">
      <h1 class="text-3xl font-black text-slate-900 mb-8">Checkout</h1>

      <div v-if="displayItems.length" class="grid gap-8 lg:grid-cols-[1fr_400px]">

        <!-- Payment Methods -->
        <div class="space-y-6">
          <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-5">Select Payment Method</h2>
            <div class="space-y-3">
              <label
                v-for="method in paymentMethods"
                :key="method.id"
                :class="[
                  'flex items-center gap-4 p-4 rounded-2xl border-2 cursor-pointer transition-all',
                  selectedPayment === method.id
                    ? 'border-black bg-slate-900 text-white'
                    : 'border-slate-200 hover:border-slate-400'
                ]"
              >
                <input
                  type="radio"
                  name="payment"
                  :value="method.id"
                  v-model="selectedPayment"
                  class="hidden"
                />
                <div :class="['text-2xl', selectedPayment === method.id ? 'text-white' : 'text-slate-700']">
                  {{ method.icon }}
                </div>
                <div class="flex-1">
                  <p :class="['font-bold text-sm', selectedPayment === method.id ? 'text-white' : 'text-slate-900']">
                    {{ method.name }}
                  </p>
                  <p :class="['text-xs mt-0.5', selectedPayment === method.id ? 'text-slate-300' : 'text-slate-500']">
                    {{ method.description }}
                  </p>
                </div>
                <div v-if="selectedPayment === method.id" class="w-5 h-5 rounded-full bg-white flex items-center justify-center">
                  <div class="w-2.5 h-2.5 rounded-full bg-black"></div>
                </div>
                <div v-else class="w-5 h-5 rounded-full border-2 border-slate-300"></div>
              </label>
            </div>
          </div>

          <!-- GCash Instructions -->
          <div v-if="selectedPayment === 'gcash'" class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4">GCash Payment Instructions</h2>
            <div class="space-y-3 text-sm text-slate-600">
              <p>1. Send payment to <strong>0917-123-4567</strong> (CHILLEROX)</p>
              <p>2. Reference your order number as the payment reference</p>
              <p>3. A confirmation email will be sent once payment is verified</p>
              <p class="text-xs text-slate-400 mt-4">Note: GCash payments are processed within 24 hours.</p>
            </div>
          </div>

          <!-- COD Information -->
          <div v-if="selectedPayment === 'cod'" class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Cash on Delivery Information</h2>
            <div class="space-y-3 text-sm text-slate-600">
              <p>Pay with cash upon delivery. Our courier will collect the payment.</p>
              <p class="text-xs text-slate-400 mt-4">Note: A ₱30 handling fee may apply for COD orders.</p>
            </div>
          </div>

          <button
            @click="placeOrder"
            :disabled="!selectedPayment || isProcessing"
            :class="[
              'w-full py-4 rounded-2xl font-bold text-sm transition-all',
              selectedPayment && !isProcessing
                ? 'bg-black text-white hover:bg-slate-800'
                : 'bg-slate-200 text-slate-400 cursor-not-allowed'
            ]"
          >
            {{ isProcessing ? 'Processing...' : 'Place Order' }}
          </button>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm h-fit sticky top-24">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900">Order Summary</h2>
            <span
              v-if="checkoutSource === 'direct_buy'"
              class="text-xs font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-full"
            >
              Direct Purchase
            </span>
            <span
              v-else
              class="text-xs font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-full"
            >
              Cart Checkout
            </span>
          </div>

          <div class="space-y-4 max-h-[400px] overflow-y-auto">
            <div
              v-for="item in displayItems"
              :key="item.id"
              class="flex gap-3 py-3 border-b border-slate-100 last:border-0"
            >
              <img
                :src="resolveImage(item.product.image)"
                :alt="item.product.name"
                class="w-16 h-16 rounded-xl object-cover bg-slate-100"
              />
              <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm text-slate-900 truncate">{{ item.product.name }}</p>
                <p class="text-xs text-slate-500 mt-0.5">
                  <span v-if="item.size">Size: {{ item.size }}</span>
                  <span v-if="item.size && item.color"> | </span>
                  <span v-if="item.color">Color: {{ item.color }}</span>
                </p>
                <p class="text-xs text-slate-500">Qty: {{ item.quantity }}</p>
                <p class="font-bold text-sm text-slate-900 mt-1">₱{{ formatPrice(item.product.price * item.quantity) }}</p>
              </div>
            </div>
          </div>

          <div class="space-y-3 mt-4 pt-4 border-t border-slate-200 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-600">Subtotal</span>
              <span class="font-semibold">₱{{ formatPrice(computedSubtotal) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600">Shipping Fee</span>
              <span class="font-semibold">₱{{ formatPrice(shippingFee) }}</span>
            </div>
            <div class="flex justify-between text-base font-bold pt-3 border-t border-slate-200">
              <span>Total</span>
              <span>₱{{ formatPrice(computedTotal) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-20">
        <div class="text-6xl mb-4">📦</div>
        <h2 class="text-2xl font-bold text-slate-900 mb-2">No Items to Checkout</h2>
        <p class="text-slate-500">Your cart is empty. Add some items first.</p>
        <Link
          :href="route('products.index')"
          class="inline-block mt-6 px-6 py-3 bg-black text-white font-semibold rounded-full hover:bg-slate-800 transition"
        >
          Browse Products
        </Link>
      </div>

      <!-- Success Modal -->
      <Transition name="fade">
        <div v-if="orderSuccess" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
          <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl">
            <div class="text-6xl mb-4">✅</div>
            <h2 class="text-2xl font-black text-slate-900 mb-2">Order Placed!</h2>
            <p class="text-slate-600 mb-6">Thank you for your order. You will receive a confirmation shortly.</p>
            <Link
              :href="route('products.index')"
              class="inline-block w-full py-3 bg-black text-white font-bold rounded-xl hover:bg-slate-800 transition"
            >
              Continue Shopping
            </Link>
          </div>
        </div>
      </Transition>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { resolveImage } from '@/utils/imageHelper'
import useCart from '@/composables/useCart'

const {
  buyNowItem,
  clearBuyNowItem,
  checkoutSource,
  clearCheckoutSource,
  selectedIds,
  clearSelectedIds,
  itemKey,
} = useCart()

const props = defineProps({
  // Authenticated users: cart items from controller
  cartItems: {
    type: Array,
    default: () => [],
  },
  // Selected item keys for auth users (comma-separated string)
  selectedKeys: {
    type: String,
    default: '',
  },
  subtotal: {
    type: Number,
    default: 0,
  },
  shippingFee: {
    type: Number,
    default: 0,
  },
  total: {
    type: Number,
    default: 0,
  },
})

const selectedPayment = ref('')
const isProcessing = ref(false)
const orderSuccess = ref(false)

// Parse selected keys (sent as comma-separated string from controller)
const selectedKeysSet = computed(() => {
  if (!props.selectedKeys) return new Set()
  return new Set(props.selectedKeys.split(',').filter(Boolean))
})

// ── Item source determination ─────────────────────────────────────
// checkoutSource is set before navigating:
// - 'cart_checkout': arrived from Cart page (selective items)
// - 'direct_buy':    arrived from Buy Now button (isolated single item)
// No merging: direct_buy NEVER shows cart items; cart_checkout shows only selected.

// For direct_buy path: show ONLY the buyNowItem
const displayItems = computed(() => {
  // Direct Buy Now path — isolated, no cart items merged
  if (checkoutSource.value === 'direct_buy') {
    if (!buyNowItem.value) return []
    return [{
      id: `buynow-${buyNowItem.value.id}`,
      product_id: buyNowItem.value.id,
      product: {
        id: buyNowItem.value.id,
        name: buyNowItem.value.name,
        image: buyNowItem.value.image,
        price: buyNowItem.value.price,
      },
      quantity: buyNowItem.value.quantity,
      size: buyNowItem.value.size,
      color: buyNowItem.value.color,
    }]
  }

  // Cart checkout path — show ONLY selected items
  const cart = props.cartItems || []

  if (selectedKeysSet.value.size === 0) {
    // No selection tracked server-side, fall back to localStorage selectedIds
    return cart.filter((item) => {
      const key = `${item.product_id || item.id}__${item.size || ''}__${item.color || ''}`
      return selectedIds.value.includes(key)
    })
  }

  // Filter cart to only selected items
  return cart.filter((item) => {
    const key = `${item.product_id || item.id}__${item.size || ''}__${item.color || ''}`
    return selectedKeysSet.value.has(key)
  })
})

const computedSubtotal = computed(() =>
  displayItems.value.reduce((sum, item) => sum + (item.product?.price || 0) * item.quantity, 0)
)
const shippingFee = computed(() => (displayItems.value.length ? 200 : 0))
const computedTotal = computed(() => computedSubtotal.value + shippingFee.value)

const paymentMethods = [
  {
    id: 'gcash',
    name: 'GCash',
    description: 'Pay via GCash e-wallet',
    icon: '📱',
  },
  {
    id: 'cod',
    name: 'Cash on Delivery',
    description: 'Pay with cash upon delivery',
    icon: '💵',
  },
]

const formatPrice = (price) => {
  return new Intl.NumberFormat('en-PH', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(price || 0)
}

const placeOrder = async () => {
  if (!selectedPayment.value || isProcessing.value) return
  if (displayItems.value.length === 0) {
    alert('No items to checkout.')
    return
  }

  isProcessing.value = true

  try {
    const isDirectBuy = checkoutSource.value === 'direct_buy'

    const payload = {
      payment_method: selectedPayment.value,
      source: checkoutSource.value || 'cart_checkout',
      items: displayItems.value.map((item) => ({
        product_id: item.product_id || item.product?.id,
        quantity: item.quantity,
        size: item.size,
        color: item.color,
      })),
    }

    const response = await fetch('/checkout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
      },
      body: JSON.stringify(payload),
    })

    const data = await response.json()

    if (data.success) {
      orderSuccess.value = true
      // Clean up Buy Now item if present
      clearBuyNowItem()
      // Clear checkout source and selected IDs
      clearCheckoutSource()
      clearSelectedIds()
    } else {
      alert(data.message || 'Failed to place order. Please try again.')
    }
  } catch (error) {
    console.error('Order error:', error)
    alert('An error occurred. Please try again.')
  } finally {
    isProcessing.value = false
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
