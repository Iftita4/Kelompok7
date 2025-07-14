<?php
include 'config/database.php'; // pastikan koneksi DB sudah benar

$nama = htmlspecialchars($_POST['nama']);
$pesan = htmlspecialchars($_POST['pesan']);

// Upload foto jika ada
$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
  $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
  $filename = 'foto_' . time() . '.' . $ext;
  move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $filename);
  $foto = 'uploads/' . $filename;
}

$query = "INSERT INTO testimoni (nama, pesan, foto) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $nama, $pesan, $foto);
$stmt->execute();

echo "<script>alert('Testimoni berhasil dikirim!'); window.location='home.php';</script>";
