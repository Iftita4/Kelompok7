<?php
$title = "Kelola Pengguna - Admin";
include 'middlewares/admin_only.php';
include 'config/database.php';
ob_start();

$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<div class="container py-5">
  <h2 class="fw-bold mb-4" style="color: #85005A;"><i class="bi bi-people-fill me-2"></i> Kelola Pengguna</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark text-center">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($user = $users->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['role'] == 'admin' ? '<span class="badge bg-danger">Admin</span>' : '<span class="badge bg-secondary">User</span>' ?></td>
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
