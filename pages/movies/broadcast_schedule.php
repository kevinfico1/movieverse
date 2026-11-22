<?php
date_default_timezone_set('Asia/Jakarta');

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}

function film($judul, $warna, $poster = '') {
    return ['judul' => $judul, 'warna' => $warna, 'poster' => $poster];
}

// Link ke halaman detail film (ubah di sini kalau parameter halaman detailmu beda)
function link_detail($judul) {
    return '/pages/movies/detail_film.php?judul=' . urlencode($judul);
}

// Daftar film (dipakai semua hari, jadi gambar cukup diisi sekali di sini)
// Format: film('Judul', warna, 'lokasi file gambar ATAU link gambar')
$film_harian = [
    film('Ted',             135, 'https://i.pinimg.com/736x/48/ae/09/48ae0932ec9fd9cb5a69f5f52ab182db.jpg'),
    film('Loki (Season 2)', 110, 'https://i.pinimg.com/736x/80/3d/b4/803db4d3fb0b7de9bf8a6afebbd49db4.jpg'),
    film('Moonknight',      220, 'https://i.pinimg.com/736x/7b/c2/e5/7bc2e55176c3763545d869cc1d33ae15.jpg'),
    film('The Mentalist',    20, 'https://i.pinimg.com/1200x/3a/b7/08/3ab70800ec4755b3cd92382c41544c4f.jpg'),
    film('Wednesday',       265, 'https://i.pinimg.com/736x/92/bc/09/92bc090faff90be339a435fc322ea511.jpg'),
    film('Stranger Things', 345, 'https://i.pinimg.com/736x/de/11/d9/de11d91843c02c300b52cf5a9345b9d9.jpg'),
    film('Severance',       200, 'https://i.pinimg.com/1200x/10/dd/d4/10ddd4b1754ece422f20b54cdba3174d.jpg'),
    film('The Rookie',      190, 'https://i.pinimg.com/736x/b9/10/46/b910468afe3d7cdc8229080b11ca8ee1.jpg'),
];

$jadwal = [
    'Sunday'    => $film_harian,
    'Monday'    => $film_harian,
    'Tuesday'   => $film_harian,
    'Wednesday' => $film_harian,
    'Thursday'  => $film_harian,
    'Friday'    => $film_harian,
    'Saturday'  => $film_harian,
];

$hari_aktif = date('l'); // nama hari ini dalam bahasa Inggris, mis. "Friday"

function poster_lokal($path) {
    if ($path === '') return null;
    if (preg_match('#^https?://#i', $path)) return $path; // link gambar (URL)
    return file_exists(__DIR__ . '/../../' . ltrim($path, '/')) ? '/' . ltrim($path, '/') : null;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Broadcast Schedule - Planarcadia</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/style/base.css">
  <link rel="stylesheet" href="/style/auth/topbar.css">
  <link rel="stylesheet" href="/style/broadcast-schedule/broadcast_schedule.css">
  <link rel="stylesheet" href="/style/auth/footer.css">
  <style>
    /* Poster seragam seperti di desain */
    .bs-poster { aspect-ratio: 2 / 3; border-radius: 14px; overflow: hidden; }
    .bs-poster img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .bs-card figcaption { font-family: monospace; font-size: 9px; text-transform: uppercase; margin-top: 6px; }

    /* Poster bisa diklik (tampilan tidak berubah) */
    .bs-link { text-decoration: none; color: inherit; display: block; }
  </style>
</head>
<body>

  <?php require_once __DIR__ . '/../../components/landing/topbar.php'; ?>

  <main class="bs-stage">
    <section class="bs-panel">

      <div class="bs-head">
        <h1 class="bs-title" id="bsTitle" aria-live="polite"><?= e($hari_aktif) ?></h1>

        <div class="bs-days" role="tablist" aria-label="Pilih hari tayang">
          <?php foreach ($jadwal as $hari => $daftar): ?>
            <?php $aktif = ($hari === $hari_aktif); ?>
            <button type="button"
                    class="bs-day<?= $aktif ? ' active' : '' ?>"
                    role="tab"
                    id="tab-<?= strtolower($hari) ?>"
                    aria-controls="panel-<?= strtolower($hari) ?>"
                    aria-selected="<?= $aktif ? 'true' : 'false' ?>"
                    tabindex="<?= $aktif ? '0' : '-1' ?>"
                    data-day="<?= e($hari) ?>"><?= e($hari) ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <hr class="bs-divider">

      <?php foreach ($jadwal as $hari => $daftar): ?>
        <?php $aktif = ($hari === $hari_aktif); ?>
        <div class="bs-grid"
             role="tabpanel"
             id="panel-<?= strtolower($hari) ?>"
             aria-labelledby="tab-<?= strtolower($hari) ?>"
             <?= $aktif ? '' : 'hidden' ?>>
          <?php foreach ($daftar as $f): ?>
            <?php $poster = poster_lokal($f['poster']); ?>
            <a class="bs-link" href="<?= e(link_detail($f['judul'])) ?>">
              <figure class="bs-card">
                <div class="bs-poster" style="--hue: <?= (int)$f['warna'] ?>">
                  <?php if ($poster): ?>
                    <img src="<?= e($poster) ?>" alt="<?= e($f['judul']) ?>" loading="lazy">
                  <?php else: ?>
                    <span class="bs-art"><?= e($f['judul']) ?></span>
                  <?php endif; ?>
                </div>
                <figcaption><?= e($f['judul']) ?></figcaption>
              </figure>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>

    </section>
  </main>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
  <script src="/script/broadcast_schedule.js"></script>
</body>
</html>