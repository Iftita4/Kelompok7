<?php
$title = "Tentang Kami - ThriftHub";
ob_start();
?>

<div class="container py-5">

  <!-- Intro -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right" data-aos-delay="200">
      <img src="assets/img/desain tentang.png" alt="Tentang ThriftHub" class="img-fluid rounded-4 shadow-lg" width= "450px" height= "200px">
    </div>
    <div class="col-md-6" data-aos="fade-left" data-aos-delay="400">
      <h2 class="fw-bold mb-3" style="color:#85005A;">Tentang <span style="color:#BF2EF0;">ThriftHub</span></h2>
      <p class="text-muted fs-5">ThriftHub adalah platform e-commerce C2C yang menghadirkan pengalaman jual beli baju bekas (*preloved fashion*) secara mudah, aman, dan berkelanjutan. Kami memberdayakan individu untuk memberikan hidup kedua pada pakaian mereka, sekaligus memberikan solusi fashion hemat dan ramah lingkungan.</p>
      <a href="index.php?url=register" class="btn px-4 py-2 rounded-pill text-white shadow-sm" style="background-color:#85005A;">Gabung Sekarang</a>
    </div>
  </div>

  <!-- Visi Misi -->
  <div class="row text-center mb-5">
    <div class="col-md-6 mb-4 mb-md-0" data-aos="zoom-in-up" data-aos-delay="300">
      <div class="p-4 bg-white rounded-4 shadow-sm h-100 border-top border-4" style="border-color:#85005A;">
        <i class="bi bi-eye fs-1" style="color:#85005A;"></i>
        <h4 class="fw-bold mt-3" style="color:#85005A;">Visi</h4>
        <p class="text-muted">Menjadi platform thrift fashion terbaik di Indonesia yang memadukan gaya, keberlanjutan, dan komunitas.</p>
      </div>
    </div>
    <div class="col-md-6" data-aos="zoom-in-up" data-aos-delay="500">
      <div class="p-4 bg-white rounded-4 shadow-sm h-100 border-top border-4" style="border-color:#85005A;">
        <i class="bi bi-bullseye fs-1" style="color:#85005A;"></i>
        <h4 class="fw-bold mt-3" style="color:#85005A;">Misi</h4>
        <ul class="text-muted list-unstyled text-start mx-3">
          <li>✔ Menyediakan wadah jual beli fashion preloved yang terpercaya</li>
          <li>✔ Meningkatkan kesadaran akan fashion berkelanjutan</li>
          <li>✔ Memberdayakan komunitas anak muda & pelaku UMKM</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Tim Kami -->
  <div class="text-center mb-4" data-aos="fade-up" data-aos-delay="100">
    <h4 class="fw-bold" style="color:#85005A;">💼 Tim Kami</h4>
    <p class="text-muted">Orang-orang di balik layar yang membuat ThriftHub berjalan</p>
  </div>

  <?php
  $tim = [
    ['nama' => 'Farwa Salira', 'divisi' => '2204411901', 'foto' => 'farwa.jpg'],
    ['nama' => 'Annur', 'divisi' => '2204411914', 'foto' => 'annur.jpg'],
    ['nama' => 'Syaiful', 'divisi' => '2204411177', 'foto' => 'Syaiful.jpg'],
    ['nama' => 'Muh. Rifky', 'divisi' => '2204411481', 'foto' => 'rifky.jpg'],
    ['nama' => 'Tiara', 'divisi' => '2204411903', 'foto' => 'tiara.jpg'],
    ['nama' => 'Ismawati', 'divisi' => '2204411905', 'foto' => 'isma.jpg'],
  ];
  ?>

  <div class="row g-4 justify-content-center">
    <?php foreach ($tim as $i => $anggota): ?>
      <div class="col-md-4 col-lg-3 text-center" data-aos="zoom-in" data-aos-delay="<?= 100 + ($i * 100) ?>">
        <div class="p-3 bg-white rounded-4 shadow-sm h-100 border-top border-3" style="transition: all .3s; border-color:#85005A;">
          <img src="assets/img/team/<?= $anggota['foto'] ?>" class="rounded-circle shadow mb-3" alt="<?= $anggota['nama'] ?>" width="130" height="170" style="object-fit: cover;">
          <h6 class="fw-bold mb-1" style="color:#85005A;"><?= $anggota['nama'] ?></h6>
          <p class="text-muted small"><?= $anggota['divisi'] ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<?php
$content = ob_get_clean();
include 'layouts/index.php';
?>
