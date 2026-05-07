<script setup>
import { ref } from 'vue';
import { Link, router, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/Applayout.vue';
import useCart from '@/composables/useCart';

const props = defineProps({
    product: Object,
});

const { addToCart } = useCart();
const quantity = ref(1);

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
};

const handleAddToCart = () => {
    if (quantity.value > 0) {
        addToCart(props.product, quantity.value);
    }
};

const handleBuy = () => {
    handleAddToCart();
    router.visit('/cart');
};

const incrementQuantity = () => {
    quantity.value++;
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="product.name" />

        <div class="max-w-7xl mx-auto px-4 py-10">
            <!-- Breadcrumb -->
            <div class="mb-8 flex items-center gap-3 text-sm text-slate-500">
                <Link href="/deals" class="hover:text-slate-900 font-medium">Final Sale</Link>
                <span>/</span>
                <span class="text-slate-900">{{ product.name }}</span>
            </div>

            <!-- Product Details Grid -->
            <div class="grid gap-10 lg:grid-cols-[1.5fr_1fr]">
                <!-- Left: Image -->
                <section class="space-y-6">
                    <div class="rounded-2xl bg-white p-8 shadow-sm border border-gray-200">
                        <img
                            :src="product.image"
                            :alt="product.name"
                            class="w-full rounded-2xl object-cover bg-gray-100"
                        />
                    </div>
                </section>

                <!-- Right: Product Info -->
                <section class="rounded-2xl bg-white p-8 shadow-sm border border-gray-200">
                    <!-- Category & Status -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs uppercase tracking-widest text-slate-500 font-bold">
                            {{ product.category }}
                        </span>
                        <span class="bg-black text-white px-3 py-1 rounded-full text-xs font-bold">
                            {{ product.statusLabel }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-black text-slate-900 mb-2">
                        {{ product.name }}
                    </h1>

                    <!-- Rating -->
                    <p class="text-sm text-yellow-500 font-bold mb-6">{{ product.rating }} ★</p>

                    <!-- Description -->
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">
                        {{ product.description }}
                    </p>

                    <!-- Price Section -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-4xl font-black text-slate-900">
                                ₱{{ formatPrice(product.price) }}
                            </span>
                            <span class="text-xl text-gray-400 line-through">
                                ₱{{ formatPrice(product.originalPrice) }}
                            </span>
                            <span class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                -{{ product.discount }}%
                            </span>
                        </div>
                        <p class="text-sm text-red-600 font-semibold">
                            Save ₱{{ formatPrice(product.originalPrice - product.price) }}
                        </p>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="mb-8">
                        <label class="text-sm font-semibold text-slate-900 mb-3 block">Quantity</label>
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                @click="decrementQuantity"
                                class="h-10 w-10 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition"
                            >
                                <span class="text-lg">−</span>
                            </button>
                            <input
                                v-model.number="quantity"
                                type="number"
                                min="1"
                                class="w-16 text-center border border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-black focus:border-transparent"
                            />
                            <button
                                type="button"
                                @click="incrementQuantity"
                                class="h-10 w-10 rounded-lg border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition"
                            >
                                <span class="text-lg">+</span>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            type="button"
                            @click="handleBuy"
                            class="w-full bg-black text-white font-bold py-3 rounded-lg hover:bg-gray-900 transition"
                        >
                            Buy Now
                        </button>
                        <button
                            type="button"
                            @click="handleAddToCart"
                            class="w-full bg-gray-200 text-black font-bold py-3 rounded-lg hover:bg-gray-300 transition"
                        >
                            Add to Cart
                        </button>
                    </div>

                    <!-- Sale Notice -->
                    <div class="mt-8 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-xs text-red-700 font-semibold">
                            ⚠️ All sale items are final – no returns or exchanges.
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Hide spinner on number input */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
</style>
