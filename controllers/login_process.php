<?php
session_start();
$_SESSION['message'] = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tk'])) {
    require_once __DIR__ . '/../core/Database.php'; 

    $tendn = $_POST['tk'];
    $matk = md5($_POST['pass']);

    // Trường hợp admin mặc định
    if ($_POST['pass'] === 'admin' && $_POST['tk'] === 'admin') {
        header("Location:../index.php?page=homeAdmin");
        exit();
    }

    //tạo câu truy vấn kiểm tra tài khoản
    $sql = "SELECT id, ten_tai_khoan, vai_tro FROM tai_khoan WHERE ten_tai_khoan = ? AND mat_khau = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $tendn, $matk);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        $userId = $user['id'];
        $role = $user['vai_tro'];
 
        //câu lệnh truy vấn lây tên của tài khoản
        $sql2 = "SELECT ho_ten FROM thong_tin WHERE id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        
        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, "s", $userId);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);
            $row2 = mysqli_fetch_assoc($result2);
            $hoten = $row2['ho_ten'] ?? '';
            mysqli_stmt_close($stmt2);
        } else {
            $hoten = '';
        }

        $_SESSION['user'] = $tendn;
        $_SESSION['user_id'] = $userId;
        $_SESSION['ho_ten'] = $hoten;     
        $_SESSION['role'] = $role;
        // $_SESSION['login_success'] = true;

        $remember = isset($_POST['rememberMe']); // checkbox

        if ($remember) {
        setcookie('username', $tendn, time() + (86400 * 30),"/"); // 30 ngày
        setcookie('password', $_POST['pass'], time() + (86400 * 30),"/"); 
        } else {
        // Xóa cookie nếu không muốn nhớ
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
        }

        header("Location:../views/homeAfterLogin.php");
        exit();
    } else {
        $_SESSION['message'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
        header("Location: ../views/dangnhap.php");
        exit();
    }

    mysqli_stmt_close($stmt);
}
?>
