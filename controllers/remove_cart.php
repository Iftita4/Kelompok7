<?php
session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (isset($_SESSION['cart'][$id])) {
  unset($_SESSION['cart'][$id]);
}

header('Location: index.php?url=cart');
exit;
?>
