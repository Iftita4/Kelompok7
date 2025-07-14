<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
  echo "Akses ditolak."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesanan_id'])) {
  $pesanan_id = intval($_POST['pesanan_id']);

  $sql = "UPDATE pesanan SET status_pembayaran = 'Pembayaran Diterima' WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $pesanan_id);

 if ($stmt->execute()) {
    header("Location: ../index.php?url=store_shipping&update=success");
    exit;
  } else {
    header("Location: ../index.php?url=store_shipping&update=fail");
    exit;
  }
  }else {
  header("Location: ../index.php?url=store_shipping");
  exit;
  }