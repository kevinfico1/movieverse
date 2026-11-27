<?php
session_start();

if (!isset($_SESSION['kunci'])) {
    $_SESSION['kunci'] = 0;
}

// Klaim 1 kunci setelah iklan selesai (dipanggil lewat fetch dari halaman ini). Jumlah kunci tidak dibatasi.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'iklan') {
    $_SESSION['boleh_klaim'] = true;
    $_SESSION['kunci']++;

    header('Content-Type: application/json');
    echo json_encode(['kunci' => (int) $_SESSION['kunci']]);
    exit;
}

// Tombol Watch / OPEN: pakai 1 kunci lalu izinkan membuka halaman tontonan film ini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'tonton') {
    $boleh = $_SESSION['kunci'] >= 1;

    if ($boleh) {
        $_SESSION['kunci']--;
        $_SESSION['boleh_tonton'] = (int) ($_POST['id'] ?? 0);
    }

    header('Content-Type: application/json');
    echo json_encode(['ok' => $boleh, 'kunci' => (int) $_SESSION['kunci']]);
    exit;
}

// Kembali ke halaman detail = izin tonton sebelumnya dicabut
unset($_SESSION['boleh_tonton']);

require_once __DIR__ . '/../../repositories/detail_film_repository.php';

if (!function_exists('e')) {
    function e($teks) {
        return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$film    = ambil_film_by_id($film_id);

$judul     = !empty($film['judul']) ? $film['judul'] : 'Vision Quest';
$rating    = !empty($film['rating']) ? $film['rating'] : '8.3';
$deskripsi = !empty($film['deskripsi']) ? $film['deskripsi'] : 'Serial ini akan berfokus pada karakter White Vision (Paul Bettany) yang diperkenalkan dalam WandaVision. Plotnya mengikuti perjalanan sintozoid tersebut saat ia berusaha memulihkan ingatannya yang hilang, mengeksplorasi kembali identitas dan keberadaannya, serta mencari tujuan baru dalam hidupnya setelah kehilangan keterikatan emosionalnya di Westview.';
$poster    = !empty($film['poster']) ? $film['poster'] : 'https://i.pinimg.com/736x/9d/57/7e/9d577e728888b03995b0010d48204be3.jpg';

$episode = ambil_episode();
$serupa  = ambil_serupa();

// Lama putar GIF (ms), dihitung dari jeda antar frame. Kalau gagal dibaca, pakai 5 detik.
function durasi_gif($file) {
    $isi = file_get_contents($file);
    $total = 0;

    if ($isi !== false && preg_match_all('/\x21\xF9\x04.(..)/s', $isi, $cocok)) {
        foreach ($cocok[1] as $jeda) {
            $total += unpack('v', $jeda)[1] * 10;
        }
    }

    if ($total < 3000) {
        return 5000;
    }
    return min($total, 30000);
}

// Iklan: file GIF ada di asset/ad/advertisement.gif
$daftar_iklan = [];
foreach (glob(__DIR__ . '/../../asset/ad/advertisement.gif') ?: [] as $file) {
    $daftar_iklan[] = [
        'src'    => '/asset/ad/' . rawurlencode(basename($file)),
        'durasi' => durasi_gif($file),
    ];
}
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
            <button class="btn-primary" id="tombolWatch"><img class="lock-icon" src="/asset/photos/lock.png" alt="Lock"> Watch</button>
            <button class="btn-secondary"><i class="fa-regular fa-bookmark"></i> Add</button>
          </div>
        </div>

        <aside class="key-card">
          <div class="key-left">
            <span class="key-text" id="jumlahKunci"><?= (int) $_SESSION['kunci'] ?> Key</span>
            <button type="button" class="btn-small" id="tombolGetMore">Get more</button>
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
              <button class="open-btn perlu-kunci"><img class="lock-icon" src="/asset/photos/lock.png" alt="Lock"> OPEN</button>
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

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <!-- Pop up: kunci habis -->
  <div class="kp-overlay" id="popHabis" hidden>
    <div class="kp-card">
      <span class="kp-ikon"><i class="fa-solid fa-key"></i></span>
      <h3 id="judulHabis">Kunci telah habis</h3>
      <p>Membutuhkan kunci untuk menonton episode, tonton iklan untuk mendapatkan 1 kunci</p>
      <button type="button" class="kp-tombol" id="tombolIklan">Tonton Iklan</button>
    </div>
  </div>

  <!-- Pop up: iklan (GIF) -->
  <div class="kp-overlay" id="popIklan" hidden>
    <div class="kp-iklan">
      <div class="kp-iklan-gambar">
        <img id="gambarIklan" alt="Iklan" hidden>
        <p id="iklanKosong" class="kp-iklan-kosong" hidden>Taruh file advertisement.gif di folder asset/ad/</p>
        <span class="kp-hitung" id="hitungIklan"></span>
      </div>
      <button type="button" class="kp-ambil" id="tombolAmbil" hidden>Ambil Kuncimu</button>
    </div>
  </div>

  <!-- Pop up: proses & hasil -->
  <div class="kp-overlay" id="popHasil" hidden>
    <div class="kp-card">
      <span class="kp-ikon"><i class="fa-solid fa-key" id="ikonHasil"></i></span>
      <h3 id="judulHasil"></h3>
      <p id="teksHasil"></p>
    </div>
  </div>

  <script src="/script/script.js"></script>
  <script>
    var daftarIklan = <?= json_encode($daftar_iklan) ?>;
    var jumlahKunci = <?= (int) $_SESSION['kunci'] ?>;
    var idFilm = <?= (int) $film_id ?>;

    var popHabis = document.getElementById('popHabis');
    var popIklan = document.getElementById('popIklan');
    var popHasil = document.getElementById('popHasil');
    var sedangIklan = false;

    function tampil(pop) { pop.hidden = false; }
    function tutupSemua() {
      popHabis.hidden = true;
      popHasil.hidden = true;
    }

    function bukaPopKunci() {
      document.getElementById('judulHabis').textContent = jumlahKunci === 0 ? 'Kunci telah habis' : 'Tambah kunci';
      tampil(popHabis);
    }

    function tampilHasil(judul, teks, proses) {
      document.getElementById('judulHasil').textContent = judul;
      document.getElementById('teksHasil').textContent = teks;
      document.getElementById('ikonHasil').className = proses ? 'fa-solid fa-spinner fa-spin' : 'fa-solid fa-key';
      tampil(popHasil);
    }

    document.getElementById('tombolGetMore').addEventListener('click', function () {
      bukaPopKunci();
    });

    // Tombol Watch dan OPEN: kalau ada kunci, pakai 1 kunci lalu buka halaman tontonan
    function mulaiTonton() {
      if (jumlahKunci === 0) {
        bukaPopKunci();
        return;
      }

      var data = new FormData();
      data.append('aksi', 'tonton');
      data.append('id', idFilm);

      fetch(window.location.href, { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (respon) {
          if (respon.ok) {
            window.location.href = '/pages/movies/watch_film.php?id=' + idFilm;
          } else {
            jumlahKunci = respon.kunci;
            bukaPopKunci();
          }
        });
    }

    document.getElementById('tombolWatch').addEventListener('click', mulaiTonton);

    var tombolOpen = document.querySelectorAll('.perlu-kunci');
    for (var i = 0; i < tombolOpen.length; i++) {
      tombolOpen[i].addEventListener('click', mulaiTonton);
    }

    document.getElementById('tombolIklan').addEventListener('click', function () {
      var iklan = daftarIklan.length ? daftarIklan[Math.floor(Math.random() * daftarIklan.length)] : null;
      var durasi = iklan ? iklan.durasi : 5000;
      var gambar = document.getElementById('gambarIklan');
      var kosong = document.getElementById('iklanKosong');
      var hitung = document.getElementById('hitungIklan');
      var sisa = Math.ceil(durasi / 1000);

      popHabis.hidden = true;
      sedangIklan = true;
      document.getElementById('tombolAmbil').hidden = true;

      if (iklan) {
        gambar.src = iklan.src + '?t=' + Date.now(); // supaya GIF mulai dari awal
        gambar.hidden = false;
        kosong.hidden = true;
      } else {
        gambar.hidden = true;
        kosong.hidden = false;
      }

      hitung.textContent = 'Iklan selesai dalam ' + sisa + ' dtk';
      tampil(popIklan);

      var timer = setInterval(function () {
        sisa--;
        hitung.textContent = 'Iklan selesai dalam ' + sisa + ' dtk';

        if (sisa <= 0) {
          clearInterval(timer);
          hitung.textContent = 'Iklan selesai';
          document.getElementById('tombolAmbil').hidden = false; // tombol baru muncul setelah iklan selesai
        }
      }, 1000);
    });

    document.getElementById('tombolAmbil').addEventListener('click', selesaiIklan);

    function selesaiIklan() {
      popIklan.hidden = true;
      tampilHasil('Memproses...', 'Mohon tunggu sebentar', true);

      var data = new FormData();
      data.append('aksi', 'iklan');

      var tunggu = new Promise(function (selesai) { setTimeout(selesai, 1500); }); // jeda 1,5 detik

      Promise.all([fetch(window.location.href, { method: 'POST', body: data }).then(function (r) { return r.json(); }), tunggu])
        .then(function (hasil) {
          var respon = hasil[0];
          jumlahKunci = respon.kunci;
          document.getElementById('jumlahKunci').textContent = jumlahKunci + ' Key';
          sedangIklan = false;

          tampilHasil('Selamat', 'Anda sukses mendapatkan satu kunci dari menonton iklan', false);
        })
        .catch(function () {
          sedangIklan = false;
          tampilHasil('Gagal', 'Kunci belum berhasil didapat, coba lagi.', false);
        });
    }

    // Klik area gelap atau tekan Esc untuk menutup (kecuali saat iklan / proses)
    [popHabis, popHasil].forEach(function (pop) {
      pop.addEventListener('click', function (ev) {
        if (ev.target === pop && !sedangIklan && document.getElementById('judulHasil').textContent !== 'Memproses...') {
          pop.hidden = true;
        }
      });
    });
    document.addEventListener('keydown', function (ev) {
      if (ev.key === 'Escape' && !sedangIklan && document.getElementById('judulHasil').textContent !== 'Memproses...') {
        tutupSemua();
      }
    });
  </script>
</body>
</html>