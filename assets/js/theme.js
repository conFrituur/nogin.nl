(function () {
    const root = document.documentElement;
    const query = window.matchMedia("(prefers-color-scheme: dark)");
    // cookie on the parent domain so all *.nogin.nl subdomains share the preference
    const domain = /(^|\.)nogin\.nl$/.test(location.hostname) ? "; domain=nogin.nl" : "";
    const read = () => {
        const match = document.cookie.match(/(?:^|; )theme=(dark|light)/);
        return match ? match[1] : null;
    };
    const save = (theme) => {
        document.cookie = "theme=" + theme + "; path=/; max-age=31536000; samesite=lax" + domain;
    };
    const apply = (theme) => {
        root.dataset.theme = theme;
        const meta = document.querySelector('meta[name="theme-color"]');
        const button = document.getElementById("theme-toggle");
        if (button) {
            const label = theme === "dark" ? "Switch to light mode" : "Switch to dark mode";
            button.title = label;
            button.setAttribute("aria-label", label);
        }
        if (meta) {
            meta.content = theme === "dark" ? meta.dataset.dark : meta.dataset.light;
        }
    };

    apply(read() || (query.matches ? "dark" : "light"));

    query.addEventListener("change", (event) => {
        if (!read()) {
            apply(event.matches ? "dark" : "light");
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const button = document.getElementById("theme-toggle");
        if (!button) {
            return;
        }
        apply(root.dataset.theme);
        button.addEventListener("click", () => {
            const theme = root.dataset.theme === "dark" ? "light" : "dark";
            apply(theme);
            save(theme);
        });
    });
})();
