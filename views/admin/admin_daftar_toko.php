<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.php?url=login");
  exit;
}

$title = "Manajemen Toko - ThriftHub";
include __DIR__ . '/../../config/database.php';
ob_start();

// Ambil semua user yang statusnya seller
$sql = "SELECT id, name, email, nama_toko FROM users WHERE is_seller = 1";
$result = $conn->query($sql);
?>

<div class="container py-4">
  <h2 class="fw-bold mb-4 text-center" style="color:#85005A;">
    <i class="bi bi-shop-window me-2"></i> Manajemen Toko
  </h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle text-center shadow-sm rounded tabel-striped">
        <thead class="text-white" style="background-color: #b7318cff;">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nama Pemilik</th>
            <th scope="col">Email</th>
            <th scope="col">Nama Toko</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody style="background-color: #fff;">
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="fw-semibold"><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td class="text-capitalize"><?= htmlspecialchars($row['nama_toko']) ?></td>
              <td>
                <form method="POST" action="controllers/delete_toko.php" onsubmit="return confirm('Yakin ingin menghapus toko ini?');">
                  <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger px-3">
                    <i class="bi bi-trash me-1"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">Belum ada toko yang terdaftar.</div>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_layout.php';
?>
