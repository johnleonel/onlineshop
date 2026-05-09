/**
 * localImage — resolves a local asset path for use in Vue src attributes.
 *
 * For /public/ files (directly served as static assets):
 *   localImage('/images/hood2.jpg')  →  '/images/hood2.jpg'
 *
 * For src/assets images (Vite-processed, use the import.meta.url trick):
 *   localImage('/images/hood2.jpg', true)  →  new URL('../assets/images/hood2.jpg', import.meta.url).href
 *
 * Usage in Vue <script setup>:
 *   import { localImage } from '@/utils/imageHelper'
 *   const img = localImage('/images/hood2.jpg')
 *
 * In templates (works with both):
 *   <img :src="localImage('/images/hood2.jpg')" alt="..." />
 */
export function localImage(path, fromAssets = false) {
    if (!path) return ''

    // If it's already an absolute URL or data URI, return as-is
    if (path.startsWith('http') || path.startsWith('data:')) {
        return path
    }

    // /public/images/... paths — serve directly from server root
    if (!fromAssets) {
        return path
    }

    // src/assets/... paths — Vite needs import.meta.url to bundle correctly
    return new URL(`../assets${path}`, import.meta.url).href
}

/**
 * Map a filename to the full public image path.
 * Call this on the filename stored in product.image (e.g. "hood2.jpg")
 * to get the full URL like "/images/hood2.jpg".
 *
 * In the backend (PHP), simply prefix with /images/:
 *   $imagePath = '/images/' . $product->image;
 *
 * No URL() trick needed on the PHP side — Laravel serves /public/ directly.
 */
export function productImagePath(filename) {
    if (!filename) return ''
    if (filename.startsWith('/') || filename.startsWith('http') || filename.startsWith('data:')) {
        return filename
    }
    return `/images/${filename}`
}

/**
 * resolveImage — resolves any image path to a URL the browser can load.
 *
 * Covers all cases:
 *   • http://... / https://...      → return as-is (external URL)
 *   • /images/...                    → return as-is (public folder, already absolute)
 *   • data:...                       → return as-is (inline data URI)
 *   • "hood2.jpg" (bare filename)    → prefix with /images/
 *   • "" / null / undefined         → return empty string
 *
 * Use this instead of inline || or || operators in templates.
 * Replace pattern like:
 *   :src="item.image || '/images/fallback.jpg'"
 * with:
 *   :src="resolveImage(item.image) || '/images/fallback.jpg'"
 *
 * In ALL Vue components that show product images, import and use this function
 * to ensure local filenames are resolved to /images/... regardless of whether
 * the image came from a backend API, a composable (useCart localStorage), or
 * a hardcoded fallback.
 */
export function resolveImage(imagePath) {
    if (!imagePath) return ''
    // External URLs and data URIs — return as-is
    if (imagePath.startsWith('http') || imagePath.startsWith('/') || imagePath.startsWith('data:')) {
        return imagePath
    }
    // Bare filename → /images/
    return `/images/${imagePath}`
}