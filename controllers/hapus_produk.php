<?php
include 'config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil nama file gambar (optional, jika ingin hapus juga dari folder)
$stmt = $conn->prepare("SELECT gambar FROM produk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if ($produk) {
  // Hapus file gambar jika ada
  $gambarPath = 'uploads/' . $produk['gambar'];
  if (file_exists($gambarPath)) {
    unlink($gambarPath);
  }

  // Hapus dari DB
  $delete = $conn->prepare("DELETE FROM produk WHERE id = ?");
  $delete->bind_param("i", $id);
  $delete->execute();
}

// Redirect kembali
header("Location: index.php?url=my_products&status=deleted");
exit;
?>
