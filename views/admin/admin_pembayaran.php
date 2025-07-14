<?php
$title="Cek Pembayaran Manual - Admin ThriftHub";
ob_start();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'config/database.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='admin') header("Location: ../index.php?url=login");

$sql="SELECT id,order_id,nama,metode,total,status_pembayaran FROM pesanan ORDER BY tanggal DESC";
$res=$conn->query($sql);
?>
<div class="container py-5">
  <h2 class="fw-bold text-center mb-4" style="color:#85005A">
    <i class="bi bi-credit-card-fill me-2"></i>Cek Pembayaran Manual
  </h2>
  <?php if($res->num_rows): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center shadow-sm">
        <thead class="table-light"><tr>
          <th>ID</th><th>Order ID</th><th>Nama</th><th>Metode</th><th>Total</th><th>Status</th><th>Aksi</th>
        </tr></thead><tbody>
        <?php while($r=$res->fetch_assoc()): ?>
          <tr>
            <td><?=$r['id']?></td>
            <td><?=$r['order_id']?></td>
            <td><?=htmlspecialchars($r['nama'])?></td>
            <td><?=$r['metode']?></td>
            <td>Rp<?=number_format($r['total'],0,',','.')?></td>
            <td><span class="badge bg-<?=( $r['status_pembayaran']==='Pembayaran Diterima'?'success':'warning')?>"><?=$r['status_pembayaran']?></span></td>
            <td>
              <?php if($r['status_pembayaran']!=='Pembayaran Diterima'): ?>
                <form method="POST" action="controllers/admin_update_bayar.php">
                  <input type="hidden" name="pesanan_id" value="<?=$r['id']?>">
                  <button class="btn btn-sm btn-primary">Tandai Dibayar</button>
                </form>
              <?php else: ?>
                <span class="text-success">✔️</span>
              <?php endif;?>
            </td>
          </tr>
        <?php endwhile;?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center">Belum ada pesanan</p>
  <?php endif;?>
</div>
<?php
$content=ob_get_clean();
include __DIR__ . '/../layouts/admin_layout.php';
?>
