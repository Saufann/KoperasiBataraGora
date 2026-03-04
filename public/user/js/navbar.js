document.addEventListener("DOMContentLoaded", function () {
    /* =========================================
       1. LOGIKA GLOBAL (NAVBAR & LOGIN MODAL)
       ========================================= */
    const modal = document.getElementById("loginModal");
    const btnLogin = document.querySelector(".btn-login");
    const spanClose = document.querySelector(".close-btn");
    const authLinks = document.querySelectorAll(".auth-trigger");

    // Fungsi Buka Modal
    function openModal(e) {
        if (e) e.preventDefault();
        if (modal) modal.style.display = "flex";
    }

    // Fungsi Tutup Modal
    function closeModal() {
        if (modal) modal.style.display = "none";
    }

    // Event Listener Tombol Login Navbar
    if (btnLogin) {
        btnLogin.addEventListener("click", openModal);
    }

    // Event Listener Link Menu (Belanja/Pinjaman jika belum login)
    if (authLinks.length > 0) {
        authLinks.forEach(link => {
            link.addEventListener("click", openModal);
        });
    }

    // Event Listener Tombol Close (X)
    if (spanClose) {
        spanClose.addEventListener("click", closeModal);
    }

    // Tutup jika klik di luar area modal
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Cek apakah ada Error dari Laravel (Auto Open)
    if (modal && modal.classList.contains("show-modal")) {
        modal.style.display = "flex";
    }
});