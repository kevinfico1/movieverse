<?php
session_start();

require_once __DIR__ . '/../../repositories/detail_film_repository.php';
require_once __DIR__ . '/../../repositories/film_admin_repository.php';

if (!isset($_SESSION['film_admin'])) {
  $_SESSION['film_admin'] = [];
}
if (!isset($_SESSION['genre_admin'])) {
  $_SESSION['genre_admin'] = ['Action', 'Comedy', 'Adventure', 'Crime', 'Thriller', 'Mystery', 'Drama', 'Fantasy', 'Documentary'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $aksi = $_POST['aksi'] ?? '';

  if ($aksi === 'tambah') {
    $judul = trim($_POST['judul'] ?? '');
    $tanggal = trim($_POST['tanggal'] ?? '');

    if ($tanggal === '') {
      $tanggal = date('d/m/Y');
    }

    if ($judul === '') {
      $_SESSION['pesan'] = ['teks' => 'Title tidak boleh kosong.', 'galat' => true];
    } elseif (!preg_match('#^\d{1,2}/\d{1,2}/\d{4}$#', $tanggal)) {
      $_SESSION['pesan'] = ['teks' => 'Format tanggal harus dd/mm/yyyy.', 'galat' => true];
    } else {
      $genre_film = [];
      foreach (explode(',', $_POST['genre'] ?? '') as $g) {
        $g = trim($g);
        if ($g !== '' && count($genre_film) < 4) {
          $genre_film[] = $g;
        }
      }

      $status = 'Publish';
      if (strtolower(trim($_POST['status'] ?? '')) === 'draft') {
        $status = 'Draft';
      }

      $poster = '';
      if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $ekstensi = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
        $boleh = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ekstensi, $boleh) && getimagesize($_FILES['poster']['tmp_name']) !== false) {
          $nama_file = time() . '.' . $ekstensi;
          move_uploaded_file($_FILES['poster']['tmp_name'], __DIR__ . '/../../asset/uploads/' . $nama_file);
          $poster = '/asset/uploads/' . $nama_file;
        }
      }

      $id_baru = 1001;
      foreach ($_SESSION['film_admin'] as $f) {
        if ($f['id'] >= $id_baru) {
          $id_baru = $f['id'] + 1;
        }
      }

      $_SESSION['film_admin'][] = [
        'id'        => $id_baru,
        'judul'     => $judul,
        'genre'     => $genre_film,
        'status'    => $status,
        'tanggal'   => $tanggal,
        'poster'    => $poster,
        'deskripsi' => trim($_POST['deskripsi'] ?? ''),
      ];

      if ($status === 'Publish') {
        $_SESSION['pesan'] = ['teks' => 'Film tersimpan dan sudah masuk Daftar Film.', 'galat' => false];
      } else {
        $_SESSION['pesan'] = ['teks' => 'Film tersimpan sebagai draft.', 'galat' => false];
      }
    }
  }

  if ($aksi === 'status') {
    foreach ($_SESSION['film_admin'] as $i => $f) {
      if ($f['id'] == $_POST['id']) {
        if ($f['status'] === 'Publish') {
          $_SESSION['film_admin'][$i]['status'] = 'Draft';
        } else {
          $_SESSION['film_admin'][$i]['status'] = 'Publish';
        }
      }
    }
  }

  if ($aksi === 'hapus') {
    foreach ($_SESSION['film_admin'] as $i => $f) {
      if ($f['id'] == $_POST['id']) {
        unset($_SESSION['film_admin'][$i]);
      }
    }
    $_SESSION['film_admin'] = array_values($_SESSION['film_admin']);
  }

  if ($aksi === 'genre') {
    $genre_baru = trim($_POST['genre_baru'] ?? '');
    $genre_kecil = array_map('strtolower', $_SESSION['genre_admin']);

    if ($genre_baru !== '' && !in_array(strtolower($genre_baru), $genre_kecil)) {
      $_SESSION['genre_admin'][] = ucfirst($genre_baru);
    }
  }

  header('Location: /pages/admin/dashboard.php');
  exit;
}

$pesan = $_SESSION['pesan'] ?? null;
unset($_SESSION['pesan']);

$semua = ambil_semua_film();
$genre_awal = $_SESSION['genre_admin'];

$baris = [];
foreach (array_reverse($_SESSION['film_admin']) as $f) {
  $f['milik_admin'] = true;
  $baris[] = $f;
}
foreach (array_reverse($semua, true) as $id => $f) {
  if ($id > 1000 || empty($f['genre'])) {
    continue;
  }
  $baris[] = [
    'id'          => $id,
    'judul'       => $f['judul'],
    'genre'       => $f['genre'],
    'status'      => 'Publish',
    'tanggal'     => $f['tahun'],
    'poster'      => $f['poster'] ?? '',
    'milik_admin' => false,
  ];
}
$baris = array_slice($baris, 0, 4);

