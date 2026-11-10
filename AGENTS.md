# Repository Guidelines

## Project Structure & Module Organization

This is a PHP 8.4 hobby application that tracks whether people are in the Netherlands. `index.php` serves the main page and selects person-specific templates using the request hostname. `api.php` handles REST requests; `autoload.php` loads every PHP file in `src/`.

`src/` contains the `Api`, `Repository`, `Person`, and `State` classes. `templates/` contains HTML/PHP pages and API documentation. Stylesheets and browser scripts live in `assets/css/` and `assets/js/`. `assets/` also contains icons, `manifest.webmanifest`, and `offline.html`. Root-level `sw.js` provides the service worker. `people.json` supplies the configured names; `state.json` and `state.lock` hold runtime persistence. There is no test directory or dependency manifest.

## Build, Test, and Development Commands

Run commands from the repository root so relative JSON paths resolve correctly:

- `php -v` — confirm PHP 8.4 or newer is installed.
- `php -S localhost:8000` — serve the application locally; open `http://localhost:8000/`.
- `find . -name '*.php' -not -path './.git/*' -exec php -l {} \;` — check PHP syntax.
- `curl http://localhost:8000/api.php/persons` — smoke-test the JSON API.
- `node --check sw.js` and `node --check assets/js/pwa.js` — check service worker and registration script syntax when Node.js is available.
- `python3 -m json.tool assets/manifest.webmanifest > /dev/null` — validate manifest JSON when Python is available.

There is no build step, package installation, or configured formatter/linter beyond PHP syntax checking.

## Coding Style & Naming Conventions

Match the surrounding code: use four-space indentation, PascalCase class names and filenames, and camelCase methods and variables. PHP classes and methods place opening braces on a new line. Preserve typed properties, parameters, return values, and readonly value objects. Person identifiers are normalized to lowercase. Keep browser scripts and styles in the existing `assets/js/` and `assets/css/` structure. Use English for manifest metadata and the offline page.

## Testing Guidelines

No automated testing framework or coverage threshold is configured. For changes, run syntax checks and manually verify page rendering, toggle behavior, and API responses. Exercise collection and individual GET requests, PATCH/PUT updates with `{"isNogInNL":false}`, malformed bodies, and unknown names. Check persistence across reloads. Use local data for mutation tests. For UI changes, verify mobile layouts and person-specific hostname routing.

For PWA changes, check the manifest and service worker in browser developer tools over HTTPS or localhost. Verify installation, icon rendering, and launch behavior on the main domain and a person-specific subdomain. After the worker activates, verify that offline navigation shows the English offline page, static assets remain available, and API requests and status changes still require a connection. Close existing app windows and tabs and reopen to activate an updated waiting worker. Record checks that cannot be run because required tools or a browser are unavailable.

## Progressive Web App & Icons

`assets/js/offline.js` powers the offline page's Try again button and automatic recovery. It probes the original page with an uncached fetch on load, every second while visible, on the browser's online event, and when the page becomes visible. Keep the original hostname, path, query, and fragment when recovering; do not rely on `navigator.onLine` alone. Keep its versioned script URL in `assets/offline.html` and the service worker precache list in sync. The offline HTML itself uses a versioned URL in both the service worker precache list and navigation fallback lookup; increment that version and `CACHE_NAME` whenever the offline HTML changes.

All page templates link to `/assets/manifest.webmanifest` and load `/assets/js/pwa.js`, which registers `/sw.js` with explicit `{ scope: "/" }`. Keep the worker at the root so its root scope needs no `Service-Worker-Allowed` header. See the Nginx example in `README.md`. The manifest uses root-relative icon URLs and `/` for `id`, `start_url`, and `scope`, so each hostname launches its own root page. Serve the manifest as `application/manifest+json` and the worker as JavaScript; hosting must serve these and `/assets/` as static files.

The service worker precaches only the files listed in `STATIC_ASSETS`. Navigations use the network with `/assets/offline.html` as the fallback on network failure; live status pages and API responses are never cached by the worker. Non-GET and cross-origin requests bypass it. Preserve this behavior to avoid displaying stale location data. Increment the version in `CACHE_NAME` whenever cached assets change, and update `STATIC_ASSETS` when adding or removing cached files. Activation removes older caches with the `nogin-static-` prefix.

Regenerate all six icon files from the current `brand.png` when the brand changes:

- `assets/icon-192.png` and `assets/icon-512.png`: square app icons preserving the source transparency.
- `assets/icon-maskable-192.png` and `assets/icon-maskable-512.png`: opaque `#6150ff` backgrounds with centered artwork resized to 56% of the canvas width, keeping the artwork inside the maskable safe area.
- `assets/apple-touch-icon.png`: 180 × 180 PNG.
- `assets/favicon.ico`: ICO containing 16 × 16, 32 × 32, and 48 × 48 images.

ImageMagick's `convert` can resize and export these assets without a build dependency. Preserve the source logo's transparent corners and artwork; flatten transparency onto purple only for maskable icons. Verify exported dimensions, alpha transparency, and manifest icon paths after regeneration, then bump the service worker cache version.

## Commit & Pull Request Guidelines

Recent commits use short, plain descriptions such as `update favicon` and `fix name in template bug`; no strict prefix convention is established. Keep commits focused and describe the concrete change. PRs should explain the behavior changed, record verification performed, link related issues when applicable, and include screenshots for visual changes.

## Persistence & Configuration

Keep runtime `state.json` and `state.lock` out of commits; both are ignored. The PHP process needs write access to the repository root where temporary state files are created. Preserve locking and atomic replacement when changing persistence.

# AGENT Instructions

When changes occur in the assets folder, make sure to include/update a cache-busting mechanism in the HTML referencing it.

All templates load a versioned `/assets/js/pwa.js` URL to refresh registration
code. Increment the version when changing it, and bump `CACHE_NAME` in
`sw.js` when changing precached assets. The explicit root scope updates
the existing root registration when migrating from `/assets/sw.js`; close app windows
and tabs and reopen to activate a waiting replacement.
