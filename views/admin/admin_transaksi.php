<?php
$title = "Kelola Transaksi - Admin";
include 'middlewares/admin_only.php';
include 'config/database.php';
ob_start();

$transaksi = $conn->query("SELECT p.id AS pesanan_id, u.name AS pembeli, p.tanggal, SUM(pi.harga * pi.jumlah) AS total 
FROM pesanan p
JOIN users u ON u.id = p.user_id
JOIN pesanan_item pi ON pi.pesanan_id = p.id
GROUP BY p.id
ORDER BY p.tanggal DESC");
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4" style="color: #85005A;"><i class="bi bi-receipt-cutoff me-2"></i> Kelola Transaksi</h2>

  <?php if ($transaksi->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>Pembeli</th>
            <th>Tanggal</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; while ($row = $transaksi->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['pembeli']) ?></td>
              <td><?= date('d M Y - H:i', strtotime($row['tanggal'])) ?></td>
              <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">
      <i class="bi bi-info-circle"></i> Belum ada transaksi yang tercatat.
    </div>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_layout.php';
?>
