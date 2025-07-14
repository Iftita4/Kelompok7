<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user']['id'])) {
        echo "Akses ditolak. Harus login.";
        exit;
    }

    include __DIR__ . '/../config/database.php';

    // Ambil data dari POST
    $user_id    = $_SESSION['user']['id'];
    $nama       = $_POST['nama'] ?? '';
    $alamat     = $_POST['alamat'] ?? '';
    $metode     = $_POST['metode'] ?? 'COD';
    $orderId    = $_POST['order_id'] ?? 'ORDER-' . time();
    $snapResult = $_POST['snap_result'] ?? null;
    $tanggal    = date("Y-m-d H:i:s");

    if (empty($_SESSION['cart'])) {
        echo "Keranjang kosong!";
        exit;
    }

    // Hitung total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Status berdasarkan metode
    $statusPembayaran = ($metode === 'Transfer') ? 'Menunggu Verifikasi' : 'Belum Dibayar';
    $snapToken = $snapResult ? json_encode($snapResult) : null;
    $statusPengiriman = 'Belum Diproses';

    // Simpan pesanan ke database
    $stmt = $conn->prepare("INSERT INTO pesanan 
        (user_id, nama, alamat, metode, tanggal, total, order_id, snap_token, status_pembayaran, status_pengiriman)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssdssss", $user_id, $nama, $alamat, $metode, $tanggal, $total, $orderId, $snapToken, $statusPembayaran, $statusPengiriman);
    $stmt->execute();
    $pesanan_id = $stmt->insert_id;

    // Simpan item pesanan
    $stmtItem = $conn->prepare("INSERT INTO pesanan_item (pesanan_id, produk_id, nama, harga, jumlah) VALUES (?, ?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $item) {
        $stmtItem->bind_param("iisdi", $pesanan_id, $item['id'], $item['name'], $item['price'], $item['quantity']);
        $stmtItem->execute();
    }

    // Simpan salinan cart terakhir (optional untuk tampilan di halaman sukses)
    $_SESSION['last_cart'] = $_SESSION['cart'];

    // Hapus keranjang
    unset($_SESSION['cart']);

    // Redirect ke halaman sukses
    header("Location: index.php?url=checkout_success&order_id=" . urlencode($orderId));
    exit;

} else {
    echo "Akses tidak diizinkan.";
}
