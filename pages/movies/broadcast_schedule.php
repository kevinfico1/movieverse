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


$jadwal = [
    'Sunday' => [
        film('The Boys', 215), film('Peacemaker', 8), film('The Punisher', 0), film('The Old Man', 35),
        film('The Penguin', 350), film('S.W.A.T.', 28), film('Reacher', 45), film('Dexter', 0),
    ],
    'Monday' => [
        film('Breaking Bad', 120), film('Better Call Saul', 30), film('Fargo', 200), film('Ozark', 190),
        film('Narcos', 15), film('Mindhunter', 210), film('Dark', 230), film('Money Heist', 355),
    ],
    'Tuesday' => [
        film('The Last of Us', 95), film('House of the Dragon', 10), film('Game of Thrones', 220), film('The Witcher', 205),
        film('Arcane', 290), film('The Bear', 25), film('Shogun', 5), film('Fallout', 60),
    ],
    'Wednesday' => [
        film('Squid Game', 330), film('Black Mirror', 240), film('The Crown', 270), film('Lupin', 215),
        film('Sherlock', 20), film('Peaky Blinders', 40), film('Vikings', 195), film('Gotham', 250),
    ],
    'Thursday' => [
        film('Daredevil', 0), film('Jessica Jones', 300), film('Luke Cage', 48), film('Iron Fist', 140),
        film('Agents of S.H.I.E.L.D.', 205), film('Arrow', 130), film('The Flash', 5), film('Supergirl', 200),
    ],
    'Friday' => [
        film('Ted', 135), film('Loki (Season 2)', 110), film('Moonknight', 220), film('The Mentalist', 20),
        film('Wednesday', 265), film('Stranger Things', 345), film('Severance', 200), film('The Rookie', 190),
    ],
    'Saturday' => [
        film('Doctor Who', 225), film('The Mandalorian', 30), film('Andor', 180), film('Ahsoka', 190),
        film('Star Trek: Strange New Worlds', 210), film('The Expanse', 25), film('Foundation', 215), film('Silo', 40),
    ],
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