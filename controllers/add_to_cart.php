<?php
session_start();

// Cegah akses tanpa login
if (!isset($_SESSION['user'])) {
  header("Location: index.php?url=login&message=login_required");
  exit;
}

include __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produk_id'], $_POST['jumlah'])) {
  $produk_id = intval($_POST['produk_id']);
  $jumlah = intval($_POST['jumlah']);

  $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
  $stmt->bind_param("i", $produk_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $produk = $result->fetch_assoc();

  if ($produk) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$produk_id])) {
      $_SESSION['cart'][$produk_id]['quantity'] += $jumlah;
    } else {
      $_SESSION['cart'][$produk_id] = [
        'id' => $produk_id,
        'name' => $produk['nama'],
        'price' => $produk['harga'],
        'image' => $produk['gambar'],
        'quantity' => $jumlah
      ];
    }

    header("Location: index.php?url=product_detail&id=$produk_id&status=added");
    exit;
  } else {
    echo "Produk tidak ditemukan.";
  }
} else {
  echo "Permintaan tidak valid.";
}
?>
