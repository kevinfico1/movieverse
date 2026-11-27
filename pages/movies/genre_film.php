<?php
session_start();

require_once __DIR__ . '/../../repositories/genre.php';
require_once __DIR__ . '/../../config/database.php';

try {
    $genre_database = $pdo->query('SELECT name FROM categories ORDER BY name')->fetchAll(PDO::FETCH_COLUMN);
    $genre_terdaftar = array_map('strtolower', array_column($genre, 1));
    foreach ($genre_database as $nama_genre) {
        if (!in_array(strtolower($nama_genre), $genre_terdaftar, true)) {
            $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $nama_genre), '-'));
            $genre[] = [$slug, $nama_genre, 'fa-solid fa-film', 'linear-gradient(120deg,#38305f,#7566b5,#b2a8e8)'];
            $genre_terdaftar[] = strtolower($nama_genre);
        }
    }
} catch (PDOException $error) {

}

if (!isset($_SESSION['kunci'])) {
    $_SESSION['kunci'] = 0;
}

foreach (['echo_siap', 'aha_siap', 'tontonan'] as $nama_sesi) {
    if (!isset($_SESSION[$nama_sesi])) {
        $_SESSION[$nama_sesi] = 0;
    }
}

$pet_aktif = "";

if (isset($_POST['pet'])) {
    $pet_aktif = $_POST['pet'];
}

if (isset($_POST['klaim']) && isset($_POST['pet_klaim'])) {
    $pet_aktif = $_POST['pet_klaim'];
}

if ($pet_aktif != "echo" && $pet_aktif != "aha") {
    $pet_aktif = "";
}

$hasil = "";

if ($pet_aktif != "" && isset($_POST['klaim'])) {
    $nama_siap = $pet_aktif . '_siap';

    if ($_SESSION[$nama_siap] > 0) {
        $_SESSION[$nama_siap]--;
        $_SESSION['kunci']++;
        $hasil = "You got 1 key!";
    }
}

$popup = "";
$siap = 0;
$petunjuk = "";

if ($pet_aktif != "") {
    $siap = $_SESSION[$pet_aktif . '_siap'];

    if ($siap > 0) {
        $popup = "reward";
    } else {
        $popup = "selesai";
    }

    if ($pet_aktif == "echo") {
        $petunjuk = "Finish watching 5 episodes to get a bonus key (" . ($_SESSION['tontonan'] % 5) . "/5)";
    } else {
        $petunjuk = "Watch an advertisement for a 20% chance to get a bonus key";
    }
}

$nama_pet   = "Echo";
$gambar_pet = "Echo.png";

if ($pet_aktif == "aha") {
    $nama_pet   = "Aha";
    $gambar_pet = "Aha.png";
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
  <link rel="stylesheet" href="../../style/base.css">
  <link rel="stylesheet" href="../../style/auth/topbar.css">
  <link rel="stylesheet" href="../../style/genre_film/genre.css">
  <link rel="stylesheet" href="../../style/auth/footer.css">
</head>
<body class="genre-page-body">

  <?php require_once __DIR__ . '/../../components/landing/topbar.php'; ?>

  <div class="judul-genre">
    <h1>Genre</h1>
  </div>

  <div class="isi">

    <div class="panel-ungu"></div>

    <div class="area-genre">
      <div class="kolom-genre">
        <?php foreach ($genre as $g) { ?>
          <div class="kartu-genre"
               style="background-image: url('../../asset/genre/<?php echo $g[0]; ?>.jpg'), <?php echo $g[3]; ?>;">
            <span class="ikon-genre"><i class="<?php echo $g[2]; ?>"></i></span>
            <span class="nama-genre"><?php echo $g[1]; ?></span>
          </div>
        <?php } ?>
      </div>
    </div>

    <div class="kolom-pet">

      <form method="POST">
        <input type="hidden" name="pet" value="echo">
        <button type="submit" class="kartu-pet echo">
          <img src="../../asset/pets/Echo.png" alt="Echo" class="gambar-pet">
          <div class="info-pet">
            <h2>Echo</h2>
            <span>Ability: Resonance</span>
            <p class="deskripsi">Every 5 episodes that are finished watching, Echo doubles the key bonus so that users get 1 additional key.</p>
          </div>
        </button>
      </form>

      <form method="POST" id="formAha">
        <input type="hidden" name="pet" value="aha">
        <button type="submit" class="kartu-pet aha">
          <img src="../../asset/pets/Aha.png" alt="Aha" class="gambar-pet">
          <div class="info-pet">
            <h2>Aha!!</h2>
            <span>Ability: Certified Banger</span>
            <p class="deskripsi">Aha will provides a 20% chance to obtain 1 bonus key each time a user watch an advertisement.</p>
          </div>
        </button>
      </form>

    </div>
  </div>

  <?php if ($popup != "") { ?>
    <div class="reward-overlay">
      <div class="reward-box">
        <h2 class="reward-judul">REWARD SYSTEM</h2>

        <?php if ($hasil != "") { ?>
          <p class="reward-hasil"><?php echo $hasil; ?> (Total: <?php echo (int) $_SESSION['kunci']; ?> key)</p>
        <?php } ?>

        <?php if ($popup == "reward") { ?>

          <p class="reward-hasil">Available rewards: <?php echo $siap; ?></p>

          <div class="reward-daftar">
            <?php for ($i = 1; $i <= min($siap, 3); $i++) { ?>

              <form method="POST" class="reward-kartu <?php echo $pet_aktif; ?>">
                <div class="reward-atas">
                  <img src="../../asset/pets/<?php echo $gambar_pet; ?>" alt="<?php echo $nama_pet; ?>" class="reward-gambar">
                  <span class="reward-nama"><?php echo $nama_pet; ?> Reward</span>
                </div>
                <div class="reward-bawah">
                  <input type="hidden" name="pet_klaim" value="<?php echo $pet_aktif; ?>">
                  <button type="submit" name="klaim" value="<?php echo $i; ?>" class="reward-tombol">Claim</button>
                </div>
              </form>

            <?php } ?>
          </div>

        <?php } else { ?>

          <div class="reward-selesai">
            <p>No reward available</p>
            <p><?php echo $petunjuk; ?></p>
            <a href="genre_film.php" class="reward-kembali">Go Back</a>
          </div>

        <?php } ?>

      </div>
    </div>
  <?php } ?>

  <?php require_once __DIR__ . '/../../components/landing/footer.php'; ?>

  <script src="../../script/script.js"></script>
</body>
</html>