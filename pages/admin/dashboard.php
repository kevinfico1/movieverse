<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: /pages/auth/login.php');
  exit;
}
if (($_SESSION['user_role'] ?? '') !== 'admin') {
  header('Location: /index.php');
  exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../repositories/detail_film_repository.php';

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'tambah') {
      $judul = mb_substr(trim($_POST['judul'] ?? ''), 0, 150);
      $tanggal = trim($_POST['tanggal'] ?? '');

      if ($tanggal === '') {
        $tanggal = date('d/m/Y');
      }

      // Tanggal boleh ditulis tanpa nol di depan, contoh: 15/2/2010 atau 05/02/2010
      $bagian = explode('/', $tanggal);

      $tanggal_benar = count($bagian) === 3
        && ctype_digit($bagian[0]) && ctype_digit($bagian[1]) && ctype_digit($bagian[2])
        && strlen($bagian[2]) === 4
        && checkdate((int) $bagian[1], (int) $bagian[0], (int) $bagian[2])
        && (int) $bagian[2] >= 1901 && (int) $bagian[2] <= 2155;

      $tahun = $tanggal_benar ? (int) $bagian[2] : 0;

      if ($judul === '') {
        $_SESSION['pesan'] = ['teks' => 'Title tidak boleh kosong.', 'galat' => true];
      } elseif (!$tanggal_benar) {
        $_SESSION['pesan'] = ['teks' => 'Format tanggal harus dd/mm/yyyy, contoh 15/2/2010.', 'galat' => true];
      } else {
        $genre_kiriman = $_POST['genre'] ?? [];
        if (!is_array($genre_kiriman)) {
          $genre_kiriman = [];
        }

        $genre_film = [];
        foreach ($genre_kiriman as $g) {
          $g = mb_substr(trim($g), 0, 50);
          if ($g !== '' && count($genre_film) < 4) {
            $genre_film[] = ucfirst($g);
          }
        }

        $status = 'published';
        if (strtolower(trim($_POST['status'] ?? '')) === 'draft') {
          $status = 'archived';
        }

        $pdo->beginTransaction();

        // Pastikan ID film baru selalu di atas ID film bawaan, supaya tampil di Daftar Film.
        $id_terbesar = (int) $pdo->query('SELECT COALESCE(MAX(id), 0) FROM movies')->fetchColumn();

        if ($id_terbesar < ID_FILM_AWAL) {
          $query = $pdo->prepare("INSERT INTO movies (id, title, type, release_year, synopsis, status) VALUES (?, ?, 'series', ?, ?, ?)");
          $query->execute([ID_FILM_AWAL + 1, $judul, $tahun, trim($_POST['deskripsi'] ?? ''), $status]);
          $id_baru = ID_FILM_AWAL + 1;
        } else {
          $query = $pdo->prepare("INSERT INTO movies (title, type, release_year, synopsis, status) VALUES (?, 'series', ?, ?, ?)");
          $query->execute([$judul, $tahun, trim($_POST['deskripsi'] ?? ''), $status]);
          $id_baru = (int) $pdo->lastInsertId();
        }

        foreach ($genre_film as $nama) {
          $query = $pdo->prepare('INSERT IGNORE INTO categories (name) VALUES (?)');
          $query->execute([$nama]);

          $query = $pdo->prepare('SELECT id FROM categories WHERE name = ?');
          $query->execute([$nama]);
          $id_kategori = $query->fetchColumn();

          $query = $pdo->prepare('INSERT IGNORE INTO movie_categories (movie_id, category_id) VALUES (?, ?)');
          $query->execute([$id_baru, $id_kategori]);
        }

        $pdo->commit();

        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
          $ekstensi = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
          $boleh = ['jpg', 'jpeg', 'png', 'webp'];

          if (in_array($ekstensi, $boleh) && getimagesize($_FILES['poster']['tmp_name']) !== false) {
            move_uploaded_file($_FILES['poster']['tmp_name'], __DIR__ . '/../../asset/uploads/film_' . $id_baru . '.' . $ekstensi);
          }
        }

        if ($status === 'published') {
          $_SESSION['pesan'] = ['teks' => 'Film tersimpan dan sudah masuk Daftar Film.', 'galat' => false];
        } else {
          $_SESSION['pesan'] = ['teks' => 'Film tersimpan sebagai draft.', 'galat' => false];
        }
      }
    }

    if ($aksi === 'status') {
      $query = $pdo->prepare("UPDATE movies SET status = IF(status = 'published', 'archived', 'published') WHERE id = ?");
      $query->execute([(int)($_POST['id'] ?? 0)]);
    }

    if ($aksi === 'hapus') {
      $id = (int)($_POST['id'] ?? 0);

      foreach (glob(__DIR__ . '/../../asset/uploads/film_' . $id . '.*') as $file) {
        unlink($file);
      }

      // Hapus dulu data di tabel lain yang terhubung ke film ini (foreign key), baru filmnya.
      $query = $pdo->prepare('SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME = ? AND REFERENCED_COLUMN_NAME = ?');
      $query->execute(['movies', 'id']);
      $relasi = $query->fetchAll();

      $pdo->beginTransaction();

      foreach ($relasi as $r) {
        $query = $pdo->prepare('DELETE FROM `' . str_replace('`', '', $r['TABLE_NAME']) . '` WHERE `' . str_replace('`', '', $r['COLUMN_NAME']) . '` = ?');
        $query->execute([$id]);
      }

      $query = $pdo->prepare('DELETE FROM movies WHERE id = ?');
      $query->execute([$id]);

      $pdo->commit();
    }

    if ($aksi === 'genre') {
      $genre_baru = mb_substr(trim($_POST['genre_baru'] ?? ''), 0, 50);

      if ($genre_baru !== '') {
        $query = $pdo->prepare('INSERT IGNORE INTO categories (name) VALUES (?)');
        $query->execute([ucfirst($genre_baru)]);
      }
    }

    header('Location: /pages/admin/dashboard.php');
    exit;
  }

  $genre_awal = $pdo->query('SELECT name FROM categories ORDER BY name')->fetchAll(PDO::FETCH_COLUMN);

  $film_terbaru = $pdo->query('SELECT id, title, status, release_year FROM movies ORDER BY id DESC')->fetchAll();

  foreach ($film_terbaru as $i => $f) {
    $query = $pdo->prepare('SELECT c.name FROM categories c JOIN movie_categories mc ON mc.category_id = c.id WHERE mc.movie_id = ? ORDER BY c.name LIMIT 4');
    $query->execute([$f['id']]);
    $film_terbaru[$i]['genre'] = $query->fetchAll(PDO::FETCH_COLUMN);
  }

  $total_series = $pdo->query("SELECT COUNT(*) FROM movies WHERE type = 'series'")->fetchColumn();
  $total_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
} catch (PDOException $error) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  die('Database error: ' . $error->getMessage());
}

