<script setup>
import { useForm, Link } from '@inertiajs/vue3'; //

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="flex min-h-screen font-sans text-gray-900">
        <!-- Left Side: Image & Branding -->
        <div class="relative hidden w-1/2 lg:block">
            <img 
                src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                class="absolute inset-0 object-cover w-full h-full" 
                alt="Store Background"
            />
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/30"></div>
            
            <!-- Branding & Text Overlay -->
            <div class="absolute inset-0 flex flex-col justify-between p-12 text-white">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-white rounded-full">
                        <!-- Your Logo Icon -->
                        <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">CHILLEROX</span> <!-- -->
                </div>

                <div>
                    <h1 class="mb-4 text-5xl font-bold leading-tight">
                        Elevate your <br/> shopping experience
                    </h1>
                    <p class="text-lg opacity-90">
                        Join the CHILLEROX community and discover <br/> 
                        exclusive deals curated just for you.
                    </p>
                    <!-- Simple Pagination Indicator -->
                    <div class="flex gap-2 mt-8">
                        <div class="w-8 h-1.5 bg-white rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-white/50 rounded-full"></div>
                        <div class="w-1.5 h-1.5 bg-white/50 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="flex items-center justify-center w-full bg-white lg:w-1/2">
            <div class="w-full max-w-md px-8">
                <!-- Mobile Logo (Visible only on small screens) -->
                <div class="flex justify-center mb-8 lg:hidden">
                    <span class="text-2xl font-bold">CHILLEROX</span>
                </div>

                <div class="flex justify-between items-center mb-10">
                    <h2 class="text-3xl font-bold">Welcome Back!</h2>
                    <Link :href="route('register')" class="px-6 py-2 text-sm font-semibold border border-gray-200 rounded-full hover:bg-gray-50 transition">
                        Sign up
                    </Link>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Your Email</label>
                        <input 
                            v-model="form.email" 
                            type="email" 
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-black focus:border-black"
                            placeholder="email@example.com"
                        />
                        <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input 
                            v-model="form.password" 
                            type="password" 
                            class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-black focus:border-black"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" v-model="form.remember" class="rounded border-gray-300 text-black shadow-sm focus:ring-black" />
                            <span class="ml-2 text-sm text-gray-600">Remember Me</span>
                        </label>
                        <Link :href="route('password.request')" class="text-sm text-gray-500 hover:underline">
                            Forgot Password?
                        </Link>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 text-white bg-gray-900 rounded-lg font-bold hover:bg-black transition"
                        :disabled="form.processing"
                    >
                        Login
                    </button>
                </form>

                <!-- Social Login Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center"><span class="w-full border-t"></span></div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-2 text-gray-400">Instant Login</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <!-- Google Icon -->
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="ml-2 text-sm">Google</span>
                    </button>
                    <button class="flex items-center justify-center py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <!-- Facebook Icon -->
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="ml-2 text-sm">Facebook</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
