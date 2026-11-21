# Repo

- PHP 8.4 app: tracks whether people are in NL
- `index.php`: main page, picks person template by hostname
- `api.php`: REST; `autoload.php` loads all `src/*.php`
- `src/`: `Api`, `Repository`, `Person`, `State`
- `templates/`: HTML/PHP pages + API docs
- `assets/css/`, `assets/js/`, icons
- `people.json`: names; `state.json`, `state.lock`: runtime state (gitignored, never commit)
- No tests, no build, no dependency manifest

# Commands (run from repo root)

- `php -S localhost:8000`
- `find . -name '*.php' -not -path './.git/*' -exec php -l {} \;`
- `curl http://localhost:8000/api.php/persons`

# Style

- 4 spaces; PascalCase classes/files; camelCase methods/vars
- PHP braces on new line for classes and methods
- Keep typed properties/params/returns, readonly value objects
- Person ids lowercase

# Testing

- Syntax checks + manual verification
- Check: page render, toggle, persistence across reload
- API: collection + individual GET, PATCH/PUT `{"isNogInNL":false}`, malformed body, unknown name
- Mutation tests on local data only
- UI: mobile layout, hostname routing
- Record checks that could not be run

# iOS standalone

- `.ios-status-strip` (templates/index.html): aria-hidden, 11px solid strip at viewport top in standalone, pointer-events none; experimental iOS 27 top-blur workaround; verify on physical iPhone; background matches page; no backdrop blur

# Commits / PRs

- Short plain focused commit messages (e.g. `update favicon`)
- PR: behavior changed, verification done, linked issues, screenshots for visual changes

# Persistence

- PHP needs write access to repo root (temp state files)
- Preserve locking + atomic replacement

# Webserver

- Can serve `templates/index.html` (root) and `templates/api.html` (api subdomain) directly, no PHP
- Root files: `Cache-Control: no-cache`; `assets/`: cacheable
- On `assets/` change, add/update cache-busting in referencing HTML
