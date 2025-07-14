<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
  echo "Akses ditolak."; exit;
}

$title = "Pengaturan Toko";
ob_start();

// Misal ambil data dari DB untuk pengaturan toko
$user_id = $_SESSION['user']['id'];
$query = $conn->query("SELECT * FROM users WHERE id = $user_id");
$data = $query->fetch_assoc();
?>

<div class="container py-5">
  <h2 class="fw-bold text-center mb-4" style="color: #85005A;">
    <i class="bi bi-gear-fill me-2"></i> Pengaturan Toko
  </h2>

  <form action="controllers/proses_update_settings.php" method="POST" class="mx-auto shadow-sm p-4 rounded bg-white" style="max-width: 600px;">
    <div class="mb-3">
      <label class="form-label">Nama Toko</label>
      <input type="text" name="nama_toko" class="form-control" required value="<?= htmlspecialchars($data['nama_toko'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" rows="3" class="form-control"><?= htmlspecialchars($data['deskripsi_toko'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Alamat Toko</label>
      <input type="text" name="alamat_toko" class="form-control" required value="<?= htmlspecialchars($data['alamat_toko'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Nomor Telepon</label>
      <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($data['telepon'] ?? '') ?>">
    </div>
   <button type="submit" class="btn w-100 text-white" style="background-color: #85005A;">Simpan Perubahan</button>
  </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>
