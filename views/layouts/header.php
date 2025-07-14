<?php
$role = $_SESSION['user']['role'] ?? null;
$cart_count = 0;
if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $cart_count += $item['quantity'];
  }
}
?>
<nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php" style="color: #85005A; font-size: 1.8rem;">
      <i class="bi bi-shop-window me-1"></i> Thrift<span style="color: #BF2EF0;">Hub</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <!-- Navigasi Kiri -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php?url=home"><i class="bi bi-house-door-fill me-1"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?url=tentang"><i class="bi bi-info-circle-fill me-1"></i> Tentang</a></li>
        <?php if ($role !== 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="index.php?url=category"><i class="bi bi-list-ul me-1"></i> Kategori</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?url=kontak"><i class="bi bi-envelope-fill me-1"></i> Kontak</a></li>
        <?php endif; ?>
      </ul>

      <!-- Search Bar -->
      <?php if ($role !== 'admin'): ?>
        <form class="d-flex me-lg-3 mb-2 mb-lg-0" action="index.php" method="GET">
          <input type="hidden" name="url" value="search">
          <input class="form-control me-2 rounded-pill px-3" type="search" name="query" placeholder="Cari produk...">
          <button class="btn btn-outline-secondary rounded-pill" type="submit"><i class="bi bi-search"></i></button>
        </form>
      <?php endif; ?>

      <!-- Navigasi Kanan -->
      <ul class="navbar-nav align-items-center">
        <?php if ($role !== 'admin'): ?>
          <!-- Ikon Keranjang -->
          <li class="nav-item me-3">
            <a href="index.php?url=cart" class="position-relative text-dark">
              <i class="bi bi-cart-fill fs-4"></i>
              <?php if ($cart_count > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $cart_count ?>
                </span>
              <?php endif; ?>
            </a>
          </li>
        <?php endif; ?>

        <!-- Akun / Login -->
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <?php if ($role === 'admin'): ?>
                <i class="bi bi-shield-lock-fill me-1"></i>
              <?php else: ?>
                <i class="bi bi-person-circle me-1"></i>
              <?php endif; ?>
              <?= htmlspecialchars($_SESSION['user']['name']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if ($role === 'admin'): ?>
                <li><a class="dropdown-item" href="index.php?url=admin_dashboard"><i class="bi bi-speedometer2 me-1"></i> Dashboard Admin</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="index.php?url=dashboard"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-person me-1"></i> Akun
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="index.php?url=login">Login</a></li>
              <li><a class="dropdown-item" href="index.php?url=register">Register</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
