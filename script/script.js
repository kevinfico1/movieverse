// 1. Navbar berubah warna/efek saat di-scroll
const navbar = document.getElementById("navbar");

if (navbar) {
  window.onscroll = () => {
    if (window.scrollY > 40) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  };
}

// 2. Buka/Tutup Menu Dropdown Header
const dropdownBtn = document.getElementById("dropdownToggle");
const dropdownMenu = document.getElementById("headerDropdown");

if (dropdownBtn && dropdownMenu) {
  dropdownBtn.onclick = (e) => {
    e.stopPropagation();
    dropdownMenu.classList.toggle("show");
    dropdownBtn.classList.toggle("active");
  };

  document.onclick = () => {
    dropdownMenu.classList.remove("show");
    dropdownBtn.classList.remove("active");
  };
}