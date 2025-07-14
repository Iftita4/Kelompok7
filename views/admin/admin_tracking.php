<?php
$title = "Update Status Pengiriman - Admin ThriftHub";
ob_start();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include 'config/database.php';

// Cek jika admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php?url=login");
    exit;
}

// Ambil semua pesanan
$sql = "SELECT p.*, u.name AS pembeli FROM pesanan p JOIN users u ON u.id = p.user_id ORDER BY p.tanggal DESC";
$result = $conn->query($sql);
?>

<div class="container py-5">
  <h2 class="fw-bold text-center mb-4" style="color: #85005A;">
    <i class="bi bi-pencil-square me-2"></i> Update Status Pengiriman
  </h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
          <tr>
            <th>ID</th>
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
              <form method="POST" action="controllers/proses_update_pengiriman.php">
                <input type="hidden" name="pesanan_id" value="<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['pembeli']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td>
                  <select name="status_pengiriman" class="form-select" required>
                    <?php
                    $statuses = ['Diproses', 'Dikirim', 'Dalam Perjalanan', 'Diterima'];
                    foreach ($statuses as $status):
                    ?>
                      <option value="<?= $status ?>" <?= $row['status_pengiriman'] == $status ? 'selected' : '' ?>>
                        <?= $status ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td><input type="text" name="lokasi_pengiriman" class="form-control" value="<?= $row['lokasi_pengiriman'] ?>" required></td>
                <td><input type="date" name="estimasi_tiba" class="form-control" value="<?= $row['estimasi_tiba'] ?>"></td>
                <td><button type="submit" class="btn btn-sm btn-primary">Update</button></td>
              </form>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center">Belum ada pesanan.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_layout.php';
?>
