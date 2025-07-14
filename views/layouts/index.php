<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'ThriftHub'; ?></title>

    <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/img/OIP.webp">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background-color: #fffafc; font-family: 'Segoe UI', sans-serif;">

<?php $role = $_SESSION['user']['role'] ?? null; ?>

 
<?php include 'header.php'; ?>
  <main>
    <?= $content ?>
  </main>

<?php include 'footer.php'; ?>


<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/script.js"></script>
<script>
  // Efek sticky + shadow navbar saat scroll
  window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 50) {
      navbar.classList.add("shadow");
    } else {
      navbar.classList.remove("shadow");
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init();
</script>
<script>
  const testimonialCarousel = document.querySelector('#testimonialCarousel');
  const carousel = new bootstrap.Carousel(testimonialCarousel, {
    interval: 5000, // 5 detik
    ride: 'carousel',
    pause: false,
    wrap: true
  });
</script>
<script>
  const heroCarousel = document.getElementById('heroCarousel');

  heroCarousel.addEventListener('slide.bs.carousel', function () {
    // Reset animasi saat slide berpindah
   document.querySelectorAll('.animate-icon').forEach(icon => {
    icon.style.animation = 'none';
    icon.offsetHeight; // Force reflow
    icon.style.animation = '';
  });
  });
</script>
<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel"><i class="bi bi-box-arrow-right me-2"></i> Konfirmasi Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
        <a href="index.php?url=logout" class="btn btn-danger rounded-pill">Ya, Logout</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>


