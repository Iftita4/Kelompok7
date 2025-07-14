<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = "Checkout - ThriftHub";
ob_start();
include 'config/database.php';

if (!isset($_SESSION['user']['id'])) {
  header("Location: index.php?url=login");
  exit;
}

if (empty($_SESSION['cart'])) {
  header("Location: index.php?url=cart");
  exit;
}

// Hitung total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
  $total += $item['price'] * $item['quantity'];
}
$order_id = 'THRIFT-' . rand(100000, 999999);
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4 text-center" style="color: #85005A;">
    <i class="bi bi-credit-card-fill me-2"></i> Checkout
  </h2>
  <div class="row g-4">
    <!-- Info Pengiriman -->
    <div class="col-md-6">
      <div class="card border-0 shadow-sm p-4">
        <h5 class="mb-3">Informasi Pengiriman</h5>
        <form id="checkout-form">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['name']); ?>" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="3" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="metode" id="metodeCod" value="COD" required>
              <label class="form-check-label" for="metodeCod">COD (Bayar di tempat)</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="metode" id="metodeTransfer" value="Transfer" required>
              <label class="form-check-label" for="metodeTransfer">Transfer (Via Midtrans)</label>
            </div>
          </div>

          <input type="hidden" name="order_id" value="<?= $order_id; ?>">
          <input type="hidden" name="total" value="<?= $total; ?>">
        </form>
      </div>
    </div>

    <!-- Ringkasan -->
    <div class="col-md-6">
      <div class="card border-0 shadow-sm p-4">
        <h5 class="mb-3">Ringkasan Belanja</h5>
        <ul class="list-group mb-3">
          <?php foreach ($_SESSION['cart'] as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($item['name']); ?> x <?= $item['quantity']; ?>
              <span class="text-end fw-semibold">Rp<?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="d-flex justify-content-between fw-bold fs-5">
          <span>Total:</span>
          <span class="text-success">Rp<?= number_format($total, 0, ',', '.'); ?></span>
        </div>

        <button id="pay-button" class="btn btn-success w-100 rounded-pill mt-4">
          <i class="bi bi-credit-card-2-back me-1"></i> Bayar Sekarang
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-Fws8DN7qBE2DH_lN"></script>
<script>
  document.getElementById('pay-button').addEventListener('click', async function () {
    const form = document.getElementById('checkout-form');
    const formData = new FormData(form);
    const metode = formData.get('metode');
    const cart = <?= json_encode($_SESSION['cart']); ?>;

    const data = {
      order_id: formData.get('order_id'),
      nama: formData.get('nama'),
      alamat: formData.get('alamat'),
      total: formData.get('total'),
      metode: metode,
      cart: cart
    };

    if (!metode) {
      alert('Silakan pilih metode pembayaran.');
      return;
    }

    if (metode === 'COD') {
      // Langsung submit ke proses_checkout tanpa Midtrans
      const redirectForm = document.createElement('form');
      redirectForm.action = 'index.php?url=proses_checkout';
      redirectForm.method = 'POST';
      redirectForm.innerHTML = `
        <input type="hidden" name="order_id" value="${data.order_id}">
        <input type="hidden" name="nama" value="${data.nama}">
        <input type="hidden" name="alamat" value="${data.alamat}">
        <input type="hidden" name="total" value="${data.total}">
        <input type="hidden" name="metode" value="${data.metode}">
      `;
      document.body.appendChild(redirectForm);
      redirectForm.submit();
    }

    if (metode === 'Transfer') {
      try {
        const res = await fetch('controllers/get_token.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });

        const result = await res.json();

        if (result.token) {
          snap.pay(result.token, {
          onSuccess: function(result) {
            console.log("Sukses:", result);
            submitToProsesCheckout(result);
          },
          onPending: function(result) {
            if (result.redirect_url) {
              window.location.href = result.redirect_url;
            } else {
              submitToProsesCheckout(result);
            }
          }
          ,
          onClose: function() {
            alert("Popup ditutup sebelum bayar.");
          }
        });


        } else {
          alert(result.error || 'Gagal mengambil token pembayaran.');
        }
      } catch (error) {
        alert('Terjadi kesalahan saat mengambil token pembayaran.');
      }
    }

    function submitToProsesCheckout(result) {
      console.log("Mau submit ke proses_checkout", result);
      const redirectForm = document.createElement('form');
      redirectForm.action = 'index.php?url=proses_checkout';
      redirectForm.method = 'POST';
      redirectForm.innerHTML = `
        <input type="hidden" name="order_id" value="${data.order_id}">
        <textarea name="snap_result" style="display:none">${JSON.stringify(result)}</textarea>
        <input type="hidden" name="nama" value="${data.nama}">
        <input type="hidden" name="alamat" value="${data.alamat}">
        <input type="hidden" name="total" value="${data.total}">
        <input type="hidden" name="metode" value="${data.metode}">
      `;
      document.body.appendChild(redirectForm);
      redirectForm.submit();
    }

  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../views/layouts/index.php';
?>
