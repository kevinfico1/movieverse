<?php
session_start();

require_once __DIR__ . '/../../repositories/broadcast_schedule_repository.php';

$jadwal = ambil_jadwal();

$hari_aktif = 'Friday';

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
    .bs-poster { aspect-ratio: 2 / 3; border-radius: 14px; overflow: hidden; }
    .bs-poster img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .bs-card figcaption { font-family: monospace; font-size: 9px; text-transform: uppercase; margin-top: 6px; }

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
            <a class="bs-link" href="<?= e(link_detail($f['id'])) ?>">
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