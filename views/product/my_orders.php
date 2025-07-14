<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'config/database.php';

if (!isset($_SESSION['user']['id'])) {
  header("Location: index.php?url=login");
  exit;
}

$title = "Pesanan Saya - ThriftHub";
ob_start();

$user_id = $_SESSION['user']['id'];
$sql = "SELECT p.id AS pesanan_id, pi.nama AS produk, p.tanggal, pi.jumlah, (pi.harga*pi.jumlah) AS total,
        p.metode, p.status_pembayaran, p.status_pengiriman, p.lokasi_pengiriman, p.diterima
        FROM pesanan p 
        JOIN pesanan_item pi ON p.id = pi.pesanan_id
        WHERE p.user_id = ? AND p.diterima = 0
        ORDER BY p.tanggal DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="py-5">
  <div class="container">
    <h2 class="fw-bold text-center mb-4 text-primary">
      <i class="bi bi-truck me-2"></i>Pesanan Saya (Aktif)
    </h2>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Produk</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Total</th>
              <th>Status Pembayaran</th>
              <th>Status Pengiriman</th>
              <th>Tracking</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; while($r = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['produk']) ?></td>
                <td><?= date('d M Y - H:i', strtotime($r['tanggal'])) ?></td>
                <td><?= $r['jumlah'] ?></td>
                <td class="text-danger fw-bold">Rp<?= number_format($r['total']) ?></td>
                <td><span class="badge bg-<?= $r['status_pembayaran'] === 'Pembayaran Diterima' ? 'success' : 'warning' ?>">
                  <?= $r['status_pembayaran'] ?></span></td>
                <td><span class="badge bg-<?= $r['status_pengiriman'] === 'Dikirim' ? 'info' : 'secondary' ?>">
                  <?= $r['status_pengiriman'] ?></span></td>
                <td>
                  <a href="index.php?url=tracking&pesanan_id=<?= $r['pesanan_id'] ?>" class="btn btn-sm btn-outline-info rounded-pill">
                    <i class="bi bi-truck"></i> Lacak
                  </a>
                </td>
                <td>
                  <form method="POST" action="index.php?url=konfirmasi_diterima.php">
                    <input type="hidden" name="pesanan_id" value="<?= $r['pesanan_id'] ?>">
                    <button class="btn btn-sm btn-outline-success rounded-pill">Konfirmasi</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="text-center py-5">
        <i class="bi bi-inbox display-4 text-muted"></i>
        <h5 class="mt-3 text-secondary">Belum ada pesanan aktif.</h5>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/index.php';
?>
