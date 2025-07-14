<?php
if ($url == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';


    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        if ($user['role'] === 'admin') {
            header("Location: index.php?url=admin_dashboard");
        } else {
            header("Location: index.php?url=dashboard");
        }
        exit;
    } else {
        echo "Login gagal";
    }
} elseif ($url == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = 'user';

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();

    header("Location: index.php?url=login");
    exit;
} elseif ($url == 'login') {
    require 'views/login.php';
} elseif ($url == 'register') {
    require 'views/register.php';
} elseif ($url == 'logout') {
    session_destroy();
    header("Location: index.php?url=login");
    exit;
}
?>
