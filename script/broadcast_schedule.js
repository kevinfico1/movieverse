const bsTitle = document.getElementById("bsTitle");
const bsTabs = Array.from(document.querySelectorAll(".bs-day"));

function pilihHari(hari, fokus) {
  bsTabs.forEach((tab) => {
    const aktif = tab.dataset.day === hari;
    tab.classList.toggle("active", aktif);
    tab.setAttribute("aria-selected", aktif ? "true" : "false");
    tab.tabIndex = aktif ? 0 : -1;

    const panel = document.getElementById(tab.getAttribute("aria-controls"));
    if (panel) panel.hidden = !aktif;

    if (aktif && fokus) tab.focus();
  });

  if (bsTitle) bsTitle.textContent = hari;
}

bsTabs.forEach((tab, i) => {
  tab.addEventListener("click", () => pilihHari(tab.dataset.day, false));

  // Navigasi keyboard: panah kiri/kanan, Home, End
  tab.addEventListener("keydown", (e) => {
    let tujuan = null;
    if (e.key === "ArrowRight") tujuan = (i + 1) % bsTabs.length;
    if (e.key === "ArrowLeft") tujuan = (i - 1 + bsTabs.length) % bsTabs.length;
    if (e.key === "Home") tujuan = 0;
    if (e.key === "End") tujuan = bsTabs.length - 1;
    if (tujuan === null) return;

    e.preventDefault();
    pilihHari(bsTabs[tujuan].dataset.day, true);
  });
});