<?php
$title = "Tambah Produk - ThriftHub";
ob_start();
?>

<div class="container py-5">
  <h2 class="fw-bold text-center mb-4" style="color: #85005A;">Tambah Produk</h2>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow p-4 border-0">
        <form action="index.php?url=save_product" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
          </div>
          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" id="kategori" class="form-select" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="Kemeja">Kemeja</option>
              <option value="Celana">Celana</option>
              <option value="Jaket">Jaket</option>
              <option value="Sepatu">Sepatu</option>
              <option value="Tas">Tas</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" id="harga" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" name="gambar" id="gambar" required>
          </div>
          <button type="submit" class="btn w-100" style="background-color: #FF2DF1; color: white;">Simpan Produk</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>
