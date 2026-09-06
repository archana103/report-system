document.addEventListener("DOMContentLoaded", () => {
    initNewsletter();
    initScrollToTop();
});

function initNewsletter() {
    const form = document.getElementById("newsletter-form");
    const messageEl = document.getElementById("newsletter-message");

    if (!form || !messageEl) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        messageEl.style.display = "none";
        messageEl.textContent = "";

        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json",
                "X-CSRF-TOKEN": formData.get("_token"),
            },
        })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));

                messageEl.style.display = "block";

                if (!response.ok) {
                    messageEl.style.color = "#fca5a5";
                    messageEl.textContent =
                        data.errors?.email?.[0] ??
                        data.message ??
                        "Error subscribing.";
                } else {
                    messageEl.style.color = "#93e0c0";
                    messageEl.textContent =
                        data.message ?? "Successfully subscribed!";
                    form.reset();
                }
            })
            .catch(() => {
                messageEl.style.display = "block";
                messageEl.style.color = "#fca5a5";
                messageEl.textContent =
                    "An error occurred. Please try again.";
            });
    });
}

function initScrollToTop() {
    const scrollBtn = document.getElementById("scrollToTopBtn");

    if (!scrollBtn) return;

    window.addEventListener("scroll", () => {
        scrollBtn.style.display = window.scrollY > 300 ? "flex" : "none";
    });

    scrollBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
}