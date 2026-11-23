(function () {
  var box   = document.querySelector('.hc-section');
  var track = document.querySelector('.hc-track');
  if (!box || !track) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var kecepatan = 0.6;  
  var berhenti  = false;
  var posisi    = 0;

  function stop()  { berhenti = true; }
  function jalan() { posisi = box.scrollLeft; berhenti = false; }

  box.addEventListener('mouseenter', stop);
  box.addEventListener('mouseleave', jalan);
  box.addEventListener('touchstart', stop, { passive: true });
  box.addEventListener('touchend', jalan);

  function putar() {
    if (!berhenti) {
      var separuh = track.scrollWidth / 2;
      posisi += kecepatan;
      if (posisi >= separuh) posisi -= separuh;
      box.scrollLeft = posisi;
    }
    requestAnimationFrame(putar);
  }

  requestAnimationFrame(putar);
})();