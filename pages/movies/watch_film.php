<?php
session_start();

$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Hanya bisa dibuka kalau sudah menekan Watch di halaman detail (dan kunci terpakai)
if (!isset($_SESSION['boleh_tonton']) || $_SESSION['boleh_tonton'] !== $film_id) {
    header('Location: /pages/movies/detail_film.php?id=' . $film_id);
    exit;
}

// Video berbentuk GIF: asset/video/film_<id>.gif, kalau tidak ada pakai asset/video/default.gif
$video = '';
if (file_exists(__DIR__ . '/../../asset/films/film_' . $film_id . '.gif')) {
    $video = '/asset/films/film_' . $film_id . '.gif';
} elseif (file_exists(__DIR__ . '/../../asset/films/series.gif')) {
    $video = '/asset/films/series.gif';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nonton - Planarcadia</title>
  <link rel="stylesheet" href="/style/base.css">
  <link rel="stylesheet" href="/style/watch_film/watch.css">
</head>
<body class="watch-page-body">

  <header class="watch-bar">
    <a href="/pages/movies/detail_film.php?id=<?= $film_id ?>" class="watch-exit">Exit</a>
  </header>

  <main class="watch-stage">
    <?php if ($video !== ''): ?>
      <img class="watch-video" src="<?= htmlspecialchars($video, ENT_QUOTES, 'UTF-8') ?>" alt="Video">
    <?php else: ?>
      <p class="watch-kosong">Taruh file film_<?= $film_id ?>.gif atau default.gif di folder asset/video/</p>
    <?php endif; ?>
  </main>

</body>
</html>