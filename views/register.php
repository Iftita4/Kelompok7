<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - ThriftHub</title>

<!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/img/OIP.webp">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.auth.css">

</head>
<body>

<div class="register-container">
  <div class="register-card">
    <!-- LEFT -->
    <div class="register-left">
      <i class="bi bi-shop-window"></i>
      <h2>Selamat Datang!</h2>
      <p>Gabung dan temukan fashion terbaikmu di <b>ThriftHub</b>!</p>      
      <a href="index.php?url=login">LOGIN</a>
    </div>

    <!-- RIGHT -->
    <div class="register-right">
      <h2><i class="bi bi-person-plus-fill me-1"></i> Buat Akun</h2>
   
      <form action="index.php?url=register" method="POST">
        <div class="form-group">
          <input name="name" type="text" class="form-control" placeholder=" " required>
          <label>Nama</label>
          <i class="bi bi-person-fill"></i>
        </div>
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
        <button type="submit" class="btn-sign mt-2">REGISTER</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
