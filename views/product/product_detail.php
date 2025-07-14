<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
  header("Location: index.php?url=login&message=login_required");
  exit;
}

$title = "Detail Produk - ThriftHub";
ob_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
include 'config/database.php';

$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();
$seller_id = $produk['user_id'] ?? null;

$stmt_toko = $conn->prepare("SELECT nama_toko FROM users WHERE id = ?");
$stmt_toko->bind_param("i", $seller_id);
$stmt_toko->execute();
$toko_result = $stmt_toko->get_result();
$toko = $toko_result->fetch_assoc();
?>

<section class="py-5">
  <div class="container">

    <?php if ($produk): ?>
      <div class="row g-5">
        <!-- Gambar Produk -->
        <div class="col-md-6" data-aos="zoom-in">
          <img src="<?= htmlspecialchars($produk['gambar']); ?>" alt="<?= htmlspecialchars($produk['nama']); ?>" class="img-fluid rounded shadow" style="max-height: 500px; object-fit: cover;">
        </div>

        <!-- Detail Produk -->
        <div class="col-md-6" data-aos="fade-left">
          <!-- Toko -->
          <div class="mb-3">
            <span class="d-inline-block px-3 py-2 rounded-pill text-white fw-semibold" 
                  style="background-color: #85005A;">
              <i class="bi bi-shop me-2"></i> 
              <a href="index.php?url=store&id=<?= $seller_id ?>" 
                 class="text-white text-decoration-none"
                 onmouseover="this.style.textDecoration='underline';"
                 onmouseout="this.style.textDecoration='none';">
                <?= htmlspecialchars($toko['nama_toko'] ?? 'Toko Tidak Diketahui'); ?>
              </a>
            </span>
          </div>

          <h2 class="fw-bold mb-3" style="color: #85005A;"><?= htmlspecialchars($produk['nama']); ?></h2>
          <p class="text-danger fs-4 fw-bold">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
          <p class="text-muted"><?= nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
          <p><span class="badge bg-secondary">Kategori: <?= htmlspecialchars($produk['kategori']); ?></span></p>

          <!-- Form Tambah ke Keranjang -->
          <form action="index.php?url=add_to_cart" method="POST" class="mt-4">
            <input type="hidden" name="produk_id" value="<?= $produk['id']; ?>">
            <div class="mb-3">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required>
            </div>
            <button type="submit" class="btn px-4 rounded-pill text-white"
              style="background-color: #85005A; border: none;"
              onmouseover="this.style.backgroundColor='#A23E7D';"
              onmouseout="this.style.backgroundColor='#85005A';">
              <i class="bi bi-cart-plus-fill"></i> Tambah ke Keranjang
            </button>
          </form>

          <!-- Tombol Kembali -->
          <a href="index.php" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
          </a>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">Produk tidak ditemukan.</div>
      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/index.php';

if (isset($_GET['status']) && $_GET['status'] === 'added'):
?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Produk telah ditambahkan ke keranjang.',
      showConfirmButton: false,
      timer: 2000
    });
  });
</script>
<?php endif; ?>
