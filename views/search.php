<?php
$title = "Hasil Pencarian - ThriftHub";
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config/database.php';

$query = trim($_GET['query'] ?? '');

?>

<div class="container py-5">
  <h2 class="fw-bold text-center mb-4" style="color: #85005A;">
    <i class="bi bi-search-heart me-2"></i>Hasil Pencarian untuk "<span class="text-dark"><?= htmlspecialchars($query); ?></span>"
  </h2>

  <div class="row">
    <?php
    $sql = "SELECT * FROM produk WHERE nama LIKE ? OR kategori LIKE ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
      while ($p = $result->fetch_assoc()):
    ?>
         <div class="col-md-4 fade-in-up delay-2">
          <div class="card h-100 border-0 shadow-sm">
            <img src="<?= htmlspecialchars($p['gambar']); ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="<?= htmlspecialchars($p['nama']); ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($p['nama']); ?></h5>
              <p class="text-danger fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></p>
              <a href="index.php?url=product_detail&id=<?= $p['id']; ?>" class="btn btn-outline-primary mt-auto">
                <i class="bi bi-eye-fill"></i> Lihat Detail
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; else: ?>
      <div class="col-12 text-center py-5">
        <i class="bi bi-emoji-frown display-4 text-muted"></i>
        <h5 class="mt-3 text-secondary">Produk dengan kata kunci tersebut tidak ditemukan.</h5>
        <a href="index.php?url=home" class="btn btn-outline-secondary mt-3 rounded-pill px-4">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'layouts/index.php';
?>
