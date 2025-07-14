<?php
$title = "Beranda - ThriftHub";
ob_start();

?>

<!-- Hero Banner Fullscreen Gen Z Style -->
<section class="vh-100 w-100 d-flex align-items-center text-white m-0 p-0" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('assets/img/banner-thrift.jpg') no-repeat center center / cover;">
  <div class="w-100 text-center px-3">
    <div class="mx-auto" style="max-width: 800px;">
      <h1 class="fw-bold display-4 mb-3 animate__animated animate__fadeInDown">Saatnya Lemari Kamu <span class="text-warning">Naik Kelas</span></h1>
      <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">Yuk preloved-in baju lama atau temukan style baru yang bikin kamu makin glow up ✨</p>
      <a href="index.php?url=category" class="btn btn-lg btn-warning px-4 py-2 rounded-pill animate__animated animate__fadeInUp animate__delay-2s">
        <i class="bi bi-bag-heart-fill me-1"></i> Belanja Sekarang
      </a>
    </div>
  </div>
</section>



<!-- Produk Terbaru -->
<section class="container my-5">
  <h2 class="text-center fw-bold mb-4"  style="color: #85005A;">🌟 Produk Terbaru</h2>

  <?php
  include_once 'config/database.php';
$produk = $conn->query("
  SELECT produk.*, users.nama_toko 
  FROM produk 
  JOIN users ON produk.user_id = users.id 
  ORDER BY produk.id DESC 
  LIMIT 6
");

  ?>

  <div class="row g-4">
    <?php if ($produk && $produk->num_rows > 0): ?>
      <?php while ($p = $produk->fetch_assoc()): ?>
      <div class="col-md-4 fade-in-up delay-2">
        <div class="card h-100 border-0 shadow-sm">
          <img src="<?= htmlspecialchars($p['gambar']); ?>" class="card-img-top" style="height: 250px; object-fit: cover;" alt="<?= htmlspecialchars($p['nama']); ?>">
          <div class="card-body d-flex flex-column">
            <div class="mb-3">
              <span class="d-inline-block px-3 py-2 rounded-pill text-white fw-semibold" style="background-color: #85005A;">
                <i class="bi bi-shop me-2"></i> 
                <a href="index.php?url=store&id=<?= $p['user_id'] ?>" 
                  class="text-white text-decoration-none"
                  onmouseover="this.style.textDecoration='underline';"
                  onmouseout="this.style.textDecoration='none';">
                  <?= htmlspecialchars($p['nama_toko'] ?? 'Toko Tidak Diketahui'); ?>
                </a>
              </span>
            </div>
            <h5 class="card-title"><?= htmlspecialchars($p['nama']); ?></h5>
            <p class="text-danger fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></p>
            <a href="index.php?url=product_detail&id=<?= $p['id']; ?>" class="btn btn-outline-primary mt-auto">
              <i class="bi bi-eye-fill"></i> Lihat Detail
            </a>
          </div>
        </div>
      </div>

      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info text-center">Belum ada produk yang ditambahkan.</div>
      </div>
    <?php endif; ?>
  </div>

<!-- CTA Lihat Semua Produk -->
<div class="text-center mt-5">
  <a href="index.php?url=category" class="btn btn-lg px-5 py-2 rounded-pill text-dark" 
     style="background-color: #FFC107; border: none;"
     onmouseover="this.style.backgroundColor='#FFD95B';"
     onmouseout="this.style.backgroundColor='#FFC107';">
    <i class="bi bi-grid-fill me-2"></i> Lihat Semua Produk
  </a>
</div>

</section>

<!-- Fitur Menarik -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h3 class="fw-bold text-dark" >✨ Fitur Unggulan Kami</h3>
      <p class="text-muted">Kami menghadirkan kemudahan dan kenyamanan bertransaksi fashion preloved.</p>
    </div>
    <div class="row text-center g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="p-4 shadow-sm rounded bg-light h-100">
          <i class="bi bi-shield-lock fs-1 text-primary"></i>
          <h5 class="fw-bold mt-3">Transaksi Aman</h5>
          <p class="text-muted">Sistem keamanan terintegrasi untuk melindungi pembeli dan penjual.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="p-4 shadow-sm rounded bg-light h-100">
          <i class="bi bi-ui-checks fs-1 text-success"></i>
          <h5 class="fw-bold mt-3">Proses Mudah</h5>
          <p class="text-muted">Tampilan antarmuka sederhana untuk upload dan belanja produk thrift.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="p-4 shadow-sm rounded bg-light h-100">
          <i class="bi bi-globe2 fs-1 text-warning"></i>
          <h5 class="fw-bold mt-3">Jangkauan Luas</h5>
          <p class="text-muted">Jual beli dapat dilakukan antar kota dengan sistem pengiriman terpercaya.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimoni Pengguna -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-4" data-aos="fade-up">
      <h3 class="fw-bold text-dark">💬 Apa Kata Mereka?</h3>
      <p class="text-muted">Pendapat pengguna yang telah merasakan kemudahan berbelanja di ThriftHub</p>
    </div>

    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <?php
      $sql = "SELECT * FROM testimoni ORDER BY created_at DESC LIMIT 10";
      $result = $conn->query($sql);
      $index = 0;
      ?>
      <div class="carousel-inner">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
            <div class="d-flex flex-column align-items-center bg-white p-4 rounded shadow-sm mx-auto" style="max-width: 600px;" data-aos="zoom-in">  
              <h6 class="fw-bold"><?= htmlspecialchars($row['nama']); ?></h6>
              <p class="text-muted fst-italic text-center px-2">“<?= htmlspecialchars($row['pesan']); ?>”</p>
            </div>
          </div>
        <?php $index++; endwhile; ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>

<!-- Form Tambah Testimoni -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-4" data-aos="fade-up">
      <h4 class="fw-bold">💡 Bagikan Pengalamanmu</h4>
      <p class="text-muted">Kami ingin tahu pendapat kamu tentang ThriftHub!</p>
    </div>
    <form action="index.php?url=submit_testimoni" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
      <div class="mb-3">
        <input type="text" name="nama" class="form-control" placeholder="Nama Kamu" required>
      </div>
      <div class="mb-3">
        <textarea name="pesan" class="form-control" rows="4" placeholder="Tulis testimoni kamu..." required></textarea>
      </div>
     <button type="submit" class="btn px-4 rounded-pill text-white"
  style="background-color: #85005A; border: none;"
  onmouseover="this.style.backgroundColor='#A23E7D';"
  onmouseout="this.style.backgroundColor='#85005A';">
  Kirim Testimoni
</button>

    </form>
  </div>
</section>

<?php
$content = ob_get_clean();
include 'layouts/index.php';
?>
