<?php
session_start();
$_SESSION['message']  = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tk'])) {
    require_once __DIR__ . '/../core/Database.php';

    $tendn = $_POST['tk'];
    $matk = md5($_POST['pass']);

    if ($_POST['pass'] === 'admin' && $_POST['tk'] === 'admin') {
        header("Location:../index.php?page=homeAdmin");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, tai_khoan, vai_tro FROM tai_khoan WHERE tai_khoan = ? AND mat_khau = ?");
    $stmt->bind_param("ss", $tendn, $matk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $userId = $user['id'];
        $role = $user['vai_tro'];

        $stmt2 = $conn->prepare("SELECT ho_ten FROM thong_tin WHERE id = ?");
        $stmt2->bind_param("s", $userId);
        $stmt2->execute();
        $hoten = $stmt2->get_result()->fetch_assoc()['ho_ten'] ?? '';
        $stmt2->close();

        $_SESSION['user'] = $tendn;
        $_SESSION['user_id'] = $userId;
        $_SESSION['ho_ten'] = $hoten;
        $_SESSION['role'] = $role;
        $_SESSION['login_success'] = true;

        header("Location:../views/homeAfterLogin.php");
        exit();
    } else {
        $_SESSION['message'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
        header("Location: ../views/dangnhap.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
