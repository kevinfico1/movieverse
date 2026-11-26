<?php
session_start();
require_once __DIR__ . '/../../repositories/list_film_repository.php';

$genre       = ambil_genre_list();
$banner      = ambil_banner_list();
$daftar_film = ambil_daftar_film_list();
?>
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
  <style>
    .lf-link { display: contents; color: inherit; text-decoration: none; }
  </style>
</head>
<body>

  <?php require_once __DIR__ . '/../../components/landing/topbar.php'; ?>

  <main class="lf-wrap">

    <form class="lf-search" role="search" onsubmit="return false">
      <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      <input type="search" id="cariFilm" placeholder="Cari judul film" aria-label="Cari judul film">
    </form>

    <section class="lf-hero">
      <div class="lf-hero-left">
        <h1 class="lf-genre-title"><?= e($genre) ?></h1>
        <div class="lf-rec-link">
          <span>Rekomendasi minggu ini</span>
          <span class="lf-rec-btn"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span>
        </div>
      </div>

      <div class="lf-banner" style="--banner: url('<?= e($banner['gambar']) ?>')">
        <h2><?= e($banner['judul']) ?></h2>
        <p><?= e($banner['deskripsi']) ?></p>
      </div>
    </section>

    <hr class="lf-divider">

    <section class="lf-grid" id="daftarFilm">

      <?php foreach ($daftar_film as $f): ?>
        <a class="lf-link" href="<?= e(link_detail($f['id'])) ?>">
          <div class="lf-card">
            <div class="lf-thumb" style="--hue: <?= (int)$f['warna'] ?>">
              <span class="lf-art"><?= e($f['judul']) ?></span>
              <img src="<?= e($f['poster']) ?>" alt="<?= e($f['judul']) ?>" onerror="this.style.display='none'">
              <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> <?= e($f['rating']) ?></span>
            </div>
            <div class="lf-info">
              <h3><?= e($f['judul']) ?></h3>
              <ul class="lf-tags">
                <?php foreach ($f['genre'] as $i => $g): ?>
                  <li<?= $i === 0 ? ' class="on"' : '' ?>><?= e($g) ?></li>
                <?php endforeach; ?>
              </ul>
              <div class="lf-meta">
                <span><?= e($f['tahun']) ?></span>
                <span class="lf-eps"><?= e($f['eps']) ?> <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
              </div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>

    </section>

    <p class="lf-empty" id="kosong" hidden>Tidak ada film yang cocok.</p>

  </main>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
  <script>
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