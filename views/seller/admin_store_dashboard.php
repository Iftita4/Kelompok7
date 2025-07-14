<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
    echo "Akses ditolak.";
    exit;
}

$title = "Dashboard Toko";
ob_start();

$seller_id = $_SESSION['user']['id'];

// Ambil nama toko (jika tersedia)
$namaToko = $_SESSION['user']['nama_toko'] ?? 'Toko Anda';

// Hitung total produk toko ini
$totalProduk = $conn->query("SELECT COUNT(*) as total FROM produk WHERE user_id = $seller_id")->fetch_assoc()['total'] ?? 0;

// Hitung total produk terjual
$sqlTerjual = "
  SELECT SUM(pi.jumlah) as total
  FROM pesanan_item pi
  JOIN pesanan p ON pi.pesanan_id = p.id
  JOIN produk pr ON pi.produk_id = pr.id
  WHERE p.status_pembayaran = 'Pembayaran Diterima'
  AND pr.user_id = $seller_id
";
$resTerjual = $conn->query($sqlTerjual);
$totalTerjual = $resTerjual ? ($resTerjual->fetch_assoc()['total'] ?? 0) : 0;

// Hitung total pendapatan
$sqlPendapatan = "
  SELECT SUM(pi.harga * pi.jumlah) as total
  FROM pesanan_item pi
  JOIN pesanan p ON pi.pesanan_id = p.id
  JOIN produk pr ON pi.produk_id = pr.id
  WHERE p.status_pembayaran = 'Pembayaran Diterima'
  AND pr.user_id = $seller_id
";
$resPendapatan = $conn->query($sqlPendapatan);
$totalPendapatan = $resPendapatan ? ($resPendapatan->fetch_assoc()['total'] ?? 0) : 0;
?>

<div class="container py-5">
  <!-- Sapaan -->
  <div class="text-center mb-4">
    <h4 class="fw-bold text-secondary">Halo, <span style="color:#85005A"><?= htmlspecialchars($namaToko) ?></span> 👋</h4>
    <p class="text-muted mb-0">Selamat datang di halaman Dashboard toko kamu.</p>
    <p class="text-muted">Pantau penjualan dan kinerja tokomu di sini.</p>
  </div>

  <!-- Kartu Statistik -->
  <div class="row text-center g-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <i class="bi bi-box-seam fs-1 text-primary"></i>
          <h5 class="mt-2">Total Produk</h5>
          <p class="fs-4 fw-bold text-primary"><?= $totalProduk ?></p>
        </div>
      </div>
    </div>
    <!-- Total Terjual -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center">
        <div class="card-body">
          <i class="bi bi-bag-check-fill text-success mb-3" style="font-size: 2.5rem;"></i>
          <h5>Total Terjual</h5>
          <p class="fs-4 fw-bold text-success"><?= $totalTerjual ?></p>
        </div>
      </div>
    </div>
    <!-- Total Pendapatan -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center">
        <div class="card-body">
          <i class="bi bi-cash-coin text-warning mb-3" style="font-size: 2.5rem;"></i>
          <h5>Total Pendapatan</h5>
          <p class="fs-4 fw-bold text-warning">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>
