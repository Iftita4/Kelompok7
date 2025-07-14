<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['user'])) {
  header("Location: index.php?url=login&message=login_required");
  exit;
}

$title = "Keranjang - ThriftHub";
ob_start();
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4" style="color: #85005A;"><i class="bi bi-cart-fill me-2"></i> Keranjang Anda</h2>

  <?php if (empty($_SESSION['cart'])): ?>
    <div class="text-center py-5">
      <i class="bi bi-cart-x display-4 text-muted"></i>
      <h4 class="text-secondary mt-3">Keranjang Anda masih kosong</h4>
      <a href="index.php" class="btn btn-outline-primary mt-3 rounded-pill px-4">
        <i class="bi bi-arrow-left"></i> Belanja Sekarang
      </a>
    </div>

  <?php else: ?>
    <div class="table-responsive mb-4">
      <table class="table align-middle shadow-sm rounded">
        <thead class="table-light">
          <tr>
            <th scope="col">Produk</th>
            <th scope="col">Nama</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($_SESSION['cart'] as $item):
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
          ?>
            <tr>
              <td><img src="<?= htmlspecialchars($item['image']) ?>" width="70" class="rounded shadow-sm" alt="<?= htmlspecialchars($item['name']) ?>"></td>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
              <td><?= $item['quantity'] ?></td>
              <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
              <td>
                <a href="index.php?url=remove_cart&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger rounded-circle">
                  <i class="bi bi-trash-fill"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
      <h4 class="fw-bold">Total: <span class="text-primary">Rp<?= number_format($total, 0, ',', '.') ?></span></h4>
      <a href="index.php?url=checkout" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-credit-card-fill me-1"></i> Checkout
      </a>
    </div>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layouts/index.php';
?>
