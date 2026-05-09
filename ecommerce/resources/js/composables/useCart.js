import { ref } from 'vue';
import axios from 'axios';

const storageKey = 'chilleroxCart';
const buyNowStorageKey = 'chilleroxBuyNow';
const checkoutSourceKey = 'chilleroxCheckoutSource';

/**
 * Load persisted cart from localStorage.
 * Returns { items: [], count: 0 } on server or on any parse error.
 */
const loadCart = () => {
  if (typeof window === 'undefined') {
    return { items: [], count: 0 };
  }
  try {
    const stored = window.localStorage.getItem(storageKey);
    if (stored) {
      return JSON.parse(stored);
    }
  } catch (e) { /* ignore */ }
  return { items: [], count: 0 };
};

// Singleton module-level state — shared across every useCart() call
const initialCart = loadCart();
const items = ref(initialCart.items || []);
const cartCount = ref(initialCart.count || 0);

const loadBuyNow = () => {
  if (typeof window === 'undefined') return null;
  try {
    const stored = window.localStorage.getItem(buyNowStorageKey);
    if (stored) return JSON.parse(stored);
  } catch (e) { /* ignore */ }
  return null;
};

const initialBuyNow = loadBuyNow();
const buyNowItem = ref(initialBuyNow || null);

const saveBuyNow = () => {
  if (typeof window === 'undefined') return;
  try {
    if (buyNowItem.value) {
      window.localStorage.setItem(buyNowStorageKey, JSON.stringify(buyNowItem.value));
    } else {
      window.localStorage.removeItem(buyNowStorageKey);
    }
  } catch (e) { /* ignore */ }
};

// ── Checkout source tracking ────────────────────────────────────
// 'cart_checkout' = user arrived via Cart page (with selective items)
// 'direct_buy'   = user arrived via Buy Now button (single isolated item)
const loadCheckoutSource = () => {
  if (typeof window === 'undefined') return null;
  try {
    return window.localStorage.getItem(checkoutSourceKey);
  } catch (e) { /* ignore */ }
  return null;
};
const initialCheckoutSource = loadCheckoutSource();
const checkoutSource = ref(initialCheckoutSource || null);

const setCheckoutSource = (source) => {
  checkoutSource.value = source;
  if (typeof window !== 'undefined') {
    if (source) {
      window.localStorage.setItem(checkoutSourceKey, source);
    } else {
      window.localStorage.removeItem(checkoutSourceKey);
    }
  }
};

const clearCheckoutSource = () => setCheckoutSource(null);

// ── Selected item IDs for selective cart checkout ─────────────────
const loadSelectedIds = () => {
  if (typeof window === 'undefined') return [];
  try {
    const stored = window.localStorage.getItem('chilleroxSelectedIds');
    if (stored) return JSON.parse(stored);
  } catch (e) { /* ignore */ }
  return [];
};
const selectedIds = ref(loadSelectedIds());

const saveSelectedIds = () => {
  if (typeof window === 'undefined') return;
  try {
    window.localStorage.setItem('chilleroxSelectedIds', JSON.stringify(selectedIds.value));
  } catch (e) { /* ignore */ }
};

const toggleSelectedId = (itemKey) => {
  const idx = selectedIds.value.indexOf(itemKey);
  if (idx === -1) {
    selectedIds.value.push(itemKey);
  } else {
    selectedIds.value.splice(idx, 1);
  }
  saveSelectedIds();
};

const selectAllIds = () => {
  selectedIds.value = items.value.map((item) => itemKey(item));
  saveSelectedIds();
};

const deselectAllIds = () => {
  selectedIds.value = [];
  saveSelectedIds();
};

// Remove a specific item key from selectedIds (called when item is removed from cart)
const removeSelectedByItemKey = (itemKeyToRemove) => {
  const idx = selectedIds.value.indexOf(itemKeyToRemove);
  if (idx !== -1) {
    selectedIds.value.splice(idx, 1);
    saveSelectedIds();
  }
};

const clearSelectedIds = () => {
  selectedIds.value = [];
  saveSelectedIds();
};

