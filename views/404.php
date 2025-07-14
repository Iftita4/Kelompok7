<?php
$title = "Halaman Tidak Ditemukan - ThriftHub";
ob_start();
?>
<div class="container py-5 text-center">
  <h1 class="display-4 text-danger">404</h1>
  <p class="lead">Halaman yang Anda cari tidak ditemukan.</p>
  <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/index.php'; // sesuaikan path jika perlu
?>
