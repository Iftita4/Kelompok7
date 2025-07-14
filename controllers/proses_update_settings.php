<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
  echo "Akses ditolak."; exit;
}

$user_id     = $_SESSION['user']['id'];
$nama_toko   = $_POST['nama_toko'] ?? '';
$deskripsi   = $_POST['deskripsi'] ?? '';
$alamat_toko = $_POST['alamat_toko'] ?? '';
$telepon     = $_POST['telepon'] ?? '';

// Update data ke database
$stmt = $conn->prepare("UPDATE users SET nama_toko = ?, deskripsi_toko = ?, alamat_toko = ?, telepon = ? WHERE id = ?");
$stmt->bind_param("ssssi", $nama_toko, $deskripsi, $alamat_toko, $telepon, $user_id);

if ($stmt->execute()) {
  header("Location: ../index.php?url=store_settings&status=success");
  exit;
} else {
  echo "Gagal menyimpan pengaturan toko.";
}
?>
