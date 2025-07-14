<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../index.php?url=login");
  exit;
}

include __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
  $userId = intval($_POST['user_id']);

  // Set is_seller = 0 untuk menonaktifkan toko
  $stmt = $conn->prepare("UPDATE users SET is_seller = 0, nama_toko = NULL, deskripsi_toko = NULL WHERE id = ?");
  $stmt->bind_param("i", $userId);

  if ($stmt->execute()) {
    $_SESSION['flash'] = "Toko berhasil dinonaktifkan.";
  } else {
    $_SESSION['flash'] = "Gagal menonaktifkan toko.";
  }

  $stmt->close();
}

header("Location: ../index.php?url=admin_daftar_toko");
exit;
