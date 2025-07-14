<?php
$title = "Kelola Produk - Admin";
include 'middlewares/admin_only.php';
include 'config/database.php';
ob_start();

$produk = $conn->query("SELECT * FROM produk ORDER BY id DESC");
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4" style="color: #85005A;"><i class="bi bi-box-seam me-2"></i> Kelola Produk</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark text-center">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Penjual</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $produk->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td>
              <?php
              $user = $conn->query("SELECT name FROM users WHERE id = {$row['user_id']}")->fetch_assoc();
              echo htmlspecialchars($user['name'] ?? '-');
              ?>
            </td>
            <td><img src="<?= $row['gambar'] ?>" width="80"></td>
            <td class="text-center">
              
              <a href="index.php?url=hapus_produk&id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin_layout.php';
?>
