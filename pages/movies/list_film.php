<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Film - Planarcadia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/style/base.css">
  <link rel="stylesheet" href="/style/auth/topbar.css">
  <link rel="stylesheet" href="/style/list_film/list_film.css">
  <link rel="stylesheet" href="/style/auth/footer.css">
</head>
<body>

  <?php require_once __DIR__ . '/../../components/landing/topbar.php'; ?>

  <main class="lf-wrap">

    <!-- Pencarian (filter judul langsung di halaman) -->
    <form class="lf-search" role="search" onsubmit="return false">
      <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      <input type="search" id="cariFilm" placeholder="Cari judul film" aria-label="Cari judul film">
    </form>

    <!-- Judul genre + rekomendasi minggu ini -->
    <section class="lf-hero">
      <div class="lf-hero-left">
        <h1 class="lf-genre-title">Action</h1>
        <div class="lf-rec-link">
          <span>Rekomendasi minggu ini</span>
          <span class="lf-rec-btn"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span>
        </div>
      </div>

      <!-- Ganti link gambar banner di bagian --banner -->
      <div class="lf-banner" style="--banner: url('https://GANTI-LINK-GAMBAR/reacher.jpg')">
        <h2>Reacher</h2>
        <p>Jack Reacher, mantan polisi militer, singgah di sebuah kota kecil dan terseret ke dalam konspirasi yang tidak bisa ia abaikan.</p>
      </div>
    </section>

    <hr class="lf-divider">

    <!-- Daftar film: tiap kartu bisa diatur sendiri (gambar, judul, genre, dll) -->
    <section class="lf-grid" id="daftarFilm">

        <!-- The Boys -->
        <div class="lf-card">
          <div class="lf-thumb" style="--hue: 215">
            <img src="https://i.pinimg.com/1200x/5d/50/c9/5d50c9ae08b4eedaa598db9033383a5a.jpg" alt="The Boys" onerror="this.style.display='none'">
            <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> 8.7</span>
          </div>
          <div class="lf-info">
            <h3>The Boys</h3>
            <ul class="lf-tags">
              <li class="on">Action</li>
              <li>Crime</li>
              <li>Drama</li>
              <li>Thriller</li>
            </ul>
            <div class="lf-meta">
              <span>2026</span>
              <span class="lf-eps">3 <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>

        <!-- Peace Maker -->
        <div class="lf-card">
          <div class="lf-thumb" style="--hue: 8">
            <span class="lf-art">Peace Maker</span>
            <img src="https://GANTI-LINK-GAMBAR/peace_maker.jpg" alt="Peace Maker" onerror="this.style.display='none'">
            <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> 8.3</span>
          </div>
          <div class="lf-info">
            <h3>Peace Maker</h3>
            <ul class="lf-tags">
              <li class="on">Action</li>
              <li>Crime</li>
              <li>Drama</li>
              <li>Thriller</li>
            </ul>
            <div class="lf-meta">
              <span>2026</span>
              <span class="lf-eps">3 <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>

        <!-- The Punisher -->
        <div class="lf-card">
          <div class="lf-thumb" style="--hue: 0">
            <span class="lf-art">The Punisher</span>
            <img src="https://GANTI-LINK-GAMBAR/the_punisher.jpg" alt="The Punisher" onerror="this.style.display='none'">
            <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> 8.1</span>
          </div>
          <div class="lf-info">
            <h3>The Punisher</h3>
            <ul class="lf-tags">
              <li class="on">Action</li>
              <li>Crime</li>
              <li>Drama</li>
              <li>Thriller</li>
            </ul>
            <div class="lf-meta">
              <span>2026</span>
              <span class="lf-eps">3 <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>

        <!-- The Old Man -->
        <div class="lf-card">
          <div class="lf-thumb" style="--hue: 35">
            <span class="lf-art">The Old Man</span>
            <img src="https://GANTI-LINK-GAMBAR/the_old_man.jpg" alt="The Old Man" onerror="this.style.display='none'">
            <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> 8.0</span>
          </div>
          <div class="lf-info">
            <h3>The Old Man</h3>
            <ul class="lf-tags">
              <li class="on">Action</li>
              <li>Crime</li>
              <li>Drama</li>
              <li>Thriller</li>
            </ul>
            <div class="lf-meta">
              <span>2026</span>
              <span class="lf-eps">3 <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>

        <!-- The Penguin -->
        <div class="lf-card">
          <div class="lf-thumb" style="--hue: 350">
            <span class="lf-art">The Penguin</span>
            <img src="https://GANTI-LINK-GAMBAR/the_penguin.jpg" alt="The Penguin" onerror="this.style.display='none'">
            <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> 8.6</span>
          </div>
          <div class="lf-info">
            <h3>The Penguin</h3>
            <ul class="lf-tags">
              <li class="on">Action</li>
              <li>Crime</li>
              <li>Drama</li>
              <li>Thriller</li>
            </ul>
            <div class="lf-meta">
              <span>2026</span>
              <span class="lf-eps">3 <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>

        <!-- S.W.A.T. -->
        <div class="lf-card">
          <div class="lf-thumb" style="--hue: 28">
            <span class="lf-art">S.W.A.T.</span>
            <img src="https://GANTI-LINK-GAMBAR/swat.jpg" alt="S.W.A.T." onerror="this.style.display='none'">
            <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> 6.8</span>
          </div>
          <div class="lf-info">
            <h3>S.W.A.T.</h3>
            <ul class="lf-tags">
              <li class="on">Action</li>
              <li>Crime</li>
              <li>Drama</li>
              <li>Thriller</li>
            </ul>
            <div class="lf-meta">
              <span>2026</span>
              <span class="lf-eps">3 <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
            </div>
          </div>
        </div>

    </section>

    <p class="lf-empty" id="kosong" hidden>Tidak ada film yang cocok.</p>

  </main>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
  <script>
    // Filter kartu berdasarkan judul saat mengetik
    const cari = document.getElementById('cariFilm');
    const kartu = document.querySelectorAll('#daftarFilm .lf-card');
    const kosong = document.getElementById('kosong');

    cari.addEventListener('input', () => {
      const kata = cari.value.trim().toLowerCase();
      let ada = 0;
      kartu.forEach(k => {
        const cocok = k.querySelector('h3').textContent.toLowerCase().includes(kata);
        k.hidden = !cocok;
        if (cocok) ada++;
      });
      kosong.hidden = ada > 0;
    });
  </script>
</body>
</html>