// Unique key for a cart item (handles guest vs auth)
const itemKey = (item) => `${item.id}__${item.size || ''}__${item.color || ''}`;

/**
 * Persist current items + count to localStorage.
 */
const saveCart = () => {
  if (typeof window === 'undefined') return;
  try {
    window.localStorage.setItem(storageKey, JSON.stringify({ items: items.value, count: cartCount.value }));
  } catch (e) { /* ignore */ }
};

/**
 * Sync server-side cart count (for authenticated users on page load).
 */
const syncWithBackend = async () => {
  try {
    const { data } = await axios.get('/cart/count');
    if (data.cart_count !== undefined) {
      cartCount.value = data.cart_count;
      saveCart();
    }
  } catch (e) { /* ignore */ }
};

/**
 * Add a product to the cart.
 * Falls back to local state when the backend is unavailable (guest users).
 */
const addToCart = async (product, quantity = 1, size = null, color = null) => {
  // Try backend first (authenticated)
  try {
    const { data } = await axios.post('/cart', {
      product_id: product.id,
      quantity,
      size,
      color,
    });
    if (data.success) {
      cartCount.value = data.cart_count;
      saveCart();
      return { success: true, message: data.message };
    }
  } catch (e) {
    /* fallback to local state */
  }

  // Local fallback (guest / unauthenticated)
  const existing = items.value.find(
    (item) => item.id === product.id && item.size === size && item.color === color
  );
  if (existing) {
    existing.quantity += quantity;
  } else {
    items.value.push({ ...product, quantity, size, color });
  }
  cartCount.value += quantity;
  saveCart();
  return { success: true, message: 'Product added to cart' };
};

/**
 * Clear entire cart.
 */
const clearCart = () => {
  items.value     = [];
  cartCount.value = 0;
  saveCart();
};

/**
 * Change quantity of an existing item.
 * Removes the item if quantity goes to 0 or below.
 */
const updateQuantity = async (productId, quantity, size = null, color = null) => {
  if (quantity <= 0) {
    removeFromCart(productId, size, color);
    return;
  }

  const existing = items.value.find(
    (item) => item.id === productId && item.size === size && item.color === color
  );
  if (!existing) return;

  const previous = existing.quantity;

  // Try backend first
  try {
    await axios.patch(`/cart/${existing.id || productId}`, { quantity });
  } catch (e) {
    /* fallback to local state */
  }

  existing.quantity = quantity;
  cartCount.value  += quantity - previous;
  saveCart();
};

/**
 * Remove a specific item from the cart.
 */
const removeFromCart = async (productId, size = null, color = null) => {
  const index = items.value.findIndex(
    (item) => item.id === productId && item.size === size && item.color === color
  );
  if (index === -1) return;

  // Try backend first
  try {
    await axios.delete(`/cart/${productId}`);
  } catch (e) {
    /* fallback to local state */
  }

  cartCount.value -= items.value[index].quantity;
  items.value.splice(index, 1);
  saveCart();
};

/* ── Buy Now operations ──────────────────────────────────── */
/**
 * Store a "Buy Now" item separately so it goes to checkout alongside cart items.
 * Sets checkoutSource to 'direct_buy' so checkout knows this is an isolated path.
 */
const setBuyNowItem = (product, quantity = 1, size = null, color = null) => {
  buyNowItem.value = { ...product, quantity, size, color };
  saveBuyNow();
  setCheckoutSource('direct_buy');
};

/**
 * Clear the Buy Now item (called after checkout processes it).
 */
const clearBuyNowItem = () => {
  buyNowItem.value = null;
  saveBuyNow();
};

export default function useCart() {
  return {
    items,
    cartCount,
    addToCart,
    updateQuantity,
    removeFromCart,
    clearCart,
    syncWithBackend,
    buyNowItem,
    setBuyNowItem,
    clearBuyNowItem,
    checkoutSource,
    setCheckoutSource,
    clearCheckoutSource,
    selectedIds,
    toggleSelectedId,
    selectAllIds,
    deselectAllIds,
    removeSelectedByItemKey,
    clearSelectedIds,
    itemKey,
  };
}
