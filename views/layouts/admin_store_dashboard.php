<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$active = $_GET['url'] ?? '';
$title = $title ?? 'Admin Toko - ThriftHub';
$content = $content ?? '';

// Ambil nama toko dari session atau database
if (!isset($_SESSION['user']['nama_toko'])) {
  include __DIR__ . '/../../config/database.php';
  $user_id = $_SESSION['user']['id'];
  $stmt = $conn->prepare("SELECT nama_toko FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $_SESSION['user']['nama_toko'] = $result['nama_toko'] ?? 'Admin Toko';
}
$nama_toko = htmlspecialchars($_SESSION['user']['nama_toko']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>

<!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/img/OIP.webp">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .wrapper {
      display: flex;
      min-height: 100vh;
    }
    #sidebar {
      width: 250px;
      background: #fff;
      border-right: 1px solid #dee2e6;
    }
    #sidebar .sidebar-heading {
      font-size: 1.2rem;
      padding: 1rem;
      color: #85005A;
      font-weight: bold;
      border-bottom: 1px solid #ddd;
    }
    #sidebar .nav-link {
      color: #333;
      padding: 0.75rem 1rem;
    }
    #sidebar .nav-link.active {
      background: #85005A;
      color: #fff;
    }
    #sidebar .nav-link:hover {
      background: #f1e9f9;
    }
    .content-area {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .main-content {
      flex: 1;
      padding: 2rem;
    }
    footer {
      margin-top: auto;
    }
    @media (max-width: 768px) {
      #sidebar {
        position: fixed;
        height: 100%;
        z-index: 1030;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
      }
      #sidebar.show {
        transform: translateX(0);
      }
      .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1029;
      }
      .overlay.show {
        display: block;
      }
    }
  </style>
</head>
<body>

<div class="wrapper">
  <!-- Sidebar -->
  <div id="sidebar">
    <div class="sidebar-heading text-center">
      <i class="bi bi-shop-window me-2"></i><?= $nama_toko ?>
    </div>
    <ul class="nav flex-column">
      <?php
      function sbLink($url, $icon, $label) {
        global $active;
        $act = ($active === $url) ? 'active' : '';
        echo "<li><a href=\"index.php?url=$url\" class=\"nav-link $act\"><i class=\"$icon me-2\"></i> $label</a></li>";
      }
      sbLink('admin_store_dashboard', 'bi bi-speedometer2', 'Dashboard');
      sbLink('my_products', 'bi bi-box-seam', 'Produk Saya');
      sbLink('add_product', 'bi bi-plus-circle', 'Tambah Produk');
      sbLink('store_orders', 'bi bi-list-check', 'Pesanan Masuk');
      sbLink('store_shipping', 'bi bi-truck', 'Pengiriman');
      sbLink('store_settings', 'bi bi-gear', 'Pengaturan Toko');
      ?>
      <li class="mt-3">
        <a href="#" class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
      </li>
    </ul>
  </div>

  <!-- Overlay for Mobile -->
  <div class="overlay" id="sidebarOverlay"></div>

  <!-- Main Area -->
  <div class="content-area">
    <!-- Topbar -->
    <nav class="navbar navbar-light bg-white shadow-sm px-3 sticky-top">
      <div class="container-fluid">
        <button class="btn btn-outline-secondary d-md-none" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <span class="navbar-text fw-bold"><?= $title ?></span>
      </div>
    </nav>

    <!-- Content -->
    <div class="main-content">
      <?= $content ?>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
  </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-box-arrow-right me-2"></i>Logout</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Yakin ingin logout?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="index.php?url=logout" class="btn btn-danger">Ya, Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');

  document.getElementById('toggleSidebar').addEventListener('click', () => {
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
  });

  overlay.addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  });
</script>
</body>
</html>
