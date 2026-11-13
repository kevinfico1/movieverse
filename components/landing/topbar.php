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
    <a href="/index.php" class="dropdown-item active"><i class="fa-solid fa-house"></i>Home</a>
    <a href="/pages/schedule/broadcast_schedule.php" class="dropdown-item"><i class="fa-solid fa-chalkboard-user"></i>Broadcast Schedule</a>
    <a href="/pages/movies/list_film.php" class="dropdown-item"><i class="fa-solid fa-film"></i>List of Films</a>
    <a href="/pages/movies/genre.php" class="dropdown-item"><svg class="reel-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 1a11 11 0 1 0 0 22a11 11 0 1 0 0-22zM12 10a2 2 0 1 0 0 4a2 2 0 1 0 0-4zM12 3.9000000000000004a2.3 2.3 0 1 0 0 4.6a2.3 2.3 0 1 0 0-4.6zM12 15.5a2.3 2.3 0 1 0 0 4.6a2.3 2.3 0 1 0 0-4.6zM6.2 9.7a2.3 2.3 0 1 0 0 4.6a2.3 2.3 0 1 0 0-4.6zM17.8 9.7a2.3 2.3 0 1 0 0 4.6a2.3 2.3 0 1 0 0-4.6z"/></svg>Genre</a>
    <a href="/pages/admin/dashboard.php" class="dropdown-item"><i class="fa-solid fa-clipboard-list"></i>Admin</a>
  </div>

  <div class="topbar-right">
    <a href="/pages/auth/login.php" class="topbar-btn login">Login</a>
    <a href="/pages/auth/register.php" class="topbar-btn register">Register</a>
  </div>
</header>