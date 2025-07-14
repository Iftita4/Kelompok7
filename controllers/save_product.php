<?php
session_start();
include 'config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user']['id'])) {
    header("Location: index.php?url=login");
    exit;
}

$user_id = $_SESSION['user']['id'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];
$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

// Upload file
$upload_dir = "uploads/";
$upload_path = $upload_dir . basename($gambar);

if (move_uploaded_file($tmp, $upload_path)) {
    $stmt = $conn->prepare("INSERT INTO produk (user_id, nama, kategori, harga, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississ", $user_id, $nama, $kategori, $harga, $deskripsi, $upload_path);

    if ($stmt->execute()) {
        header("Location: index.php?url=my_products&status=success");
        exit;
    } else {
        echo "Gagal menyimpan produk: " . $conn->error;
    }
} else {
    echo "Gagal upload gambar";
}
?>
