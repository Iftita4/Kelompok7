<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($title)) $title = "Admin - ThriftHub";
if (!isset($content)) $content = "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($title) ?></title>

<!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/img/OIP.webp">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
    }

    .admin-wrapper {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #ffffff;
      border-right: 1px solid #eee;
      box-shadow: 2px 0 5px rgba(0,0,0,0.05);
      font-size: 0.95rem;
      position: sticky;
      top: 0;
      z-index: 1040;
    }

    .sidebar-header {
      background-color: #fff0f6;
      color: #85005A;
      padding: 1rem 1.5rem;
      font-weight: bold;
      font-size: 1.2rem;
    }

    .sidebar a {
      display: block;
      padding: 10px 20px;
      color: #333;
      text-decoration: none;
      border-radius: 8px;
      margin: 4px 12px;
      transition: 0.2s;
    }

    .sidebar a.active {
      background-color: #85005A;
      color: white;
      font-weight: bold;
    }

    .sidebar a:hover {
      background-color: #f7e9f3;
    }

    .main-content {
      flex: 1;
      padding: 30px;
    }

    /* Responsive sidebar */
    @media (max-width: 768px) {
      .sidebar {
        display: none;
        position: fixed;
        height: 100%;
        width: 250px;
        top: 0;
        left: 0;
        background-color: #ffffff;
        z-index: 1050;
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
      }

      .sidebar.show {
        display: block;
        transform: translateX(0);
      }

      #sidebar-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1049;
      }

      #sidebar-overlay.active {
        display: block;
      }

      .sidebar-toggle-btn {
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1060;
        background-color: #fff;
        border: 1px solid #ddd;
      }
    }
  </style>
</head>
<body>

<div class="admin-wrapper">
  <!-- Sidebar -->
  <div class="sidebar d-md-block" id="adminSidebar">
    <div class="sidebar-header">
      <i class="bi bi-shield-lock-fill me-2"></i> Admin Panel
    </div>
    <?php
    $active = $_GET['url'] ?? '';
    $menus = [
      'admin_dashboard' => ['icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
      'admin_produk'    => ['icon' => 'bi-box-seam', 'label' => 'Produk'],
      'admin_user'      => ['icon' => 'bi-people', 'label' => 'Pengguna'],
      'admin_transaksi' => ['icon' => 'bi-receipt', 'label' => 'Transaksi'],
      'admin_tracking'  => ['icon' => 'bi-truck', 'label' => 'Pengiriman'],
      'admin_pembayaran'=> ['icon' => 'bi-wallet2', 'label' => 'Pembayaran'],
    ];
    foreach ($menus as $url => $item):
      $isActive = ($active === $url);
    ?>
      <a href="index.php?url=<?= $url ?>" class="<?= $isActive ? 'active' : '' ?>">
        <i class="bi <?= $item['icon'] ?> me-2"></i> <?= $item['label'] ?>
      </a>
    <?php endforeach; ?>
    <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class="text-danger mt-3">
      <i class="bi bi-box-arrow-right me-2"></i> Logout
    </a>
  </div>

  <!-- Overlay for mobile -->
  <div id="sidebar-overlay" onclick="toggleSidebar()"></div>

  <!-- Sidebar toggle button -->
  <button onclick="toggleSidebar()" class="btn sidebar-toggle-btn d-md-none">
    <i class="bi bi-list"></i>
  </button>

  <!-- Main content -->
  <div class="main-content">
    <?= $content ?>
  </div>
</div>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-box-arrow-right me-2"></i>Konfirmasi Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center">
        Apakah Anda yakin ingin keluar dari panel admin?
      </div>
      <div class="modal-footer">
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('show');
    overlay.classList.toggle('active');
  }
</script>
</body>
</html>
