<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['is_seller'] != 1) {
    echo "Akses ditolak."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pesanan_id         = $_POST['pesanan_id'] ?? null;
    $status_pengiriman  = $_POST['status_pengiriman'] ?? '';
    $lokasi_pengiriman  = $_POST['lokasi_pengiriman'] ?? '';
    $estimasi_tiba      = $_POST['estimasi_tiba'] ?? null;

    if (!$pesanan_id || !$status_pengiriman || !$lokasi_pengiriman) {
        die("Data tidak lengkap.");
    }

    $seller_id = $_SESSION['user']['id'];

    $cek = $conn->prepare("
        SELECT p.id FROM pesanan p
        JOIN pesanan_item pi ON pi.pesanan_id = p.id
        JOIN produk pr ON pi.produk_id = pr.id
        WHERE p.id = ? AND pr.user_id = ?
        LIMIT 1
    ");
    $cek->bind_param("ii", $pesanan_id, $seller_id);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows === 0) {
        die("Anda tidak berhak mengubah data pesanan ini.");
    }

    $update = $conn->prepare("
        UPDATE pesanan
        SET status_pengiriman = ?, lokasi_pengiriman = ?, estimasi_tiba = ?
        WHERE id = ?
    ");
    $update->bind_param("sssi", $status_pengiriman, $lokasi_pengiriman, $estimasi_tiba, $pesanan_id);
    if ($update->execute()) {
        // Redirect dengan parameter untuk trigger modal
        header("Location: ../index.php?url=store_shipping&update=success");
        exit;
    } else {
        die("Gagal mengupdate pengiriman.");
    }

} else {
    echo "Metode tidak diizinkan.";
}
?>
