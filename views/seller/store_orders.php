<?php
$title = "Pesanan Masuk - Admin Toko";
if (session_status() === PHP_SESSION_NONE) session_start();
include 'config/database.php';
ob_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
    echo "Akses ditolak."; exit;
}

$seller_id = $_SESSION['user']['id'];

$sql = "
SELECT p.id AS pesanan_id, u.name AS pembeli, p.tanggal, p.metode, p.status_pembayaran, p.order_id,
       GROUP_CONCAT(CONCAT(pr.nama, ' (', pi.jumlah, ')') SEPARATOR ', ') AS daftar_produk,
       SUM(pi.harga * pi.jumlah) AS total
FROM pesanan p
JOIN users u ON u.id = p.user_id
JOIN pesanan_item pi ON pi.pesanan_id = p.id
JOIN produk pr ON pi.produk_id = pr.id
WHERE pr.user_id = ?
GROUP BY p.id
ORDER BY p.tanggal DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4 text-center" style="color: #85005A;">
    <i class="bi bi-list-check me-2"></i>Pesanan Masuk
  </h2>

  <?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Produk</th>
          <th>Pembeli</th>
          <th>Tanggal</th>
          <th>Metode</th>
          <th>Total</th>
          <th>Status Bayar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while ($r = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($r['daftar_produk']) ?></td>
          <td><?= htmlspecialchars($r['pembeli']) ?></td>
          <td><?= date('d M Y - H:i', strtotime($r['tanggal'])) ?></td>
          <td><?= $r['metode'] ?></td>
          <td>Rp<?= number_format($r['total'], 0, ',', '.') ?></td>
          <td>
            <span class="badge <?= $r['status_pembayaran'] === 'Pembayaran Diterima' ? 'bg-success' : 'bg-custom-yellow' ?>">
              <?= $r['status_pembayaran'] ?>
            </span>
          </td>
          <td>
            <?php if ($r['status_pembayaran'] !== 'Pembayaran Diterima'): ?>
              <form action="controllers/admin_update_bayar.php" method="POST" class="d-inline">
                <input type="hidden" name="pesanan_id" value="<?= $r['pesanan_id'] ?>">
                <button type="submit" class="btn btn-sm rounded-pill" style="border-color: #85005A; color: #85005A;">
                  Tandai Dibayar
                </button>
              </form>
            <?php else: ?>
              <span class="text-success fw-bold">✔️</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
   <div class="alert alert-warning text-center">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>
  Belum ada pesanan untuk produk Anda.
</div>
  <?php endif; ?>
</div>

<!-- Modal Feedback -->
<?php if (isset($_GET['update'])): ?>
  <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header bg-<?= $_GET['update'] === 'success' ? 'success' : 'danger' ?> text-white">
          <h5 class="modal-title" id="statusModalLabel">
            <i class="bi <?= $_GET['update'] === 'success' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?> me-2"></i>
            <?= $_GET['update'] === 'success' ? 'Berhasil!' : 'Gagal!' ?>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          <?= $_GET['update'] === 'success' ? 'Status pembayaran berhasil diperbarui.' : 'Terjadi kesalahan saat memperbarui data.' ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-<?= $_GET['update'] === 'success' ? 'success' : 'danger' ?>" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
      statusModal.show();
    });
  </script>
<?php endif; ?>

<!-- Custom style untuk badge kuning -->
<style>
  .bg-custom-yellow {
    background-color: #ffc107 !important;
    color: #000;
  }
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>
