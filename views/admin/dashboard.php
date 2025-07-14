<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php?url=login");
    exit;
}

$title = "Dashboard Admin - ThriftHub";
include __DIR__ . '/../../middlewares/admin_only.php';
include __DIR__ . '/../../config/database.php';


ob_start();

// Statistik
$totalProduk = $conn->query("SELECT COUNT(*) as total FROM produk")->fetch_assoc()['total'];
$totalUser = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$totalToko = $conn->query("SELECT COUNT(*) as total FROM users WHERE is_seller = 1")->fetch_assoc()['total'];
?>

<div class="container py-5">
  <h2 class="fw-bold mb-5 text-center text-dark">
    <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
  </h2>

  <!-- Statistik -->
  <div class="row g-4 mb-5">

    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center">
        <div class="card-body">
          <i class="bi bi-box-seam-fill text-primary mb-3" style="font-size: 2.5rem;"></i>
          <h5>Total Produk</h5>
          <p class="fs-3 fw-bold text-primary"><?= $totalProduk ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center">
        <div class="card-body">
          <i class="bi bi-people-fill text-success mb-3" style="font-size: 2.5rem;"></i>
          <h5>Total Pengguna</h5>
          <p class="fs-3 fw-bold text-success"><?= $totalUser ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center">
        <div class="card-body">
          <i class="bi bi-shop text-warning mb-3" style="font-size: 2.5rem;"></i>
          <h5>Total Toko Terdaftar</h5>
          <p class="fs-3 fw-bold text-warning"><?= $totalToko ?></p>
        </div>
      </div>
    </div>

  </div>

  <!-- Navigasi Manajemen -->
  <div class="row g-4">
    <!-- Manajemen Pengguna -->
    <div class="col-md-3 col-sm-6">
      <a href="index.php?url=admin_user" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <i class="bi bi-person-gear text-secondary mb-2" style="font-size: 2rem;"></i>
            <h6>Manajemen Pengguna</h6>
          </div>
        </div>
      </a>
    </div>

    <!-- Semua Pesanan -->
    <div class="col-md-3 col-sm-6">
      <a href="index.php?url=admin_transaksi" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <i class="bi bi-cart-check text-danger mb-2" style="font-size: 2rem;"></i>
            <h6>Semua Pesanan</h6>
          </div>
        </div>
      </a>
    </div>

    <!-- Produk Marketplace -->
    <div class="col-md-3 col-sm-6">
      <a href="index.php?url=admin_produk" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <i class="bi bi-box2-fill text-info mb-2" style="font-size: 2rem;"></i>
            <h6>Produk di Marketplace</h6>
          </div>
        </div>
      </a>
    </div>

  <!-- Manajemen Toko -->
  <div class="col-md-3 col-sm-6">
    <a href="index.php?url=admin_daftar_toko" class="text-decoration-none">
      <div class="card h-100 shadow-sm border-0 text-center">
        <div class="card-body">
          <i class="bi bi-shop-window text-primary mb-2" style="font-size: 2rem;"></i>
          <h6>Manajemen Toko</h6>
        </div>
      </div>
    </a>
  </div>

  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_layout.php';
?>
