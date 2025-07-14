<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = "Kelola Pengiriman - Admin Toko";
include 'config/database.php';
ob_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
  echo "Akses ditolak."; exit;
}

$seller_id = $_SESSION['user']['id'];

$sql = "
SELECT p.id AS pesanan_id, p.order_id, u.name AS pembeli, p.alamat, p.status_pengiriman, 
       p.lokasi_pengiriman, p.estimasi_tiba
FROM pesanan p
JOIN users u ON u.id = p.user_id
JOIN pesanan_item pi ON pi.pesanan_id = p.id
JOIN produk pr ON pr.id = pi.produk_id
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
  <i class="bi bi-truck me-2"></i>Kelola Pengiriman
</h2>

  <?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Order ID</th>
          <th>Pembeli</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>Lokasi</th>
          <th>Estimasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['pesanan_id'] ?></td>
          <td><span class="badge bg-secondary"><?= htmlspecialchars($row['order_id']) ?></span></td>
          <td><?= htmlspecialchars($row['pembeli']) ?></td>
          <td><?= htmlspecialchars($row['alamat']) ?></td>
          <td>
            <form method="POST" action="controllers/proses_update_pengiriman.php">
              <input type="hidden" name="pesanan_id" value="<?= $row['pesanan_id'] ?>">
              <select name="status_pengiriman" class="form-select form-select-sm" required>
                <?php
                $statuses = ['Diproses', 'Dikirim', 'Dalam Perjalanan', 'Diterima'];
                foreach ($statuses as $s):
                ?>
                  <option value="<?= $s ?>" <?= $row['status_pengiriman'] === $s ? 'selected' : '' ?>>
                    <?= $s ?>
                  </option>
                <?php endforeach; ?>
              </select>
          </td>
          <td>
              <input type="text" name="lokasi_pengiriman" class="form-control form-control-sm" value="<?= $row['lokasi_pengiriman'] ?>" required>
          </td>
          <td>
              <input type="date" name="estimasi_tiba" class="form-control form-control-sm" value="<?= $row['estimasi_tiba'] ?>">
          </td>
          <td>
              <button type="submit" class="btn btn-sm btn-primary rounded-pill">Update</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>
  Belum ada pesanan untuk dikirim.
</div>
  <?php endif; ?>
</div>

<?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
<!-- Modal Berhasil -->
<div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="updateSuccessModalLabel"><i class="bi bi-check-circle-fill me-2"></i>Berhasil!</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Data pengiriman berhasil diperbarui.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('updateSuccessModal'));
    modal.show();
  });
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>
