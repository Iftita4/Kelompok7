<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
    header("Location: index.php?url=login");
    exit;
}

$title = "Dashboard Anda - ThriftHub";
ob_start();
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Halo, <?= htmlspecialchars($_SESSION['user']['name']); ?> 👋</h2>
    <p class="text-muted">Selamat datang di ThriftHub! Lihat dan kelola aktivitas belanja & jualanmu di sini.</p>
  </div>

  <div class="row g-4">
    <!-- Pesanan Saya -->
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 h-100 text-center">
        <div class="card-body">
          <i class="bi bi-bag-check fs-1 text-primary mb-3"></i>
          <h5 class="card-title">Pesanan Saya</h5>
          <p class="text-muted">Lihat status pesanan yang sedang diproses atau selesai.</p>
          <a href="index.php?url=my_orders" class="btn btn-outline-primary rounded-pill">Lihat Pesanan</a>
        </div>
      </div>
    </div>

    <!-- Riwayat Pembelian -->
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 h-100 text-center">
        <div class="card-body">
          <i class="bi bi-receipt fs-1 text-success mb-3"></i>
          <h5 class="card-title">Riwayat Pembelian</h5>
          <p class="text-muted">Pantau riwayat transaksi pembelian kamu.</p>
          <a href="index.php?url=my_transactions" class="btn btn-outline-success rounded-pill">Cek Riwayat</a>
        </div>
      </div>
    </div>

    <!-- Mulai Berjualan / Dashboard Toko -->
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm border-0 h-100 text-center">
        <div class="card-body">
          <i class="bi bi-shop-window fs-1 text-warning mb-3"></i>
          <h5 class="card-title">Toko Saya</h5>
          <p class="text-muted">
            <?php if ($_SESSION['user']['is_seller'] == 0): ?>
              Jadilah penjual dan tampilkan produkmu di ThriftHub!
            <?php else: ?>
              Kelola toko & pantau produk yang kamu jual.
            <?php endif; ?>
          </p>
          <?php if ($_SESSION['user']['is_seller'] == 0): ?>
            <form action="index.php?url=penjual" method="post">
              <button type="submit" class="btn btn-outline-warning rounded-pill">
                <i class="bi bi-plus-circle me-1"></i> Mulai Berjualan
              </button>
            </form>
          <?php else: ?>
            <a href="index.php?url=admin_store_dashboard" class="btn btn-outline-warning rounded-pill">
              <i class="bi bi-speedometer2 me-1"></i> Dashboard Toko
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Tombol ke halaman utama -->
  <div class="text-center mt-5">
    <a href="index.php?url=home" class="btn btn-secondary rounded-pill px-4">
      <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Beranda
    </a>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'layouts/index.php';
?>
