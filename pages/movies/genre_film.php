<?php
// Mulai session supaya jumlah kunci bisa disimpan
session_start();

// Ambil data genre dari file lain
require_once 'genre_repositories.php';

// Kalau belum punya kunci, mulai dari 0
if (!isset($_SESSION['kunci'])) {
    $_SESSION['kunci'] = 0;
}

// Pesan hasil klaim (awalnya kosong)
$pesan = "";

// Kalau ada pet yang ditekan (form dikirim)
if (isset($_POST['pet'])) {

    $pet = $_POST['pet'];

    // ECHO: selalu dapat 1 kunci
    if ($pet == "echo") {
        $_SESSION['kunci'] = $_SESSION['kunci'] + 1;
        $pesan = "Echo memberi kamu 1 kunci bonus!";
    }

    // AHA: peluang 20% dapat 1 kunci
    if ($pet == "aha") {
        $angka = rand(1, 100); // ambil angka acak 1 sampai 100

        if ($angka <= 20) {
            $_SESSION['kunci'] = $_SESSION['kunci'] + 1;
            $pesan = "Aha!! memberi kamu 1 kunci bonus!";
        } else {
            $pesan = "Aha!! belum beruntung, coba lagi ya.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Genre - Planarcadia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Mono&family=Syne:wght@600;700;800&display=swap">
  <link rel="stylesheet" href="style/base.css">
  <link rel="stylesheet" href="style/genre_film/genre.css">
  <link rel="stylesheet" href="style/footer.css">
</head>
<body class="genre-page-body">

  <!-- Bar atas -->
  <div class="bar-atas">
    <a href="index.php" class="tombol-home"><i class="fa-solid fa-house"></i> Home</a>
  </div>

  <!-- Judul -->
  <div class="judul-genre">
    <h1>Genre</h1>
  </div>

  <!-- Pesan hasil klaim (hanya muncul kalau sudah klaim) -->
  <?php if ($pesan != "") { ?>
    <div class="pesan-klaim" id="pesanKlaim">
      <i class="fa-solid fa-key"></i>
      <?php echo $pesan; ?> (Total kunci: <?php echo $_SESSION['kunci']; ?>)
    </div>
  <?php } ?>

  <!-- Isi halaman -->
  <div class="isi">

    <!-- Panel ungu di belakang (bentuk panah) -->
    <div class="panel-ungu"></div>

    <!-- Kiri: 6 kartu genre (datanya dari genre_repositories.php) -->
    <div class="kolom-genre">
      <?php foreach ($genre as $g) { ?>
        <a href="index.php?genre=<?php echo $g[0]; ?>"
           class="kartu-genre"
           style="background-image: url('asset/genre/<?php echo $g[0]; ?>.jpg'), <?php echo $g[3]; ?>;">
          <span class="ikon-genre"><i class="<?php echo $g[2]; ?>"></i></span>
          <span class="nama-genre"><?php echo $g[1]; ?></span>
        </a>
      <?php } ?>
    </div>

    <!-- Kanan: 2 pet (bisa ditekan untuk klaim kunci) -->
    <div class="kolom-pet">

      <!-- Echo -->
      <form method="POST">
        <input type="hidden" name="pet" value="echo">
        <button type="submit" class="kartu-pet echo">
          <img src="asset/genre/echo.svg" alt="Echo" class="gambar-pet">
          <div class="info-pet">
            <h2>Echo</h2>
            <span>Ability: Resonance</span>
            <p class="deskripsi">Every 5 episodes that are finished watching, Echo doubles the key bonus so that users get 1 additional key.</p>
          </div>
        </button>
      </form>

      <!-- Aha!! -->
      <form method="POST" id="formAha">
        <input type="hidden" name="pet" value="aha">
        <button type="submit" class="kartu-pet aha">
          <img src="asset/genre/aha.svg" alt="Aha" class="gambar-pet">
          <div class="info-pet">
            <h2>Aha!!</h2>
            <span>Ability: Certified Banger</span>
            <p class="deskripsi">Aha will provides a 20% chance to obtain 1 bonus key each time a user watch an advertisement.</p>
          </div>
        </button>
      </form>

    </div>
  </div>

  <?php include 'components/landing/footer.php'; ?>

</body>
</html>