<?php
require_once __DIR__ . '/../core/Database.php';

// Đặt múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Khởi tạo biến để lưu thông báo
$error_message = '';
$success_message = '';

// Kiểm tra token từ URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Kiểm tra token trong database
    $sql = "SELECT * FROM tai_khoan WHERE reset_token = '$token' AND token_expiries > NOW()";
    $kq = mysqli_query($conn, $sql);

    // Kiểm tra lỗi truy vấn
    if ($kq === false) {
        $error_message = "Lỗi truy vấn SQL: " . mysqli_error($conn);
    } else {
        $user = mysqli_fetch_array($kq);

        if ($user) {
            // Token hợp lệ, xử lý form đặt lại mật khẩu
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Kiểm tra mật khẩu và mật khẩu nhập lại có khớp không
                if ($password !== $confirm_password) {
                    $error_message = "Mật khẩu không khớp, vui lòng nhập lại!";
                } else {
                    // Mã hóa mật khẩu mới và cập nhật vào database
                    $new_password = md5($password);
                    $update_sql = "UPDATE tai_khoan SET mat_khau = '$new_password', reset_token = NULL, token_expiries = NULL WHERE reset_token = '$token'";
                    if (mysqli_query($conn, $update_sql)) {
                        $success_message = "Cập nhật mật khẩu thành công!";
                    } else {
                        $error_message = "Không thể cập nhật mật khẩu: " . mysqli_error($conn);
                    }
                }
            }
        } else {
            // Kiểm tra lý do token không hợp lệ
            $check_token_sql = "SELECT * FROM tai_khoan WHERE reset_token = '$token'";
            $check_token_result = mysqli_query($conn, $check_token_sql);
            if ($check_token_result && mysqli_num_rows($check_token_result) > 0) {
                $error_message = "Token đã hết hạn! Vui lòng yêu cầu khôi phục mật khẩu mới.";
            } else {
                $error_message = "Token không hợp lệ! Token không tồn tại trong hệ thống.";
            }
        }
    }
} else {
    $error_message = "Không có token trong URL!";
}

// Hiển thị thông báo lỗi hoặc thành công
if ($error_message) {
    echo "<script>document.getElementById('message').style.color = 'red'; document.getElementById('message').innerText = '$error_message';</script>";
} elseif ($success_message) {
    echo "<script>document.getElementById('message').style.color = 'green'; document.getElementById('message').innerText = '$success_message';</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="../style/css/DangNhap.css">
</head>
<body>
    <section>
        <div class="main">
            <div class="form-box">
                <div class="form-value">
                    <form method="POST">
                        <h1 class="form-heading">Đặt lại mật khẩu</h1>
                        <?php if (isset($user) && empty($success_message)) { ?>
                            <div class="form-group">
                                <ion-icon name="lock-closed"></ion-icon>
                                <input type="password" id="password" name="password" placeholder="Mật khẩu mới" required>
                            </div>
                            <div class="form-group">
                                <ion-icon name="lock-closed"></ion-icon>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                            </div>
                            <button type="submit">Cập nhật</button>
                        <?php } ?>
                        <?php if ($success_message) { ?>
                            <p style="color: green; text-align: center;"><?php echo $success_message; ?></p>
                        <?php } elseif ($error_message) { ?>
                            <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
                        <?php } ?>
                        <div class="register-link">
                            <p>Quay lại? <a href="dangNhap.php">Đăng nhập</a></p>
                        </div>
                        <p id="message" style="color: red;"></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>