<?php
$title = "Pembayaran Gagal - ThriftHub";
ob_start();
?>

<div class="container py-5 text-center">
  <i class="bi bi-x-circle-fill text-danger display-1 mb-3"></i>
  <h2 class="fw-bold">Pembayaran Gagal</h2>
  <p class="text-muted">Transaksi kamu tidak berhasil. Silakan coba lagi atau gunakan metode pembayaran lain.</p>
  <a href="index.php?url=cart" class="btn btn-outline-danger mt-4 px-4 rounded-pill">
    <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Keranjang
  </a>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../views/layouts/index.php';
?>