$pesan = $_SESSION['pesan'] ?? null;
unset($_SESSION['pesan']);

$poster_bawaan = [];
foreach (ambil_semua_film() as $f) {
  $poster_bawaan[$f['judul']] = $f['poster'] ?? '';
}

$baris = [];
foreach ($film_terbaru as $f) {
  $poster = cari_poster($f['id']);
  if ($poster === '') {
    $poster = $poster_bawaan[$f['title']] ?? '';
  }

  $baris[] = [
    'id'      => $f['id'],
    'judul'   => $f['title'],
    'genre'   => $f['genre'],
    'status'  => $f['status'] === 'published' ? 'Publish' : 'Draft',
    'tanggal' => $f['release_year'],
    'poster'  => $poster,
  ];
}

$stats = [
  ['icon' => 'fa-regular fa-rectangle-list', 'label' => 'Total Series', 'nilai' => $total_series],
  ['icon' => 'fa-solid fa-users',            'label' => 'Total Users',  'nilai' => $total_users],
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

          <div id="kontenList">
            <?php foreach ($baris as $k): ?>
              <?php $draft = $k['status'] === 'Draft'; ?>
              <div class="adm-item">
                <div class="adm-kiri">
                  <div class="adm-poster">
                    <?php if ($k['poster']): ?>
                      <img src="<?= e($k['poster']) ?>" alt="<?= e($k['judul']) ?>">
                    <?php else: ?>
                      <i class="fa-solid fa-film"></i>
                    <?php endif; ?>
                  </div>

                  <div class="adm-info">
                    <span class="adm-judul"><?= e($k['judul']) ?></span>
                    <div class="adm-chips">
                      <?php foreach ($k['genre'] as $g): ?>
                        <span class="chip"><?= e($g) ?></span>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>

                <div class="adm-status">
                  <form method="post" class="form-satu">
                    <input type="hidden" name="aksi" value="status">
                    <input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
                    <button type="submit" class="badge <?= $draft ? 'draft' : 'publish' ?>"><i></i><span><?= e(strtoupper($k['status'])) ?></span></button>
                  </form>
                  <span class="tgl"><?= e($k['tanggal']) ?></span>
                </div>

                <div class="adm-aksi">
                  <form method="post" class="form-satu" onsubmit="return confirm('Hapus film ini?')">
                    <input type="hidden" name="aksi" value="hapus">
                    <input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
                    <button type="submit" class="btn-hapus"><i class="fa-regular fa-trash-can"></i></button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
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
                <button type="button" class="chip chip-lg genre-pilih" data-genre="<?= e($g) ?>"><?= e($g) ?></button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <aside class="adm-right">
          <h2 class="adm-title">Add/ Edit Media</h2>

          <form class="adm-form" id="formMedia" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="aksi" value="tambah">
            <div id="genreTersembunyi"></div>

            <label for="fTitle">Title</label>
            <input type="text" id="fTitle" name="judul" placeholder="Judul film" required>

            <label for="fDate">Date</label>
            <input type="text" id="fDate" name="tanggal" placeholder="dd/mm/yyyy" maxlength="10">

            <div class="adm-two">
              <div>
                <label for="fGenre">Genre (maks. 4)</label>
                <input type="text" id="fGenre" placeholder="Klik genre di bawah" readonly>
              </div>
              <div>
                <label for="fStatus">Status</label>
                <select id="fStatus" name="status">
                  <option value="Publish">Publish</option>
                  <option value="Draft">Draft</option>
                </select>
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