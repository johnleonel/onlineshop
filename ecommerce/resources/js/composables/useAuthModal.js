/**
 * Global auth modal state — singleton across all composable calls.
 *
 * Usage:
 *   const { showAuthModal, openAuthModal, closeAuthModal, pendingRedirect } = useAuthModal()
 *
 *   // Open the modal (optionally store where user should go after login)
 *   openAuthModal('/checkout?source=direct_buy')
 *
 *   // Close manually
 *   closeAuthModal()
 *
 *   // After a successful login you can resume navigation:
 *   if (pendingRedirect.value) {
 *     router.visit(pendingRedirect.value)
 *     pendingRedirect.value = null
 *   }
 */

import { ref } from 'vue'

const showAuthModal = ref(false)
const pendingRedirect = ref(null)

const openAuthModal = (redirectAfterLogin = null) => {
  pendingRedirect.value = redirectAfterLogin
  showAuthModal.value = true
}

const closeAuthModal = () => {
  showAuthModal.value = false
  // Don't clear pendingRedirect — caller decides whether to navigate
}

const clearPendingRedirect = () => {
  pendingRedirect.value = null
}

export default function useAuthModal() {
  return {
    showAuthModal,
    pendingRedirect,
    openAuthModal,
    closeAuthModal,
    clearPendingRedirect,
  }
}