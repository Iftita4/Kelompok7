<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Metode tidak diizinkan');
}

if (!isset($_POST['pesanan_id']) || !isset($_SESSION['user']['id'])) {
  http_response_code(400);
  exit('Data tidak lengkap atau tidak login');
}

$pesanan_id = $_POST['pesanan_id'];
$user_id = $_SESSION['user']['id'];

// Validasi apakah pesanan milik user tersebut
$stmt = $conn->prepare("SELECT id FROM pesanan WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $pesanan_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  http_response_code(403);
  exit('Pesanan tidak ditemukan atau bukan milik Anda');
}

// Update status
$stmt = $conn->prepare("UPDATE pesanan SET status_pengiriman = 'Diterima', diterima = 1 WHERE id = ?");
$stmt->bind_param("i", $pesanan_id);

if ($stmt->execute()) {
  header("Location: index.php?url=riwayat&konfirmasi=berhasil");
  exit;
} else {
  echo "Gagal mengkonfirmasi pesanan.";
}
