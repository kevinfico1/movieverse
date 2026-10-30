<?php
require_once __DIR__ . '/config/database.php';

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$film = null;

try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("SELECT * FROM film WHERE id = :id");
        $stmt->execute(['id' => $film_id]);
        $film = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $ex) {
    // koneksi gagal: pakai data cadangan
}

// Data sesuai desain gambar
$judul     = !empty($film['judul']) ? $film['judul'] : 'The Boys';
$rating    = !empty($film['rating']) ? $film['rating'] : '8.3';
$deskripsi = !empty($film['deskripsi']) ? $film['deskripsi'] : 'Serial ini akan berfokus pada karakter White Vision (Paul Bettany) yang diperkenalkan dalam WandaVision. Plotnya mengikuti perjalanan sintozoid tersebut saat ia berusaha memulihkan ingatannya yang hilang, mengeksplorasi kembali identitas dan keberadaannya, serta mencari tujuan baru dalam hidupnya setelah kehilangan keterikatan emosionalnya di Westview.';
$poster    = !empty($film['poster']) ? $film['poster'] : 'https://i.pinimg.com/736x/34/42/4a/34424a58ff9af4becbd5b729a5af98bc.jpg';

// Daftar Episode
$episode = [
    'No Strings',
    'Theseus',
    'Reboot'
];

// Daftar Film / Series Serupa
$serupa = [
    [
        'judul'  => 'WandaVision', 
        'rating' => '8.3', 
        'poster' => 'https://i.pinimg.com/736x/c2/77/fb/c277fb23118b1431d2bb75e13ffceed9.jpg'
    ],
    [
        'judul'  => 'Agatha All Along', 
        'rating' => '7.3', 
        'poster' => 'https://i.pinimg.com/736x/11/2f/48/112f48d07127371768708c60ed4995b4.jpg'
    ],
    [
        'judul'  => 'Severance', 
        'rating' => '8.3', 
        'poster' => 'https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg'
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($judul) ?> - Planarcadia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body class="detail-page-body">

  <?php include 'components/landing/header.php'; ?>

  <main class="detail-wrap">
    <div class="detail-box">

      <!-- Section Atas: Hero Banner & Info Film -->
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
            <button class="btn-primary"><i class="fa-solid fa-lock"></i> Watch</button>
            <button class="btn-secondary"><i class="fa-regular fa-bookmark"></i> Add</button>
          </div>
        </div>

        <!-- Kartu 1 Key -->
        <aside class="key-card">
          <img class="key-img" src="key.png" alt="Key" onerror="this.style.display='none'">
          <div class="key-bottom">
            <span class="key-text">1 Key</span>
            <button class="btn-small">Get more</button>
          </div>
        </aside>
      </section>

      <!-- Section Bawah: Episode & Similar -->
      <section class="detail-bottom">
        <div class="episode-col">
          <h2 class="detail-heading">Episode</h2>
          <?php foreach ($episode as $nama): ?>
            <div class="episode-item">
              <span><?= e($nama) ?></span>
              <button class="open-btn"><i class="fa-solid fa-lock"></i> OPEN</button>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="similar-col">
          <h2 class="detail-heading">Similar</h2>
          <?php foreach ($serupa as $item): ?>
            <div class="similar-item">
              <div class="similar-thumb">
                <img src="<?= e($item['poster']) ?>" alt="<?= e($item['judul']) ?>" onerror="this.style.display='none'">
                <i class="fa-regular fa-image"></i>
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

  <?php include 'components/landing/footer.php'; ?>

  <script src="script.js"></script>
</body>
</html>