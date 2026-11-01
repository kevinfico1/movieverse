<?php
  require_once __DIR__ . '/config/database.php';

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
  <link rel="stylesheet" href="base.css">
  <link rel="stylesheet" href="style/topbar.css">
  <link rel="stylesheet" href="style/hero.css">
  <link rel="stylesheet" href="style/home.css">
  <link rel="stylesheet" href="style/footer.css">
</head>
<body>

  <?php include 'components/landing/header.php'; ?>

  <!-- Hero Banner "THE ODYSSEY" (Lebar Penuh Sampai Ujung) -->
  <section class="hero-banner">
    <div class="hero-content">
      <span class="studio-tag">A FILM BY CHRISTOPHER NOLAN</span>
      <h1 class="hero-title">THE ODYSSEY</h1>
      
      <div class="hero-meta">
        <span class="rating"><i class="fa-solid fa-star"></i> 4.9</span>
        <span class="divider">|</span>
        <span>2026</span>
        <span class="divider">|</span>
        <span>2h 45m</span>
        <span class="divider">|</span>
        <span>Aksi, Petualangan</span>
      </div>

      <p class="hero-desc">
        Perjalanan epik melintasi kegelapan dan pertempuran besar dalam mahakarya terbaru arahan Christopher Nolan.
      </p>

      <a href="detail_film.php?id=1" class="btn-watch">
        <i class="fa-solid fa-play"></i> Watch
      </a>
    </div>
  </section>

  <!-- Katalog Film & Series -->
  <main class="katalog-container">
    <section class="katalog-section">
      <h2 class="section-title">Trending Now</h2>
      <div class="section-line"></div>
      
      <div class="movie-grid">
        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/c2/77/fb/c277fb23118b1431d2bb75e13ffceed9.jpg" alt="Superman" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>lanterns</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/1200x/00/2c/15/002c158dd2b74d09ae2f7e6d2fb9cf5b.jpg" alt="Spiderman" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>The Mentalist</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/11/2f/48/112f48d07127371768708c60ed4995b4.jpg" alt="Loki" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Daredevil</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg" alt="Avengers" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Avengers Doomsday</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/bd/68/e8/bd68e8f4c81daac424e4f31b1dc392f3.jpg" alt="Deadpool" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Dexter</h3>
            <span>2026</span>
          </div>
        </div>
      </div>
    </section>

    <section class="katalog-section">
      <h2 class="section-title">Series</h2>
      <div class="section-line"></div>

      <div class="movie-grid">
        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/9d/57/7e/9d577e728888b03995b0010d48204be3.jpg" alt="The Boys" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Vision Quest</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/1200x/b5/da/81/b5da816660ec3f7c2394e26b2671c9f3.jpg" alt="Peacemaker" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Breaking Bad</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/c2/77/fb/c277fb23118b1431d2bb75e13ffceed9.jpg" alt="Lanterns" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Lanterns</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/18/20/f9/1820f96840b28134f8b78f5475b586e1.jpg" alt="Daredevil" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Pider Noir</h3>
            <span>2026</span>
          </div>
        </div>

        <div class="movie-card">
          <div class="poster-box">
            <i class="fa-regular fa-image"></i>
            <img src="https://i.pinimg.com/736x/11/2f/48/112f48d07127371768708c60ed4995b4.jpg" alt="Spider Noir" onerror="this.style.display='none'">
          </div>
          <div class="movie-info">
            <h3>Daredevil</h3>
            <span>2026</span>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include 'components/landing/footer.php'; ?>

  <script src="script/script.js"></script>
</body>
</html>