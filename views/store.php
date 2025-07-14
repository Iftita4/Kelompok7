<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'config/database.php';

$seller_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil informasi toko
$stmt = $conn->prepare("SELECT nama_toko, deskripsi_toko FROM users WHERE id = ? AND is_seller = 1");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$toko = $result->fetch_assoc();

if (!$toko) {
  echo "<div class='container py-5 text-center'><h4>Toko tidak ditemukan.</h4></div>";
  exit;
}

// Ambil produk dari seller
$stmt_produk = $conn->prepare("SELECT * FROM produk WHERE user_id = ? ORDER BY id DESC");
$stmt_produk->bind_param("i", $seller_id);
$stmt_produk->execute();
$produk_result = $stmt_produk->get_result();

$title = "Toko " . htmlspecialchars($toko['nama_toko']);
ob_start();
?>

<div class="container py-5">
  <!-- Header Toko -->
<div class="text-center mb-5">
  <div class="mb-3">
    <i class="bi bi-shop-window" style="font-size: 3rem; color: #85005A;"></i>
  </div>
  <h2 class="fw-bold" style="color: #85005A;"><?= htmlspecialchars($toko['nama_toko']); ?></h2>
  <div class="mx-auto mt-3" style="max-width: 700px;">
    <div class="p-4 rounded shadow-sm bg-white border border-2" style="border-color: #85005A;">
      <p class="mb-0 text-secondary fst-italic" style="font-size: 1.1rem; line-height: 1.7;">
        <?= nl2br(htmlspecialchars($toko['deskripsi_toko'])); ?>
      </p>
    </div>
  </div>
</div>


  <div class="row">
    <?php if ($produk_result->num_rows > 0): ?>
      <?php while ($p = $produk_result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <img src="<?= htmlspecialchars($p['gambar']); ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($p['nama']); ?></h5>
              <p class="card-text fw-bold text-danger">Rp<?= number_format($p['harga'], 0, ',', '.'); ?></p>
              <a href="index.php?url=product_detail&id=<?= $p['id']; ?>" class="btn btn-outline-primary w-100 mt-auto rounded-pill">
                <i class="bi bi-eye-fill"></i> Lihat Produk
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12 text-center py-5">
        <i class="bi bi-emoji-frown display-4 text-muted"></i>
        <h5 class="mt-3 text-secondary">Toko ini belum memiliki produk.</h5>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/index.php';
?>
