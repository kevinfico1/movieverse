<?php
require_once __DIR__ . '/../../config/database.php';

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}


$semua_film = [
    ['id' => 1, 'judul' => 'The Boys',    'rating' => '8.7', 'tahun' => 2026, 'episode' => 3, 'warna' => 215, 'poster' => '', 'genre' => ['Action', 'Crime', 'Drama', 'Thriller']],
    ['id' => 2, 'judul' => 'Peace Maker', 'rating' => '8.3', 'tahun' => 2026, 'episode' => 3, 'warna' => 8,   'poster' => '', 'genre' => ['Action', 'Crime', 'Drama', 'Thriller']],
    ['id' => 3, 'judul' => 'The Punisher','rating' => '8.1', 'tahun' => 2026, 'episode' => 3, 'warna' => 0,   'poster' => '', 'genre' => ['Action', 'Crime', 'Drama', 'Thriller']],
    ['id' => 4, 'judul' => 'The Old Man', 'rating' => '8.0', 'tahun' => 2026, 'episode' => 3, 'warna' => 35,  'poster' => '', 'genre' => ['Action', 'Crime', 'Drama', 'Thriller']],
    ['id' => 5, 'judul' => 'The Penguin', 'rating' => '8.6', 'tahun' => 2026, 'episode' => 3, 'warna' => 350, 'poster' => '', 'genre' => ['Action', 'Crime', 'Drama', 'Thriller']],
    ['id' => 6, 'judul' => 'S.W.A.T.',    'rating' => '6.8', 'tahun' => 2026, 'episode' => 3, 'warna' => 28,  'poster' => '', 'genre' => ['Action', 'Crime', 'Drama', 'Thriller']],
];


$rekomendasi = [
    'id'        => 7,
    'judul'     => 'Reacher',
    'deskripsi' => 'Jack Reacher, mantan polisi militer, singgah di sebuah kota kecil dan terseret ke dalam konspirasi yang tidak bisa ia abaikan.',
];

$genre = isset($_GET['genre']) ? trim($_GET['genre']) : 'Action';
$q     = isset($_GET['q']) ? trim($_GET['q']) : '';

$daftar = array_filter($semua_film, function ($film) use ($genre, $q) {
    $cocok_genre = in_array($genre, $film['genre'], true);
    $cocok_judul = $q === '' || stripos($film['judul'], $q) !== false;
    return $cocok_genre && $cocok_judul;
});

function poster_lokal($path) {
    if ($path === '') return null;
    return file_exists(__DIR__ . '/../../' . ltrim($path, '/')) ? $path : null;
}
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
</head>
<body>

  <?php require_once __DIR__ . '/../../components/landing/topbar.php'; ?>

  <main class="lf-wrap">

    <form class="lf-search" method="get" action="/pages/movies/list_film.php" role="search">
      <input type="hidden" name="genre" value="<?= e($genre) ?>">
      <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      <input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari judul film" aria-label="Cari judul film">
    </form>

    <!-- Judul genre + rekomendasi minggu ini -->
    <section class="lf-hero">
      <div class="lf-hero-left">
        <h1 class="lf-genre-title"><?= e($genre) ?></h1>
        <div class="lf-rec-link">
          <span>Rekomendasi minggu ini</span>
          <span class="lf-rec-btn"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span>
        </div>
      </div>

      <div class="lf-banner">
        <h2><?= e($rekomendasi['judul']) ?></h2>
        <p><?= e($rekomendasi['deskripsi']) ?></p>
      </div>
    </section>

    <hr class="lf-divider">

    <?php if (count($daftar) === 0): ?>
      <p class="lf-empty">
        Tidak ada film yang cocok<?= $q !== '' ? ' dengan "' . e($q) . '"' : '' ?>.
        <a href="/pages/movies/list_film.php">Lihat semua film</a>
      </p>
    <?php else: ?>
      <section class="lf-grid">
        <?php foreach ($daftar as $film): ?>
          <?php $poster = poster_lokal($film['poster']); ?>
          <div class="lf-card">
            <div class="lf-thumb" style="--hue: <?= (int)$film['warna'] ?>">
              <?php if ($poster): ?>
                <img src="<?= e($poster) ?>" alt="<?= e($film['judul']) ?>">
              <?php else: ?>
                <span class="lf-art"><?= e($film['judul']) ?></span>
              <?php endif; ?>
              <span class="lf-rating"><i class="fa-solid fa-star" aria-hidden="true"></i> <?= e($film['rating']) ?></span>
            </div>

            <div class="lf-info">
              <h3><?= e($film['judul']) ?></h3>
              <ul class="lf-tags">
                <?php foreach ($film['genre'] as $i => $g): ?>
                  <li class="<?= $g === $genre ? 'on' : '' ?>"><?= e($g) ?></li>
                <?php endforeach; ?>
              </ul>
              <div class="lf-meta">
                <span><?= (int)$film['tahun'] ?></span>
                <span class="lf-eps"><?= (int)$film['episode'] ?> <i class="fa-solid fa-layer-group" aria-hidden="true"></i></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>

  </main>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
</body>
</html>