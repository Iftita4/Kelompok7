<?php
$title = "Kategori Produk - ThriftHub";
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php';

// Ambil kategori dari URL (jika ada)
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;

// Ambil produk berdasarkan kategori
if ($kategori) {
  $stmt = $conn->prepare("SELECT * FROM produk WHERE kategori = ? ORDER BY id DESC");
  $stmt->bind_param("s", $kategori);
} else {
  $stmt = $conn->prepare("SELECT * FROM produk ORDER BY id DESC");
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5">
  <div class="row">
    <!-- Sidebar Kategori -->
    <div class="col-md-3">
      <div class="bg-white p-4 shadow-sm rounded">
        <h5 class="fw-bold mb-3">Kategori</h5>
        <ul class="list-group list-group-flush">
          <?php
          $kategoriList = ['Kemeja', 'Celana', 'Jaket', 'Sepatu', 'Tas', 'Lainnya'];
          foreach ($kategoriList as $k): ?>
            <li class="list-group-item<?= $kategori == $k ? ' active' : '' ?>">
              <a href="index.php?url=category&kategori=<?= urlencode($k) ?>" class="text-decoration-none<?= $kategori == $k ? ' text-white' : ' text-dark' ?>"><?= $k ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Daftar Produk -->
    <div class="col-md-9">
      <h3 class="mb-4 fw-bold" style="color: #85005A;">
        <i class="bi bi-grid"></i> <?= $kategori ? htmlspecialchars($kategori) : 'Semua Produk'; ?>
      </h3>

      <?php if ($result->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
          <?php while ($p = $result->fetch_assoc()): ?>
            <div class="col">
              <div class="card h-100 shadow-sm border-0">
                <img src="<?= htmlspecialchars($p['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nama']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= htmlspecialchars($p['nama']) ?></h5>
                  <p class="text-danger fw-bold">Rp<?= number_format($p['harga'], 0, ',', '.') ?></p>
                  <p class="text-muted small mb-2">Kategori: <?= htmlspecialchars($p['kategori']) ?></p>
                  <div class="mt-auto d-grid">
                    <a href="index.php?url=product_detail&id=<?= $p['id'] ?>" class="btn btn-outline-primary rounded-pill btn-sm">
                      <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-warning text-center">Tidak ada produk dalam kategori ini.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../views/layouts/index.php';
?>
