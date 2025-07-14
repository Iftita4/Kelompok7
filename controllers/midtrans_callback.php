<?php
// Midtrans Callback Handler
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Silakan kirim POST (tidak bisa dibuka langsung di browser).";
    exit;
}

// Ambil data JSON dari Midtrans
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Log untuk debugging (opsional, bisa dihapus di produksi)
file_put_contents(__DIR__ . "/../log_callback.txt", date('Y-m-d H:i:s') . " | " . $rawData . PHP_EOL, FILE_APPEND);

// Pastikan data valid
if (!isset($data['order_id']) || !isset($data['transaction_status']) || !isset($data['transaction_id'])) {
    http_response_code(400);
    exit("Invalid data.");
}

$order_id = $data['order_id'];
$transaction_status = $data['transaction_status']; // e.g. 'settlement'
$transaction_id = $data['transaction_id']; // ID transaksi dari Midtrans

// Status yang dianggap pembayaran sukses dari Midtrans
$paidStatuses = ['settlement', 'capture'];

// Hubungkan ke database
include __DIR__ . '/../config/database.php';

// Jika transaksi disetujui, tandai sebagai "Pembayaran Diterima"
if (in_array($transaction_status, $paidStatuses)) {
    $statusPembayaran = "Pembayaran Diterima";
} else if ($transaction_status === 'pending') {
    $statusPembayaran = "Menunggu Pembayaran";
} else if (in_array($transaction_status, ['deny', 'cancel', 'expire', 'failure'])) {
    $statusPembayaran = "Gagal";
} else {
    $statusPembayaran = ucfirst($transaction_status);
}

// Update status di tabel pesanan
$stmt = $conn->prepare("UPDATE pesanan SET status_pembayaran = ?, snap_token = ? WHERE order_id = ?");
$stmt->bind_param("sss", $statusPembayaran, $transaction_id, $order_id);
$stmt->execute();

// Beri respons 200 ke Midtrans
http_response_code(200);
echo "Callback received and order updated.";
