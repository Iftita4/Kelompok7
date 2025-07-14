<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY id DESC");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addProduct($nama, $deskripsi, $harga, $gambar, $user_id) {
        $stmt = $this->conn->prepare("INSERT INTO products (nama, deskripsi, harga, gambar, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $nama, $deskripsi, $harga, $gambar, $user_id);
        return $stmt->execute();
    }
}