$stats = [
  ['icon' => 'fa-regular fa-rectangle-list', 'label' => 'Total Series', 'nilai' => count($semua)],
  ['icon' => 'fa-solid fa-users',            'label' => 'Total Users',  'nilai' => 500],
  ['icon' => 'fa-solid fa-key',              'label' => 'Total Keys',   'nilai' => (int)($_SESSION['kunci'] ?? 0)],
  ['icon' => 'fa-solid fa-paw',              'label' => 'Total Pets',   'nilai' => 2],
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

        <div class="adm-left">
          <h2 class="adm-title">Latest edited Content</h2>

          <div class="adm-table">
            <div class="adm-row adm-head">
              <span>Title</span><span>Genre</span><span>Status / Add on</span><span>Edit/Del</span>
            </div>

            <div id="kontenList">
              <?php foreach ($baris as $k): ?>
                <?php $draft = $k['status'] === 'Draft'; ?>
                <div class="adm-row adm-item">
                  <div class="adm-judul">
                    <div class="adm-poster">
                      <?php if ($k['poster']): ?>
                        <img src="<?= e($k['poster']) ?>" alt="<?= e($k['judul']) ?>">
                      <?php else: ?>
                        <i class="fa-solid fa-film"></i>
                      <?php endif; ?>
                    </div>
                    <span><?= e($k['judul']) ?></span>
                  </div>

                  <div class="adm-chips">
                    <?php foreach ($k['genre'] as $g): ?>
                      <span class="chip"><?= e($g) ?></span>
                    <?php endforeach; ?>
                  </div>

                  <div class="adm-status">
                    <?php if ($k['milik_admin']): ?>
                      <form method="post" class="form-satu">
                        <input type="hidden" name="aksi" value="status">
                        <input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
                        <button type="submit" class="badge <?= $draft ? 'draft' : 'publish' ?>"><i></i><span><?= e(strtoupper($k['status'])) ?></span></button>
                      </form>
                    <?php else: ?>
                      <span class="badge publish"><i></i><span>PUBLISH</span></span>
                    <?php endif; ?>
                    <span class="tgl"><?= e($k['tanggal']) ?></span>
                  </div>

                  <div class="adm-aksi">
                    <?php if ($k['milik_admin']): ?>
                      <form method="post" class="form-satu" onsubmit="return confirm('Hapus film ini?')">
                        <input type="hidden" name="aksi" value="hapus">
                        <input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
                        <button type="submit" class="btn-hapus"><i class="fa-regular fa-trash-can"></i></button>
                      </form>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <h2 class="adm-title adm-title-genre">Add More Genre</h2>
          <div class="adm-genre-box">
            <button type="button" class="adm-add-genre" id="tombolTambahGenre"><span class="plus"><i class="fa-solid fa-plus"></i></span> ADD</button>
            <form method="post" id="formGenre">
              <input type="hidden" name="aksi" value="genre">
              <input type="hidden" name="genre_baru" id="genreBaru">
            </form>
            <div class="adm-genre-list">
              <?php foreach ($genre_awal as $g): ?>
                <span class="chip chip-lg"><?= e($g) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <aside class="adm-right">
          <h2 class="adm-title">Add/ Edit Media</h2>

          <form class="adm-form" id="formMedia" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="aksi" value="tambah">

            <label for="fTitle">Title</label>
            <input type="text" id="fTitle" name="judul" placeholder="Judul film" required>

            <label for="fDate">Date</label>
            <input type="text" id="fDate" name="tanggal" placeholder="dd/mm/yyyy" maxlength="10">

            <div class="adm-two">
              <div>
                <label for="fGenre">Genre</label>
                <input type="text" id="fGenre" name="genre" placeholder="Action, Crime (maks. 4)">
              </div>
              <div>
                <label for="fStatus">Status</label>
                <input type="text" id="fStatus" name="status" placeholder="Publish / Draft">
              </div>
            </div>

            <label for="fDesc">Description</label>
            <div class="adm-editor">
              <textarea id="fDesc" name="deskripsi" placeholder="Deskripsi film"></textarea>
            </div>

            <label class="adm-upload" for="fPoster">
              <img id="previewPoster" alt="" hidden>
              <i class="fa-regular fa-image" id="ikonPoster"></i>
              <input type="file" id="fPoster" name="poster" accept="image/*" hidden>
            </label>

            <?php if ($pesan): ?>
              <p class="adm-note <?= $pesan['galat'] ? 'galat' : '' ?>">
                <?= e($pesan['teks']) ?>
                <?php if (!$pesan['galat'] && strpos($pesan['teks'], 'Daftar Film') !== false): ?>
                  <a href="/pages/movies/list_film.php">Lihat</a>
                <?php endif; ?>
              </p>
            <?php endif; ?>

            <div class="adm-actions">
              <button type="reset" class="btn-clear">Clear</button>
              <button type="submit" class="btn-apply">Apply</button>
            </div>
          </form>
        </aside>

      </div>
    </main>
  </div>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="/script/script.js"></script>
  <script src="/script/admin_dashboard.js"></script>
</body>
</html>
