<header class="topbar" id="navbar">
  <div class="logo-wrapper">
    <a href="/index.php" class="logo">
      <img src="/asset/photos/planarcadia.png" alt="Logo" class="logo-img" onerror="this.style.display='none'">
      Planarcadia
    </a>
    <!-- Tombol Tanda Panah Ke Bawah -->
    <button class="dropdown-btn" id="dropdownToggle">
      <i class="fa-solid fa-chevron-down"></i>
    </button>
  </div>

  <div class="header-dropdown" id="headerDropdown">
    <a href="/index.php" class="dropdown-item active"><i class="fa-solid fa-film"></i>Movies</a>
    <a href="/pages/schedule/broadcast_schedule.php" class="dropdown-item"><i class="fa-solid fa-calendar-days"></i>Broadcast Schedule</a>
    <a href="/pages/movies/list_film.php" class="dropdown-item"><i class="fa-solid fa-masks-theater"></i> List of Films</a>
    <a href="/pages/movies/genre.php" class="dropdown-item"><i class="fa-solid fa-masks-theater"></i> Genre</a>
    <a href="/pages/admin/dashboard.php" class="dropdown-item"><i class="fa-solid fa-user-gear"></i> Admin</a>
  </div>

  <div class="topbar-right">
    <a href="/pages/auth/login.php" class="topbar-btn login">Login</a>
    <a href="/pages/auth/register.php" class="topbar-btn register">Register</a>
  </div>
</header>