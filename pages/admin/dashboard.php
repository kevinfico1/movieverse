<?php
session_start();

require_once __DIR__ . '/../../repositories/detail_film_repository.php';
require_once __DIR__ . '/../../repositories/genre.php'; // menyediakan $genre

require_once __DIR__ . '/../../repositories/film_admin_repository.php';

$semua = ambil_semua_film();
$genre_default = ['Action', 'Comedy', 'Adventure', 'Crime', 'Thriller', 'Mystery', 'Drama', 'Fantasy', 'Documentary'];

$state = muat_state_admin();
if ($state !== null) {
  // Data yang sudah disimpan admin
  $konten     = $state['items'];
  $genre_awal = $state['genres'] ?: $genre_default;
} else {
  // Belum pernah disimpan: pakai film bawaan (4 terakhir yang punya genre)
  $konten = [];
  foreach (array_reverse($semua, true) as $id => $f) {
    if (empty($f['genre'])) continue;
    $konten[] = [
      'id'      => 'awal-' . $id,
      'judul'   => $f['judul'],
      'genre'   => $f['genre'],
      'status'  => 'Publish',
      'tanggal' => date('d/m/Y'),
      'poster'  => $f['poster'] ?? '',
      'admin'   => false,
    ];
    if (count($konten) === 4) break;
  }
  $genre_awal = $genre_default;
}
$jumlah_pet = 2; // Echo & Aha (lihat halaman Genre)

$stats = [
  ['icon' => 'fa-regular fa-rectangle-list', 'label' => 'Total Series', 'nilai' => count($semua)],
  ['icon' => 'fa-solid fa-users',            'label' => 'Total Users',  'nilai' => 500],
  ['icon' => 'fa-solid fa-key',              'label' => 'Total Keys',   'nilai' => (int)($_SESSION['kunci'] ?? 0)],
  ['icon' => 'fa-solid fa-paw',              'label' => 'Total Pets',   'nilai' => $jumlah_pet],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Planarcadia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/style/base.css">
  <link rel="stylesheet" href="/style/auth/topbar.css">
  <link rel="stylesheet" href="/style/admin/dashboard.css">
  <link rel="stylesheet" href="/style/auth/footer.css">
</head>
<body>

  <?php require_once __DIR__ . '/../../components/landing/topbar.php'; ?>

  <div class="adm-frame">
    <main class="adm-panel">

      <a href="/index.php" class="adm-home"><i class="fa-solid fa-house"></i> Home</a>

      <h1 class="adm-hello">Hello Admin</h1>

      <section class="adm-stats">
        <?php foreach ($stats as $s): ?>
          <div class="adm-stat">
            <i class="<?= e($s['icon']) ?>"></i>
            <span><?= e($s['label']) ?>: <strong><?= (int)$s['nilai'] ?></strong></span>
          </div>
        <?php endforeach; ?>
      </section>

      <div class="adm-grid">

        <!-- Kolom kiri -->
        <div class="adm-left">
          <h2 class="adm-title">Latest edited Content</h2>

          <div class="adm-table">
            <div class="adm-row adm-head">
              <span>Title</span><span>Genre</span><span>Status / Add on</span><span>Edit/Del</span>
            </div>

            <div id="kontenList">
              <?php foreach (array_slice($konten, 0, 4) as $k): ?>
                <div class="adm-row adm-item">
                  <div class="adm-judul">
                    <div class="adm-poster">
                      <?php if ($k['poster']): ?>
                        <img src="<?= e($k['poster']) ?>" alt="<?= e($k['judul']) ?>" onerror="this.remove()">
                      <?php else: ?>
                        <i class="fa-solid fa-film"></i>
                      <?php endif; ?>
                    </div>
                    <span><?= e($k['judul']) ?></span>
                  </div>

                  <div class="adm-chips">
                    <?php foreach ($k['genre'] as $g): ?><span class="chip"><?= e($g) ?></span><?php endforeach; ?>
                  </div>

                  <div class="adm-status">
                    <?php $draft = $k['status'] === 'Draft'; ?>
                    <button type="button" class="badge <?= $draft ? 'draft' : 'publish' ?>" aria-label="Ubah status"><i></i><span><?= e(strtoupper($k['status'])) ?></span></button>
                    <span class="tgl"><?= e($k['tanggal']) ?></span>
                  </div>

                  <div class="adm-aksi">
                    <button type="button" class="btn-hapus" aria-label="Hapus <?= e($k['judul']) ?>"><i class="fa-regular fa-trash-can"></i></button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <h2 class="adm-title adm-title-genre">Add More Genre</h2>
          <div class="adm-genre-box">
            <button type="button" class="adm-add-genre" id="tombolTambahGenre"><span class="plus"><i class="fa-solid fa-plus"></i></span> ADD</button>
            <div class="adm-genre-list" id="genreList">
              <?php foreach ($genre_awal as $g): ?><span class="chip chip-lg"><?= e($g) ?></span><?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Kolom kanan -->
        <aside class="adm-right">
          <h2 class="adm-title">Add/ Edit Media</h2>

          <form class="adm-form" id="formMedia" autocomplete="off">
            <label for="fTitle">Title</label>
            <input type="text" id="fTitle" placeholder="Dispatcher text" required>

            <label for="fDate">Date</label>
            <input type="text" id="fDate" placeholder="dd/mm/yyyy" inputmode="numeric" maxlength="10">

            <div class="adm-two">
              <div>
                <label for="fGenre">Genre</label>
                <input type="text" id="fGenre" placeholder="Action, Crime (maks. 4)">
              </div>
              <div>
                <label for="fStatus">Status</label>
                <input type="text" id="fStatus" placeholder="Dispatcher text">
              </div>
            </div>

            <label for="fDesc">Description</label>
            <div class="adm-editor">
              <textarea id="fDesc" placeholder="Text-feed content"></textarea>
            </div>

            <label class="adm-upload" for="fPoster">
              <img id="previewPoster" alt="" hidden>
              <i class="fa-regular fa-image" id="ikonPoster"></i>
              <input type="file" id="fPoster" accept="image/*" hidden>
            </label>

            <p class="adm-note" id="catatan" role="status" hidden></p>

            <div class="adm-actions">
              <button type="reset" class="btn-clear">Clear</button>
              <button type="submit" class="btn-apply">Apply</button>
            </div>
          </form>
        </aside>

      </div>
    </main>
  </div>

  <script id="dataAwal" type="application/json"><?= json_encode(['items' => $konten, 'genres' => $genre_awal], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?></script>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
  <script src="/script/admin_dashboard.js"></script>
</body>
</html>
