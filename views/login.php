<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - ThriftHub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/img/OIP.webp">

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.auth.css">

</head>
<body>


<div class="register-container">
  <div class="register-card">
    <!-- LEFT -->
    <div class="register-left">
      <i class="bi bi-shop-window"></i>
      <h4><b>Selamat Datang Kembali</b></h4>
      <p>Untuk tetap terhubung, silakan masuk dengan akun Anda</p>      
    </div>

  <!-- Right Panel -->
  <div class="register-right">
    <h2><i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke ThriftHub</h2>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'login_required'): ?>
      <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Anda harus login terlebih dahulu.
      </div>
    <?php endif; ?>

    <form action="index.php?url=login" method="POST">
      <div class="form-group">
        <input name="email" type="email" class="form-control" placeholder=" " required>
        <label>Email</label>
        <i class="bi bi-envelope-fill"></i>
      </div>
      <div class="form-group">
        <input name="password" type="password" class="form-control" placeholder=" " required>
        <label>Password</label>
        <i class="bi bi-lock-fill"></i>
      </div>
      <button type="submit" class="btn-login mt-2">LOGIN</button>
    </form>

    <p class="text-small">Belum punya akun? <a href="index.php?url=register">Daftar di sini</a></p>
  </div>
</div>

</body>
</html>
