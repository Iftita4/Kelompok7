<?php
$title = "Tracking Pengiriman - ThriftHub";
ob_start();

if (session_status() === PHP_SESSION_NONE) session_start();
include 'config/database.php';

// Cek login
if (!isset($_SESSION['user']['id'])) {
  header("Location: index.php?url=login");
  exit;
}

$pesanan_id = isset($_GET['pesanan_id']) ? intval($_GET['pesanan_id']) : null;
$user_id = $_SESSION['user']['id'];

$pesanan = null;
$current_step = 1;

// Ambil data pesanan hanya jika ID valid
if ($pesanan_id) {
  $stmt = $conn->prepare("SELECT p.*, u.name 
                          FROM pesanan p
                          JOIN users u ON u.id = p.user_id
                          WHERE p.id = ? AND p.user_id = ?");
  $stmt->bind_param("ii", $pesanan_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $pesanan = $result->fetch_assoc();

  $status_steps = [
    'Diproses' => 1,
    'Dikirim' => 2,
    'Dalam Perjalanan' => 3,
    'Diterima' => 4
  ];
  $current_step = $status_steps[$pesanan['status_pengiriman']] ?? 1;
}
?>

<div class="container py-5">
  <?php if (!$pesanan_id): ?>
    <div class="alert alert-warning text-center">ID Pesanan tidak valid.</div>

  <?php elseif (!$pesanan): ?>
    <div class="alert alert-danger text-center">Pesanan tidak ditemukan.</div>

  <?php else: ?>
    <h2 class="fw-bold text-center mb-5" style="color:#85005A;">
      <i class="bi bi-truck me-2"></i> Lacak Pengiriman
    </h2>

    <!-- Step Tracker -->
    <div class="d-flex justify-content-between align-items-center mb-5 px-md-5 position-relative">
      <?php
        $step_titles = ['Diproses', 'Dikirim', 'Dalam Perjalanan', 'Diterima'];
        foreach ($step_titles as $i => $title):
          $step = $i + 1;
          $active = $step <= $current_step ? 'active' : '';
      ?>
        <div class="text-center flex-fill position-relative">
          <div class="circle-step <?= $active ?>"><?= $step ?></div>
          <div class="mt-2 fw-semibold small"><?= $title ?></div>
          <?php if ($step < count($step_titles)): ?>
            <div class="line-step <?= $step < $current_step ? 'active' : '' ?>"></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Detail Info -->
    <div class="card shadow-sm p-4 border-0">
      <h5 class="fw-semibold">ID Pesanan: <span class="text-primary">#<?= $pesanan['id'] ?></span></h5>
      <p><strong>Nama Penerima:</strong> <?= htmlspecialchars($pesanan['nama']) ?></p>
      <p><strong>Alamat:</strong> <?= htmlspecialchars($pesanan['alamat']) ?></p>
      <p><strong>Tanggal Pemesanan:</strong> <?= date('d M Y - H:i', strtotime($pesanan['tanggal'])) ?></p>
      <p><strong>Lokasi Saat Ini:</strong> <?= htmlspecialchars($pesanan['lokasi_pengiriman'] ?? 'Belum tersedia') ?></p>
      <p><strong>Estimasi Tiba:</strong> <?= $pesanan['estimasi_tiba'] ?? '<span class="text-muted">Belum tersedia</span>' ?></p>

      <div class="mt-3">
        <span class="fw-semibold">Status Sekarang:</span>
        <span class="badge bg-<?= $pesanan['diterima'] ? 'success' : ($current_step >= 3 ? 'info' : 'warning'); ?> px-3 py-2 rounded-pill">
          <?= $pesanan['status_pengiriman']; ?>
        </span>
      </div>

      <?php if ($pesanan['diterima']): ?>
        <div class="alert alert-success mt-4">
          <i class="bi bi-check-circle-fill"></i> Pesanan telah diterima oleh pelanggan.
        </div>
      <?php endif; ?>

      <a href="index.php?url=my_orders" class="btn btn-outline-secondary mt-4 rounded-pill">
        <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Riwayat
      </a>
    </div>
  <?php endif; ?>
</div>

<style>
  .circle-step {
    width: 40px;
    height: 40px;
    background: #ccc;
    border-radius: 50%;
    line-height: 40px;
    color: white;
    font-weight: bold;
    margin: auto;
    position: relative;
    z-index: 2;
  }

  .circle-step.active {
    background: #85005A;
  }

  .line-step {
    position: absolute;
    top: 20px;
    left: 50%;
    width: 100%;
    height: 4px;
    background: #ccc;
    z-index: 1;
  }

  .line-step.active {
    background: #85005A;
  }

  @media (max-width: 768px) {
    .circle-step {
      width: 30px;
      height: 30px;
      font-size: 14px;
      line-height: 30px;
    }
  }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/index.php';
