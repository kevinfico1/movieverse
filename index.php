<?php
  require_once __DIR__ . '/config/database.php';
  require_once __DIR__ . '/repositories/home_repository.php';

  $hero     = ambil_hero_home();
  $trending = ambil_trending_home();
  $series   = ambil_series_home();

  function e($teks) {
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planarcadia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style/base.css">
  <link rel="stylesheet" href="style/auth/topbar.css">
  <link rel="stylesheet" href="style/home_page/hero.css">
  <link rel="stylesheet" href="style/home_page/home.css">
  <link rel="stylesheet" href="style/auth/footer.css">
</head>
<body>

  <?php include __DIR__ . '/components/landing/topbar.php'; ?>

  <section class="hero-banner">
    <div class="hero-content">
      <span class="studio-tag"><?= e($hero['studio']) ?></span>
      <h1 class="hero-title"><?= e($hero['judul']) ?></h1>
      
      <div class="hero-meta">
        <span class="rating"><i class="fa-solid fa-star"></i> <?= e($hero['rating']) ?></span>
        <span class="divider">|</span>
        <span><?= e($hero['tahun']) ?></span>
        <span class="divider">|</span>
        <span><?= e($hero['durasi']) ?></span>
        <span class="divider">|</span>
        <span><?= e($hero['genre']) ?></span>
      </div>

      <p class="hero-desc">
        <?= e($hero['deskripsi']) ?>
      </p>

      <a href="/pages/movies/detail_film.php?id=<?= (int)$hero['id_detail'] ?>" class="btn-watch">
        <i class="fa-solid fa-play"></i> Watch
      </a>
    </div>
  </section>

  <main class="katalog-container">
    <section class="katalog-section">
      <h2 class="section-title">Trending Now</h2>
      <div class="section-line"></div>
      
      <div class="movie-grid">
        <?php foreach ($trending as $f): ?>
        <a class="movie-card" href="/pages/movies/detail_film.php?id=<?= (int)$f['id'] ?>">
          <div class="poster-box">
            <img src="<?= e($f['poster']) ?>" alt="<?= e($f['judul']) ?>" onerror="this.style.display='none'">
            <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= e($f['rating']) ?></span>
          </div>
          <div class="movie-info">
            <h3><?= e($f['judul']) ?></h3>
            <span><?= e($f['tahun']) ?></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="katalog-section">
      <h2 class="section-title">Series</h2>
      <div class="section-line"></div>

      <div class="movie-grid">
        <?php foreach ($series as $f): ?>
        <a class="movie-card" href="/pages/movies/detail_film.php?id=<?= (int)$f['id'] ?>">
          <div class="poster-box">
            <img src="<?= e($f['poster']) ?>" alt="<?= e($f['judul']) ?>" onerror="this.style.display='none'">
            <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= e($f['rating']) ?></span>
          </div>
          <div class="movie-info">
            <h3><?= e($f['judul']) ?></h3>
            <span><?= e($f['tahun']) ?></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/components/landing/footer.php'; ?>

  <script src="script/script.js"></script>
</body>
</html>