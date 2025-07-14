<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesanan_id'])) {
  $id = intval($_POST['pesanan_id']);
  $update = $conn->prepare("UPDATE pesanan SET status_pengiriman = 'Selesai' WHERE id = ?");
  $update->bind_param("i", $id);
  $update->execute();

  header("Location: ../index.php?url=sales_history&kirim=berhasil");
  exit;
}
?>
