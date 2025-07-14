<?php
session_start();
include 'config/database.php';

if (isset($_SESSION['user']['id'])) {
    $id = $_SESSION['user']['id'];

    // Ubah jadi penjual (tanpa ubah role)
    $stmt = $conn->prepare("UPDATE users SET is_seller = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Update session
    $_SESSION['user']['is_seller'] = 1;

    // Redirect ke dashboard toko
    header("Location: index.php?url=admin_store_dashboard");
    exit;
} else {
    echo "Akses tidak diizinkan.";
}
