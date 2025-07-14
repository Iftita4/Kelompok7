<?php
$title = "Produk Saya - ThriftHub";
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user']['id'])) {
    header("Location: index.php?url=login");
    exit;
}

$user_id = $_SESSION['user']['id'];

$sql = "SELECT * FROM produk WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container py-5">
  <h2 class="fw-bold text-center mb-4" style="color: #85005A;">
    <i class="bi bi-bag-heart-fill me-2"></i>Produk Saya
  </h2>

  <div class="row">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($p = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <img src="<?= htmlspecialchars($p['gambar']); ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nama']); ?>" style="height: 250px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-truncate"><?= htmlspecialchars($p['nama']); ?></h5>
              <p class="card-text fw-bold text-danger">Rp<?= number_format($p['harga'], 0, ',', '.'); ?></p>
              <div class="mt-auto d-flex justify-content-between">
                <a href="index.php?url=edit_produk&id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="index.php?url=hapus_produk&id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                  <i class="bi bi-trash"></i> Hapus
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12 text-center py-5">
        <i class="bi bi-emoji-frown display-4 text-muted"></i>
        <h5 class="mt-3 text-secondary">Belum ada produk yang Anda tambahkan.</h5>
        <a href="index.php?url=add_product" class="btn btn-primary mt-3 rounded-pill px-4">
          <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>