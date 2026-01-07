document.addEventListener("DOMContentLoaded", () => {
    const password = document.getElementById("password");
    const bar = document.getElementById("strength-bar");

    if (!password || !bar) return;

    password.addEventListener("input", () => {
        let strength = 0;
        const val = password.value;

        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[a-z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;

        bar.className = "";
        if (strength <= 2) {
            bar.style.width = "33%";
            bar.classList.add("weak");
        } else if (strength === 3) {
            bar.style.width = "66%";
            bar.classList.add("medium");
        } else {
            bar.style.width = "100%";
            bar.classList.add("strong");
        }
    });
});
