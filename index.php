<?php
require_once 'config/database.php';

// Mulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tangkap URL
$url = $_GET['url'] ?? 'home';

// 👉 Routing khusus untuk proses (submit, aksi, dsb)
if ($url === 'submit_testimoni') {
    include __DIR__ . '/controllers/testimoni_store.php';
    exit;
}
if ($url === 'product_detail' && isset($_GET['id'])) {
    include 'views/product/product_detail.php';
    exit;
}
if ($url === 'save_product') {
    include 'controllers/save_product.php';
    exit;
}
if ($url === 'remove_cart') {
    include 'controllers/remove_cart.php';
    exit;
}
if ($url === 'konfirmasi_kirim') {
    include 'controllers/konfirmasi_kirim.php';
    exit;
}
if ($url === 'add_to_cart') {
    include 'controllers/add_to_cart.php';
    exit;
}
if ($url === 'checkout') {
    include 'views/checkout.php';
    exit;
}
if ($url === 'proses_checkout') {
    include 'controllers/proses_checkout.php';
    exit;
}
if ($url === 'checkout_success') {
    include 'views/checkout_success.php';
    exit;
}
if ($url === 'admin_store_dashboard') {
    include 'views/seller/admin_store_dashboard.php';
    exit;
}
if ($url === 'edit_produk') {
    include 'views/product/edit_produk.php';
    exit;
}
if ($url === 'my_products') {
    include 'views/product/my_products.php';
    exit;
}
if ($url === 'add_product') {
    include 'views/product/add_product.php';
    exit;
}
if ($url === 'sales_history') {
    include 'views/product/sales_history.php';
    exit;
}
if ($url === 'my_transactions') {
    include 'views/product/my_transactions.php';
    exit;
}
if ($url === 'my_orders') {
    include 'views/product/my_orders.php';
    exit;
}
if ($url === 'hapus_produk') {
    include 'controllers/hapus_produk.php';
    exit;
}
if ($url === 'admin_dashboard') {
    include 'views/admin/dashboard.php';
    exit;
}
if ($url === 'admin_produk') {
    include 'views/admin/admin_produk.php';
    exit;
}
if ($url === 'admin_user') {
    include 'views/admin/admin_user.php';
    exit;
}
if ($url === 'admin_transaksi') {
    include 'views/admin/admin_transaksi.php';
    exit;
}
if ($url === 'admin_tracking') {
    include 'views/admin/admin_tracking.php';
    exit;
}
if($url==='admin_pembayaran'){ 
    include 'views/admin/admin_pembayaran.php'; 
    exit; }
if($url==='midtrans_callback'){ 
    include 'controllers/midtrans_callback.php'; 
    exit; }
if($url==='admin_daftar_toko'){ 
    include 'views/admin/admin_daftar_toko.php'; 
    exit; }
if($url==='delete_toko'){ 
    include 'controllers/delete_toko.php'; 
    exit; }
if($url==='admin_update_bayar'){ 
    include 'controllers/admin_update_bayar.php'; 
    exit; }

if ($url === 'proses_update_pengiriman') {
    include 'controllers/proses_update_pengiriman.php';
    exit;
}
if ($url == 'konfirmasi_diterima') {
  include 'controllers/konfirmasi_diterima.php';
  exit;
}
if ($url === 'penjual') {
  include 'controllers/penjual.php';
  exit;
}
if ($url === 'proses_update_settings') {
  include 'controllers/proses_update_settings.php';
  exit;
}
if ($url === 'store_orders') {
  include 'views/seller/store_orders.php';
  exit;
}
if ($url === 'store_settings') {
  include 'views/seller/store_settings.php';
  exit;
}
if ($url === 'store_shipping') {
  include 'views/seller/store_shipping.php';
  exit;
}
  if ($url === 'store') {
    include 'views/store.php';
    exit;
  }


if ($url == 'tracking' && isset($_GET['pesanan_id'])) {
  include 'views/product/tracking.php';
  exit;
}


// Daftar view yang diizinkan untuk langsung include dari folder views/
$allowedViews = [
    'home', 'tentang', 'kontak', 'cart',
    'dashboard', 'category','admin','search',
];

// Routing utama untuk halaman
switch ($url) {
    case 'login':
    case 'register':
    case 'logout':
        require 'controllers/auth.php';
        break;

    case in_array($url, $allowedViews):
        if (file_exists("views/$url.php")) {
            include "views/$url.php";
        } else {
            include "views/404.php";
        }
        break;

    default:
        http_response_code(404);
        include 'views/404.php';
        break;
}
?>
