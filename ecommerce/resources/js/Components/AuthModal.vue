<script setup>
import { ref, watch } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import useAuthModal from '@/composables/useAuthModal'

const { showAuthModal, pendingRedirect, closeAuthModal } = useAuthModal()

const page = usePage()
const isAuthenticated = ref(!!page.props.auth?.user)

// Keep in sync with auth changes (e.g. after successful login)
watch(() => page.props.auth?.user, (user) => {
  isAuthenticated.value = !!user
})

const email = ref('')
const password = ref('')
const errors = ref({})
const isLoading = ref(false)

// Reset form whenever modal opens
watch(showAuthModal, (visible) => {
  if (visible) {
    email.value = ''
    password.value = ''
    errors.value = {}
    isLoading.value = false
  }
})

const handleLogin = async () => {
  isLoading.value = true
  errors.value = {}

  try {
    await router.post('/login', {
      email: email.value,
      password: password.value,
    }, {
      onSuccess: () => {
        // Inertia handles the redirect; after successful login auth state updates
        closeAuthModal()
        if (pendingRedirect.value) {
          const redirect = pendingRedirect.value
          pendingRedirect.value = null
          router.visit(redirect)
        }
      },
      onError: (err) => {
        errors.value = err || {}
      },
      onFinish: () => {
        isLoading.value = false
      },
    })
  } catch (e) {
    isLoading.value = false
  }
}
</script>

<template>
  <!-- Backdrop -->
  <Transition
    enter-active-class="ease-out duration-300"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="ease-in duration-200"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="showAuthModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
      @click.self="closeAuthModal"
    >
      <!-- Modal Panel -->
      <Transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="showAuthModal"
          class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden"
          @click.stop
        >
          <!-- Header -->
          <div class="bg-slate-900 px-8 py-6 text-center">
            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-semibold mb-1">CHILLEROX</p>
            <h2 class="text-2xl font-black text-white">Welcome Back</h2>
            <p class="mt-1 text-sm text-slate-400">Sign in to continue your order</p>
          </div>

          <!-- Body -->
          <div class="px-8 py-6">
            <form @submit.prevent="handleLogin" class="space-y-4">
              <!-- Email -->
              <div>
                <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-1.5">
                  Email Address
                </label>
                <input
                  v-model="email"
                  type="email"
                  placeholder="you@example.com"
                  required
                  autocomplete="email"
                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-900 transition"
                />
                <p v-if="errors.email" class="mt-1.5 text-xs text-red-500 font-medium">{{ errors.email[0] }}</p>
              </div>

              <!-- Password -->
              <div>
                <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-1.5">
                  Password
                </label>
                <input
                  v-model="password"
                  type="password"
                  placeholder="Enter your password"
                  required
                  autocomplete="current-password"
                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-slate-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-slate-900 transition"
                />
                <p v-if="errors.password" class="mt-1.5 text-xs text-red-500 font-medium">{{ errors.password[0] }}</p>
              </div>

              <!-- Login Button -->
              <button
                type="submit"
                :disabled="isLoading"
                class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold text-sm hover:bg-slate-800 active:bg-slate-950 transition disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
              >
                <svg v-if="isLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ isLoading ? 'Signing In...' : 'Sign In' }}
              </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-5">
              <div class="flex-1 h-px bg-slate-200"></div>
              <span class="text-xs text-slate-400 font-medium">or</span>
              <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <!-- Sign Up Link -->
            <p class="text-center text-sm text-slate-600">
              Don't have an account?
              <Link
                href="/register"
                class="font-bold text-slate-900 hover:underline underline-offset-2"
                @click="closeAuthModal"
              >
                Create one
              </Link>
            </p>
          </div>

          <!-- Close Button -->
          <button
            type="button"
            @click="closeAuthModal"
            class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition"
            aria-label="Close modal"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </Transition>
    </div>
  </Transition>
</template>