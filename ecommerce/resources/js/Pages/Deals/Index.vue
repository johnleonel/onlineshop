<script setup>
import { ref, computed } from 'vue';
import { Link, router, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/Applayout.vue';
import useCart from '@/composables/useCart';

defineProps({
    products: Array,
});

const { addToCart } = useCart();

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
};

const handleBuy = (product) => {
    addToCart(product);
    router.visit('/cart');
};

const handleAddToCart = (product) => {
    addToCart(product);
};

const goToProduct = (productId) => {
    router.visit(`/deals/${productId}`);
};
</script>

<template>
    <AppLayout>
        <Head title="Final Sale - Deals" />

        <div class="bg-white min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Header Section -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-4xl font-black text-black mb-6 tracking-tight">
                        PALDO SALE
                    </h1>
                    
                    <div class="space-y-1 mb-8">
                        <p class="text-lg md:text-xl4 font-bold text-black">
                            UP TO 30% OFF ON SELECTED ITEMS.
                        </p>
                        <p class="text-sm md:text-base text-gray-600 font-medium">
                            All sale items are final – no returns or exchanges.
                        </p>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="group relative flex flex-col overflow-hidden rounded-2xl bg-transparent transition-all duration-300 hover:bg-white hover:shadow-xl hover:-translate-y-2 cursor-pointer p-4"
                        @click="goToProduct(product.id)"
                    >
                        <!-- Sale Badge -->
                        <div class="absolute top-6 left-6 z-10">
                            <div class="bg-black rounded-full w-12 h-12 flex items-center justify-center shadow-md transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                                <span class="text-white font-black text-[10px] uppercase leading-tight text-center px-1">
                                    {{ product.statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Image Container -->
                        <div class="aspect-square w-full overflow-hidden bg-transparent p-4">
                            <img
                                :src="product.image"
                                :alt="product.name"
                                class="h-full w-full object-contain transition duration-500 group-hover:scale-110"
                            />
                        </div>

                        <!-- Content Section -->
                        <div class="p-4 flex flex-col flex-grow text-center">
                            <!-- Product Name -->
                            <h2 class="text-base font-bold text-slate-900 line-clamp-2 mb-2">
                                {{ product.name.toUpperCase() }}
                            </h2>

                            <!-- Price Section -->
                            <div class="mb-4">
                                <div class="flex items-center justify-center gap-2 mb-1">
                                    <span class="text-xs line-through text-gray-500">
                                        ₱{{ formatPrice(product.originalPrice) }}
                                    </span>
                                </div>
                                <p class="text-xl font-black text-slate-900">
                                    ₱{{ formatPrice(product.price) }}
                                </p>
                            </div>

                            <!-- Rating -->
                            <p class="text-xs text-yellow-500 font-bold mb-4">{{ product.rating }} ★</p>
                        </div>
                    </div>
                </div>

                <!-- View All Products Button (Bottom Right) -->
                <div class="mt-14 flex justify-center">
                    <Link 
                        href="/products" 
                        class="inline-block bg-[#111827] text-white px-8 py-4 text-sm font-bold tracking-[0.2em] 
                            transition-all duration-300 ease-in-out
                            hover:bg-[#1f2937] hover:scale-105 active:scale-95 shadow-lg"
                    >
                        VIEW ALL COLLECTION
                    </Link>
                </div>  
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>