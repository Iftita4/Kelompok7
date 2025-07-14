<?php
$title = "Checkout Berhasil - ThriftHub";
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php';

$order_id = $_GET['order_id'] ?? null;
$pesanan = null;

if ($order_id) {
    $stmt = $conn->prepare("SELECT nama, alamat, metode, status_pembayaran, order_id, total FROM pesanan WHERE order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pesanan = $result->fetch_assoc();
}

?>

<div class="container py-5 text-center">
  <i class="bi bi-check-circle-fill display-4 text-success mb-3"></i>
  <h2 class="fw-bold">Terima kasih!</h2>

  <?php if ($pesanan): ?>
    <p class="text-muted">Pesanan <strong>#<?= htmlspecialchars($pesanan['order_id']); ?></strong> berhasil dibuat atas nama <strong><?= htmlspecialchars($pesanan['nama']); ?></strong>.</p>
    <p class="mb-1">Metode Pembayaran: <strong><?= htmlspecialchars($pesanan['metode']); ?></strong></p>
    <p class="mb-1">Total Pembayaran: <strong class="text-success">Rp<?= number_format($pesanan['total'], 0, ',', '.'); ?></strong></p>
    <p class="mb-3">Status Pembayaran: <span class="badge bg-info"><?= htmlspecialchars($pesanan['status_pembayaran']); ?></span></p>

    <?php if (strtolower($pesanan['metode']) === 'Transfer'): ?>
      <div class="alert alert-warning mx-auto" style="max-width: 500px;">
        Silakan klik tombol di bawah untuk menyelesaikan pembayaran melalui Midtrans.
      </div>
      <form id="pay-form" method="POST">
        <button type="button" id="pay-button" class="btn btn-success px-4 rounded-pill">
          <i class="bi bi-credit-card-2-back"></i> Bayar Sekarang
        </button>
      </form>
    <?php endif; ?>
  <?php else: ?>
    <p class="text-muted">Pesanan tidak ditemukan atau telah kedaluwarsa.</p>
  <?php endif; ?>

  <a href="index.php" class="btn btn-outline-primary mt-4 px-4 rounded-pill">
    <i class="bi bi-house-fill"></i> Kembali ke Beranda
  </a>
</div>

<?php if ($pesanan && strtolower($pesanan['metode']) === 'transfer'): ?>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-Fws8DN7qBE2DH_lN"></script>
  <script>
    document.getElementById('pay-button').addEventListener('click', function () {
      fetch('controllers/get_token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          order_id: "<?= $pesanan['order_id']; ?>",
          nama: "<?= addslashes($pesanan['nama']); ?>",
          alamat: "<?= addslashes($pesanan['alamat']); ?>",
          total: <?= $pesanan['total']; ?>,
          cart: <?= json_encode($_SESSION['last_cart'] ?? []); ?>
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.token) {
          window.snap.pay(data.token);
        } else {
          alert('Gagal membuat token pembayaran');
        }
      })
      .catch(err => {
        alert('Terjadi kesalahan saat proses pembayaran');
        console.error(err);
      });
    });
  </script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/index.php';
?>
