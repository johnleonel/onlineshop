import { ref } from 'vue';

const storageKey = 'chilleroxCart';

const loadCart = () => {
  if (typeof window === 'undefined') {
    return { items: [], count: 0 };
  }

  try {
    const stored = window.localStorage.getItem(storageKey);
    return stored ? JSON.parse(stored) : { items: [], count: 0 };
  } catch (error) {
    console.warn('Unable to load cart from localStorage', error);
    return { items: [], count: 0 };
  }
};

const initialCart = loadCart();
const items = ref(initialCart.items || []);
const cartCount = ref(initialCart.count || 0);

const saveCart = () => {
  if (typeof window === 'undefined') {
    return;
  }

  try {
    window.localStorage.setItem(storageKey, JSON.stringify({ items: items.value, count: cartCount.value }));
  } catch (error) {
    console.warn('Unable to save cart to localStorage', error);
  }
};

const addToCart = (product, quantity = 1) => {
  const existing = items.value.find((item) => item.id === product.id);
  if (existing) {
    existing.quantity += quantity;
  } else {
    items.value.push({ ...product, quantity });
  }

  cartCount.value += quantity;
  saveCart();
};

const clearCart = () => {
  items.value = [];
  cartCount.value = 0;
  saveCart();
};

const updateQuantity = (productId, quantity) => {
  const existing = items.value.find((item) => item.id === productId);
  if (!existing) {
    return;
  }

  const previous = existing.quantity;
  if (quantity <= 0) {
    removeFromCart(productId);
    return;
  }

  existing.quantity = quantity;
  cartCount.value += quantity - previous;
  saveCart();
};

const removeFromCart = (productId) => {
  const index = items.value.findIndex((item) => item.id === productId);
  if (index === -1) {
    return;
  }

  cartCount.value -= items.value[index].quantity;
  items.value.splice(index, 1);
  saveCart();
};

export default function useCart() {
  return {
    items,
    cartCount,
    addToCart,
    updateQuantity,
    removeFromCart,
    clearCart,
  };
}
