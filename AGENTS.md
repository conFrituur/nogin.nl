# Repository Guidelines

## Project Structure & Module Organization

This is a PHP 8.4 hobby application that tracks whether people are in the Netherlands. `index.php` serves the main page and selects person-specific templates using the request hostname. `api.php` handles REST requests; `autoload.php` loads every PHP file in `src/`.

`src/` contains the `Api`, `Repository`, `Person`, and `State` classes. `templates/` contains HTML/PHP pages, API documentation, and inline CSS and JavaScript. `favicon.ico` is the root static asset. `people.json` supplies the configured names; `state.json` and `state.lock` hold runtime persistence. There is no test directory or dependency manifest.

## Build, Test, and Development Commands

Run commands from the repository root so relative JSON paths resolve correctly:

- `php -v` — confirm PHP 8.4 or newer is installed.
- `php -S localhost:8000` — serve the application locally; open `http://localhost:8000/`.
- `find . -name '*.php' -not -path './.git/*' -exec php -l {} \;` — check PHP syntax.
- `curl http://localhost:8000/api.php/persons` — smoke-test the JSON API.

There is no build step, package installation, or configured formatter/linter beyond PHP syntax checking.

## Coding Style & Naming Conventions

Match the surrounding code: use four-space indentation, PascalCase class names and filenames, and camelCase methods and variables. PHP classes and methods place opening braces on a new line. Preserve typed properties, parameters, return values, and readonly value objects. Person identifiers are normalized to lowercase. Keep browser code in the existing templates unless a change warrants restructuring.

## Testing Guidelines

No automated testing framework or coverage threshold is configured. For changes, run syntax checks and manually verify page rendering, toggle behavior, and API responses. Exercise collection and individual GET requests, PATCH/PUT updates with `{"isNogInNL":false}`, malformed bodies, and unknown names. Check persistence across reloads. Use local data for mutation tests. For UI changes, verify mobile layouts and person-specific hostname routing.

## Commit & Pull Request Guidelines

Recent commits use short, plain descriptions such as `update favicon` and `fix name in template bug`; no strict prefix convention is established. Keep commits focused and describe the concrete change. PRs should explain the behavior changed, record verification performed, link related issues when applicable, and include screenshots for visual changes.

## Persistence & Configuration

Keep runtime `state.json` and `state.lock` out of commits; both are ignored. The PHP process needs write access to the repository root where temporary state files are created. Preserve locking and atomic replacement when changing persistence.
