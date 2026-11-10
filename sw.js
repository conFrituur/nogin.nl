const CACHE_NAME = "nogin-static-v18";
// Only the offline fallback and the assets it needs are stored here.
const STATIC_ASSETS = [
    "/assets/offline.html?v=7",
    "/assets/css/index.css?v=6",
    "/assets/js/offline.js?v=3",
    "/assets/favicon.ico",
    "/assets/apple-touch-icon.png"
];

self.addEventListener("install", (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS)));
});

self.addEventListener("activate", (event) => {
    event.waitUntil(caches.keys().then((names) => Promise.all(
        names.filter((name) => name.startsWith("nogin-static-") && name !== CACHE_NAME)
            .map((name) => caches.delete(name))
    )));
});

self.addEventListener("fetch", (event) => {
    const request = event.request;
    const url = new URL(request.url);

    if (request.method !== "GET" || url.origin !== self.location.origin) {
        return;
    }

    // Normal requests use the browser's HTTP cache and server cache headers.
    // Only failed navigations receive the offline fallback.
    if (request.mode === "navigate") {
        event.respondWith(fetch(request).catch(() => caches.match("/assets/offline.html?v=7")));
    } else if (STATIC_ASSETS.includes(url.pathname + url.search)) {
        event.respondWith(caches.match(request).then((cached) => cached || fetch(request)));
    }
});
