document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.getElementById("navbar");
  const dropdownToggle = document.getElementById("dropdownToggle");
  const headerDropdown = document.getElementById("headerDropdown");

  // Efek transisi background navbar apabila di-scroll
  if (navbar) {
    window.addEventListener("scroll", () => {
      navbar.classList.toggle("scrolled", window.scrollY > 40);
    });
  }

  // Interaksi toggle menu dropdown transparan pada header
  if (dropdownToggle && headerDropdown) {
    dropdownToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      headerDropdown.classList.toggle("show");
      dropdownToggle.classList.toggle("active");
    });

    // Menutup menu dropdown secara automatik jika pengguna menekan di luar menu
    document.addEventListener("click", (e) => {
      if (!headerDropdown.contains(e.target) && !dropdownToggle.contains(e.target)) {
        headerDropdown.classList.remove("show");
        dropdownToggle.classList.remove("active");
      }
    });
  }
});