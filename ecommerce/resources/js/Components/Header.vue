<script setup>
import { ref, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ShoppingCartIcon, UserIcon, MagnifyingGlassIcon, Bars3Icon, MinusIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';
import useCart from '@/composables/useCart';
import useAuthModal from '@/composables/useAuthModal';
import { resolveImage } from '@/utils/imageHelper';

const searchQuery = ref('');
const isMobileMenuOpen = ref(false);
const isProfileOpen = ref(false);
const isProductsDropdownOpen = ref(false);
const isCartOpen = ref(false);
let productsDropdownCloseTimeout = null;

const { cartCount, items, updateQuantity, removeFromCart } = useCart();
const { openAuthModal } = useAuthModal();
const page = usePage();
const isAuthenticated = computed(() => !!page.props.auth?.user);

const cartSubtotal = computed(() => items.value.reduce((sum, item) => sum + item.price * item.quantity, 0));
const shippingFee = computed(() => (items.value.length ? 34 : 0));
const cartTotal = computed(() => cartSubtotal.value + shippingFee.value);

const formatCurrency = (value) => {
  return `₱${Number(value || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
};

const handleSearch = () => {
    if (searchQuery.value) {
        router.get('/products', { search: searchQuery.value });
    }
};

const openProductsDropdown = () => {
    clearTimeout(productsDropdownCloseTimeout);
    isProductsDropdownOpen.value = true;
};

const closeProductsDropdown = () => {
    clearTimeout(productsDropdownCloseTimeout);
    productsDropdownCloseTimeout = window.setTimeout(() => {
        isProductsDropdownOpen.value = false;
    }, 120);
};

const handleLogout = () => {
    router.post('/logout');
};

const handleCheckoutClick = () => {
    if (!isAuthenticated.value) {
        openAuthModal('/checkout')
    } else {
        router.visit('/checkout')
    }
};
</script>

<template>
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Left: Navigation Links -->
                <div class="hidden md:flex space-x-6 text-sm font-medium text-gray-600">
                    <Link href="/" class="hover:text-black transition font-semibold">Home</Link>
                    <div class="relative" @mouseenter="openProductsDropdown" @mouseleave="closeProductsDropdown">
                        <Link :href="route('products.index')" class="hover:text-black transition inline-flex items-center gap-1">
                            Products
                            <svg class="h-4 w-4 text-gray-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </Link>
                        <div :class="['absolute left-0 z-20 mt-2 w-56 rounded-2xl border border-slate-200 bg-white p-3 shadow-lg', isProductsDropdownOpen ? 'block' : 'hidden']" @mouseenter="openProductsDropdown" @mouseleave="closeProductsDropdown">
                            <Link :href="route('products.index')" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">All Products</Link>
                            <Link :href="route('products.index', { category: 'polo' })" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Polo</Link>
                            <Link :href="route('products.index', { category: 'tshirt' })" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">T-shirt</Link>
                            <Link :href="route('products.index', { category: 'hoodie' })" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Hoodie</Link>
                            <Link :href="route('products.index', { category: 'shorts' })" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Shorts</Link>
                        </div>
                    </div>
                    <div class="relative">
                        <Link :href="route('new-drops.index')" class="text-red-500 hover:text-red-600 font-bold italic">New Drops</Link>
                    </div>
                    <Link href="/about" class="hover:text-black transition">About Us</Link>
                </div>

                <div class="flex-shrink-0 flex items-center">
                    <Link href="/" class="text-3xl font-black tracking-tighter text-black">
                        CHILLEROX
                    </Link>
                </div>

                <!-- Right: Search, Cart, Profile -->
                <div class="flex items-center space-x-5">
                    <div class="hidden lg:block relative">
                        <input 
                            v-model="searchQuery"
                            @keyup.enter="handleSearch"
                            type="text" 
                            placeholder="Search..." 
                            class="bg-gray-100 border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-1 focus:ring-black w-48 xl:w-64"
                        />
                        <MagnifyingGlassIcon class="h-4 w-4 text-gray-400 absolute left-3 top-3" />
                    </div>

                    <div class="relative">
                        <button
                            @click.stop="isCartOpen = !isCartOpen"
                            class="relative text-gray-600 hover:text-black transition focus:outline-none"
                            :aria-expanded="isCartOpen"
                            aria-label="Open cart menu"
                        >
                            <ShoppingCartIcon class="h-6 w-6" />
                            <span class="absolute -top-1 -right-1 bg-black text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ cartCount }}</span>
                        </button>

                        <transition name="fade">
                            <div v-if="isCartOpen" class="fixed inset-0 z-50 bg-black/30" @click="isCartOpen = false"></div>
                        </transition>

                        <transition name="slide-right">
                            <div v-if="isCartOpen" class="fixed right-0 top-0 z-50 flex h-full w-full max-w-[420px] flex-col overflow-hidden border-l border-slate-200 bg-white shadow-2xl sm:w-[400px]">
                                <div class="flex items-center justify-between border-b border-slate-200 px-4 py-4">
                                    <div>
                                        <p class="text-lg font-semibold text-slate-900">Shopping Cart</p>
                                        <p class="text-sm text-slate-500">Review your selected items</p>
                                    </div>
                                    <button type="button" @click="isCartOpen = false" class="text-slate-400 hover:text-slate-600 text-xl leading-none">×</button>
                                </div>

                                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                                    <div v-if="items.length" class="space-y-4">
                                        <div v-for="item in items" :key="item.id" class="grid gap-3 rounded-3xl border border-slate-200 p-3 sm:grid-cols-[90px_1fr]">
                                            <img :src="resolveImage(item.image) || 'data:image/svg+xml,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%2290%22 height%3D%2290%22 viewBox%3D%220 0 90 90%22%3E%3Crect width%3D%2290%22 height%3D%2290%22 fill%3D%22%23e5e7eb%22%2F%3E%3Ctext x%3D%2245%22 y%3D%2250%22 font-family%3D%22sans-serif%22 font-size%3D%2212%22 font-weight%3D%22bold%22 fill%3D%22%236b7280%22 text-anchor%3D%22middle%22%3E%3C%2Ftext%3E%3C%2Fsvg%3E'" :alt="item.name" class="h-24 w-24 rounded-3xl object-cover" />
                                            <div class="grid gap-2">
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-900">{{ item.name }}</p>
                                                    <p v-if="item.size" class="text-xs text-slate-500 mt-1">Size: {{ item.size }}</p>
                                                    <div class="mt-2 flex flex-wrap items-center gap-2 text-sm">
                                                        <span v-if="item.originalPrice && item.originalPrice > item.price" class="text-slate-400 line-through">{{ formatCurrency(item.originalPrice) }}</span>
                                                        <span class="font-semibold text-slate-900">{{ formatCurrency(item.price) }}</span>
                                                    </div>
                                                </div>

                                                <div class="flex flex-wrap items-center gap-3">
                                                    <div class="flex items-center rounded-full border border-slate-200 bg-slate-50 px-2 py-1">
                                                        <button
                                                            type="button"
                                                            @click="updateQuantity(item.id, item.quantity - 1, item.size, item.color)"
                                                            class="rounded-full bg-white p-1 text-slate-600 hover:bg-slate-100"
                                                        >
                                                            <MinusIcon class="h-4 w-4" />
                                                        </button>
                                                        <span class="mx-2 text-sm font-semibold text-slate-900">{{ item.quantity }}</span>
                                                        <button
                                                            type="button"
                                                            @click="updateQuantity(item.id, item.quantity + 1, item.size, item.color)"
                                                            class="rounded-full bg-white p-1 text-slate-600 hover:bg-slate-100"
                                                        >
                                                            <PlusIcon class="h-4 w-4" />
                                                        </button>
                                                    </div>
                                                    <button type="button" @click="removeFromCart(item.id, item.size, item.color)" class="text-sm font-medium text-slate-600 hover:text-red-500">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
                                        Your cart is empty.
                                    </div>
                                </div>

                                <div class="border-t border-slate-200 bg-slate-50 p-4">
                                    <div class="flex justify-between py-2 text-sm text-slate-600"><span>Subtotal</span><span>{{ formatCurrency(cartSubtotal) }}</span></div>
                                    <div class="flex justify-between py-2 text-sm text-slate-600"><span>Shipping Fee</span><span>{{ formatCurrency(shippingFee) }}</span></div>
                                    <div class="mt-3 flex items-center justify-between border-t border-slate-200 pt-3 text-base font-semibold text-slate-900">
                                        <span>Total</span>
                                        <span>{{ formatCurrency(cartTotal) }}</span>
                                    </div>
                                    <div class="mt-4 grid gap-3">
                                        <button type="button" class="w-full rounded-3xl bg-black px-4 py-3 text-sm font-semibold text-white hover:bg-slate-900" @click="isCartOpen = false; handleCheckoutClick">CHECK OUT</button>
                                        <button type="button" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50" @click="isCartOpen = false; router.visit('/cart')">VIEW CART</button>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <div class="relative">
                        <button
                            @click.stop="isProfileOpen = !isProfileOpen"
                            class="text-gray-600 hover:text-black transition focus:outline-none"
                            aria-expanded="false"
                            aria-label="Open profile menu"
                        >
                            <UserIcon class="h-6 w-6" />
                        </button>

                        <div
                            v-if="isProfileOpen"
                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg ring-1 ring-black ring-opacity-5"
                        >
                            <Link
                                href="/profile"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                @click="isProfileOpen = false"
                            >
                                Profile
                            </Link>
                            <button
                                type="button"
                                @click="handleLogout"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Logout
                            </button>
                        </div>
                    </div>

                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden">
                        <Bars3Icon class="h-6 w-6 text-gray-600" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isMobileMenuOpen" class="md:hidden bg-white border-t p-4 space-y-4 shadow-lg">
            <Link href="/" class="block text-gray-600">Home</Link>
            <Link href="/products" class="block text-gray-600">Products</Link>
            <Link :href="route('new-drops.index')" class="block text-red-500 font-bold italic">New Drops</Link>
        </div>
    </nav>
</template>