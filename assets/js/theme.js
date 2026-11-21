(function () {
    const root = document.documentElement;
    const query = window.matchMedia("(prefers-color-scheme: dark)");
    const read = () => {
        try {
            return localStorage.getItem("theme");
        } catch (e) {
            return null;
        }
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
            meta.content = theme === "dark" ? "#111827" : "#6150ff";
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
            try {
                localStorage.setItem("theme", theme);
            } catch (e) {
                // storage unavailable: preference lasts for this page only
            }
        });
    });
})();
