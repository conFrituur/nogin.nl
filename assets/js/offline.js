const retryButton = document.getElementById("retry");
const retryStatus = document.getElementById("retry-status");
// A service worker fallback keeps the original navigation URL in the address bar.
const targetUrl = new URL(window.location.href);
if (targetUrl.pathname === "/assets/offline.html") {
    targetUrl.pathname = "/";
    targetUrl.search = "";
    targetUrl.hash = "";
}

let checking = false;

async function retryConnection() {
    if (checking) {
        return;
    }

    checking = true;
    retryButton.disabled = true;
    retryStatus.textContent = "Checking connection…";
    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 5000);

    try {
        // A normal fetch bypasses the worker's navigation fallback. Never use
        // navigator.onLine alone: a network connection may lack internet access.
        const response = await fetch(targetUrl.href, {
            cache: "no-store",
            signal: controller.signal,
            headers: { "Accept": "text/html" }
        });

        if (!response.ok) {
            throw new Error("Page unavailable");
        }

        retryStatus.textContent = "Connected. Returning to your page…";
        window.location.replace(targetUrl.href);
    } catch (error) {
        retryStatus.textContent = "Unable to reach this page. We will keep trying automatically.";
    } finally {
        clearTimeout(timeout);
        checking = false;
        retryButton.disabled = false;
    }
}

retryButton.addEventListener("click", retryConnection);
window.addEventListener("online", retryConnection);
document.addEventListener("visibilitychange", () => {
    if (!document.hidden) {
        retryConnection();
    }
});
setInterval(() => {
    if (!document.hidden) {
        retryConnection();
    }
}, 1000);
retryConnection();
