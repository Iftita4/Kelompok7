<?php
$title = "Edit Produk - ThriftHub";
ob_start();
include 'config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data produk berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
  echo "<div class='alert alert-danger'>Produk tidak ditemukan.</div>";
  exit;
}

// Proses update saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $harga = intval($_POST['harga']);
  $gambar = $produk['gambar']; // default lama

  // Jika upload gambar baru
  if ($_FILES['gambar']['name']) {
    $gambar = basename($_FILES['gambar']['name']);
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
  }

  $update = $conn->prepare("UPDATE produk SET nama = ?, kategori = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id = ?");
$update->bind_param("sssisi", $nama, $kategori, $deskripsi, $harga, $gambar, $id);
  $update->execute();

  header("Location: index.php?url=my_products&status=updated");
  exit;
}
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4" style="color: #85005A;">Edit Produk</h2>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Produk</label>
      <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($produk['nama']); ?>" required>
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
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
          </div>
    <div class="mb-3">
      <label for="harga" class="form-label">Harga</label>
      <input type="number" name="harga" id="harga" class="form-control" value="<?= $produk['harga']; ?>" required>
    </div>

    <div class="mb-3">
      <label for="gambar" class="form-label">Gambar Produk</label><br>
      <img src="uploads/<?= $produk['gambar']; ?>" width="120" class="mb-2 rounded"><br>
      <input type="file" name="gambar" id="gambar" class="form-control">
    </div>

    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Perubahan</button>
    <a href="index.php?url=my_products" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_store_dashboard.php';
?>
