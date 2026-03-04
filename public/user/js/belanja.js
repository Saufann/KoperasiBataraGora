document.addEventListener("DOMContentLoaded", function () {
  /* =========================================
     BAGIAN 1: LOGIKA FILTER, SEARCH, & LOAD MORE
     ========================================= */
  const filterBtns = document.querySelectorAll(".filter-btn");
  const productCards = document.querySelectorAll(".product-card");
  const loadMoreBtn = document.getElementById("loadMoreBtn");
  const searchInput = document.getElementById("searchInput");

  let isLoadMoreClicked = false;
  const visibleLimit = 10;

  // --- FUNGSI UPDATE TAMPILAN KARTU ---
  function updateProductDisplay() {
    const keyword = searchInput ? searchInput.value.toLowerCase().trim() : "";
    const activeBtn = document.querySelector(".filter-btn.active");
    const filterCategory = activeBtn
      ? activeBtn.getAttribute("data-filter")
      : "semua";

    productCards.forEach((card, index) => {
      const cardCategory = card.getAttribute("data-category");
      const productName = card.querySelector("h3").textContent.toLowerCase();

      const matchesSearch = productName.includes(keyword);
      const matchesCategory =
        filterCategory === "semua" || cardCategory.includes(filterCategory);

      if (matchesSearch && matchesCategory) {
        card.style.display = "block";
        if (filterCategory === "semua" && keyword === "") {
          if (!isLoadMoreClicked && index >= visibleLimit) {
            card.classList.add("hidden-item");
          } else {
            card.classList.remove("hidden-item");
          }
        } else {
          card.classList.remove("hidden-item");
        }
      } else {
        card.style.display = "none";
      }
    });

    if (loadMoreBtn) {
      if (filterCategory !== "semua" || keyword !== "") {
        loadMoreBtn.style.display = "none";
      } else if (!isLoadMoreClicked) {
        loadMoreBtn.style.display = "block";
      }
    }
  }

  // --- LISTENER TOMBOL LOAD MORE ---
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function () {
      isLoadMoreClicked = true;
      const hiddenItems = document.querySelectorAll(".hidden-item");
      hiddenItems.forEach(function (item) {
        item.classList.remove("hidden-item");
        item.style.animation = "fadeIn 0.5s ease";
      });
      this.style.display = "none";
    });
  }

  // --- LISTENER TOMBOL FILTER ---
  filterBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      // Reset semua tombol filter
      filterBtns.forEach((b) => {
        b.classList.remove("active");
        let iconSpan = b.querySelector("span");
        if (iconSpan) {
          iconSpan.className = "check-box-outline";
          iconSpan.innerHTML = "";
        }
      });

      // Set tombol aktif
      this.classList.add("active");
      let activeSpan = this.querySelector("span");
      if (activeSpan) {
        activeSpan.className = "check-box";
        activeSpan.innerHTML = "✔";
      }

      updateProductDisplay();
    });
  });

  // --- LISTENER SEARCH BAR ---
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      updateProductDisplay();
    });
  }

  /* =========================================
     BAGIAN 2: LOGIKA POP-UP KERANJANG (+/-)
     ========================================= */
  const cartModal = document.getElementById("cartModal");
  const closeCartBtn = document.querySelector(".close-cart-btn");
  const cartForm = document.getElementById("cartForm");

  const qtyInput = document.getElementById("qtyInput");
  const btnMinus = document.getElementById("btnMinus");
  const btnPlus = document.getElementById("btnPlus");

  const modalProductName = document.getElementById("modalProductName");
  const modalProductImage = document.getElementById("modalProductImage");
  const modalProductPrice = document.getElementById("modalProductPrice");
  const modalSubtotal = document.getElementById("modalSubtotal");

  let currentPrice = 0;

  function formatRupiah(angka) {
    return new Intl.NumberFormat("id-ID").format(angka);
  }

  // Event Buka Pop-up
  document.querySelectorAll(".open-cart-modal").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      const name = this.getAttribute("data-name");
      const image = this.getAttribute("data-image");
      const actionUrl = this.getAttribute("data-url");
      currentPrice = parseInt(this.getAttribute("data-price"));

      modalProductName.textContent = name;
      modalProductImage.src = image;
      modalProductPrice.textContent = "Rp. " + formatRupiah(currentPrice);
      cartForm.action = actionUrl;

      qtyInput.value = 1;
      modalSubtotal.textContent = "Rp. " + formatRupiah(currentPrice);

      cartModal.style.display = "flex";
    });
  });

  // Event Tutup Pop-up
  if (closeCartBtn) {
    closeCartBtn.addEventListener("click", () => {
      cartModal.style.display = "none";
    });
  }

  window.addEventListener("click", function (e) {
    if (e.target === cartModal) {
      cartModal.style.display = "none";
    }
  });

  // Logika Tombol Plus Minus
  if (btnMinus && btnPlus && qtyInput) {
    btnMinus.addEventListener("click", () => {
      let qty = parseInt(qtyInput.value);
      if (qty > 1) {
        qty--;
        qtyInput.value = qty;
        updateSubtotal();
      }
    });

    btnPlus.addEventListener("click", () => {
      let qty = parseInt(qtyInput.value);
      qty++;
      qtyInput.value = qty;
      updateSubtotal();
    });

    qtyInput.addEventListener("input", () => {
      if (qtyInput.value < 1 || isNaN(qtyInput.value)) {
        qtyInput.value = 1;
      }
      updateSubtotal();
    });
  }

  function updateSubtotal() {
    let qty = parseInt(qtyInput.value);
    let subtotal = qty * currentPrice;
    modalSubtotal.textContent = "Rp. " + formatRupiah(subtotal);
  }
});
