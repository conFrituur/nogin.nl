const CACHE_NAME = "nogin-static-v11";
const STATIC_ASSETS = [
    "/assets/offline.html?v=4",
    "/assets/css/index.css?v=3",
    "/assets/css/nogin.css",
    "/assets/css/nietin.css",
    "/assets/css/api.css",
    "/assets/js/index.js",
    "/assets/js/api.js",
    "/assets/js/pwa.js",
    "/assets/js/offline.js?v=2",
    "/assets/favicon.ico",
    "/assets/apple-touch-icon.png",
    "/assets/icon-192.png",
    "/assets/icon-512.png",
    "/assets/icon-maskable-192.png",
    "/assets/icon-maskable-512.png"
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

    // Status pages and API data must always reflect the server's current state.
    if (request.mode === "navigate") {
        event.respondWith(fetch(request).catch(() => caches.match("/assets/offline.html?v=4")));
    } else if (STATIC_ASSETS.includes(url.pathname + url.search)) {
        event.respondWith(caches.match(request).then((cached) => cached || fetch(request)));
    }
});
