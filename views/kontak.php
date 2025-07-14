<?php 
$title = "Kontak - ThriftHub";
ob_start();
?>

<section class="py-5" style="background-color: #fff6fb;">
  <div class="container">
    <h2 class="text-center fw-bold mb-5" style="color: #BF2EF0;" data-aos="fade-up">Hubungi Kami</h2>
    <div class="row g-4 align-items-start">

      <!-- Form Kontak -->
      <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
        <div class="p-4 rounded shadow" style="background: white; border-left: 5px solid #BF2EF0;">
          <form action="#" method="POST">
            <div class="mb-3">
              <label class="form-label text-muted">Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama Anda" required>
            </div>
            <div class="mb-3">
              <label class="form-label text-muted">Email</label>
              <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>
            <div class="mb-3">
              <label class="form-label text-muted">Pesan</label>
              <textarea name="pesan" class="form-control" rows="5" placeholder="Tulis pesan Anda..." required></textarea>
            </div>
            <button type="submit" class="btn w-100" style="background-color: #BF2EF0; color: white;">
              <i class="bi bi-send-fill me-1"></i> Kirim Pesan
            </button>
          </form>
        </div>
      </div>

      <!-- Info Kontak -->
      <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
        <div class="p-4 rounded shadow" style="background: #f9f2ff;">
          <h5 class="fw-bold mb-3 text-dark">Informasi Kontak</h5>
          <p><i class="bi bi-geo-alt-fill me-2" style="color: #BF2EF0;"></i> Jl. Preloved Fashion No. 123, Jakarta</p>
          <p><i class="bi bi-telephone-fill me-2" style="color: #BF2EF0;"></i> +62 812 3456 7890</p>
          <p><i class="bi bi-envelope-fill me-2" style="color: #BF2EF0;"></i> support@thrifthub.id</p>

          <h6 class="fw-bold mt-4 text-dark">Ikuti Kami</h6>
          <div class="d-flex gap-3 fs-4 mt-2">
            <a href="#" class="text-decoration-none" style="color: #BF2EF0;"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-decoration-none" style="color: #BF2EF0;"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-decoration-none" style="color: #BF2EF0;"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="text-decoration-none" style="color: #BF2EF0;"><i class="bi bi-tiktok"></i></a>
          </div>
        </div>
      </div>

    </div>

    <!-- Google Maps Embed -->
    <div class="row mt-5" data-aos="fade-up" data-aos-delay="300">
      <div class="col-12">
        <div class="ratio ratio-16x9 rounded shadow overflow-hidden">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.7251608325128!2d106.8271533!3d-6.175394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e52f3924b3%3A0x5edb5b93553e650e!2sMonas%2C%20Jakarta!5e0!3m2!1sen!2sid!4v1718980000000!5m2!1sen!2sid"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>

  </div>
</section>

<?php
$content = ob_get_clean();
include 'layouts/index.php';
?>
