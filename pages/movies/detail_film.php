<?php
require_once __DIR__ . '/../../repositories/detail_film_repository.php';

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$film    = ambil_film_by_id($film_id);

// Data sesuai desain gambar
$judul     = !empty($film['judul']) ? $film['judul'] : 'Vision Quest';
$rating    = !empty($film['rating']) ? $film['rating'] : '8.3';
$deskripsi = !empty($film['deskripsi']) ? $film['deskripsi'] : 'Serial ini akan berfokus pada karakter White Vision (Paul Bettany) yang diperkenalkan dalam WandaVision. Plotnya mengikuti perjalanan sintozoid tersebut saat ia berusaha memulihkan ingatannya yang hilang, mengeksplorasi kembali identitas dan keberadaannya, serta mencari tujuan baru dalam hidupnya setelah kehilangan keterikatan emosionalnya di Westview.';
$poster    = !empty($film['poster']) ? $film['poster'] : 'https://i.pinimg.com/736x/9d/57/7e/9d577e728888b03995b0010d48204be3.jpg';

$episode = ambil_episode();
$serupa  = ambil_serupa();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($judul) ?> - Planarcadia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/style/base.css">
  <link rel="stylesheet" href="/style/auth/topbar.css">
  <link rel="stylesheet" href="/style/detail_film/detail.css">
  <link rel="stylesheet" href="/style/auth/footer.css">
</head>
<body class="detail-page-body">

  <?php include __DIR__ . '/../../components/landing/topbar.php'; ?>

  <main class="detail-wrap">
    <div class="detail-box">

      <section class="detail-top">
        <div class="detail-poster">
          <img src="<?= e($poster) ?>" alt="<?= e($judul) ?>"
               onerror="this.onerror=null; this.src='https://via.placeholder.com/180x270';">
        </div>

        <div class="detail-info">
          <div class="detail-title-row">
            <h1 class="detail-title"><?= e($judul) ?></h1>
            <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= e($rating) ?></span>
          </div>

          <p class="detail-desc"><?= e($deskripsi) ?></p>

          <div class="detail-actions">
            <button class="btn-primary"><img class="lock-icon" src="/asset/photos/lock.png" alt="Lock"> Watch</button>
            <button class="btn-secondary"><i class="fa-regular fa-bookmark"></i> Add</button>
          </div>
        </div>

        <aside class="key-card">
          <div class="key-left">
            <span class="key-text">1 Key</span>
            <button class="btn-small">Get more</button>
          </div>
          <div class="key-right">
            <img class="key-img" src="/asset/photos/key.png" alt="Key" onerror="this.style.display='none'">
          </div>
        </aside>
      </section>

      <section class="detail-bottom">
        <div class="episode-col">
          <h2 class="detail-heading">Episode</h2>
          <?php foreach ($episode as $nama): ?>
            <div class="episode-item">
              <span><?= e($nama) ?></span>
              <button class="open-btn"><img class="lock-icon" src="/asset/photos/lock.png" alt="Lock"> OPEN</button>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="similar-col">
          <h2 class="detail-heading">Similar</h2>
          <?php foreach ($serupa as $item): ?>
            <div class="similar-item">
              <div class="similar-thumb">
                <img src="<?= e($item['poster']) ?>" alt="<?= e($item['judul']) ?>" onerror="this.style.display='none'">
              </div>
              <div class="similar-info">
                <h4><?= e($item['judul']) ?></h4>
                <div class="similar-tags">
                  <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= e($item['rating']) ?></span>
                  <button class="btn-add-sm"><i class="fa-regular fa-bookmark"></i> ADD</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

    </div>
  </main>

  <?php include __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
</body>
</html>