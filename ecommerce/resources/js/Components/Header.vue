<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { ShoppingCartIcon, UserIcon, MagnifyingGlassIcon, Bars3Icon } from '@heroicons/vue/24/outline';

const searchQuery = ref('');
const isMobileMenuOpen = ref(false);

const handleSearch = () => {
    if (searchQuery.value) {
        router.get('/products', { search: searchQuery.value });
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
                    <Link href="/shop" class="hover:text-black transition">Shop</Link>
                    <Link href="/products" class="hover:text-black transition">Products</Link>
                    <Link href="/deals" class="text-red-500 hover:text-red-600 font-bold italic">Deals</Link>
                    <Link href="/about" class="hover:text-black transition">About Us</Link>
                </div>

                <!-- Center: Shop Name -->
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

                    <Link href="/cart" class="relative text-gray-600 hover:text-black transition">
                        <ShoppingCartIcon class="h-6 w-6" />
                        <span class="absolute -top-1 -right-1 bg-black text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">0</span>
                    </Link>

                    <Link href="/profile" class="text-gray-600 hover:text-black transition">
                        <UserIcon class="h-6 w-6" />
                    </Link>

                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="md:hidden">
                        <Bars3Icon class="h-6 w-6 text-gray-600" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isMobileMenuOpen" class="md:hidden bg-white border-t p-4 space-y-4 shadow-lg">
            <Link href="/" class="block text-gray-600">Home</Link>
            <Link href="/shop" class="block text-gray-600">Shop</Link>
            <Link href="/products" class="block text-gray-600">Products</Link>
            <Link href="/deals" class="block text-red-500 font-bold font-italic">Deals</Link>
        </div>
    </nav>
</template>