<?php
require_once __DIR__ . '/../core/Database.php';

// Đặt múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Khởi tạo biến để lưu thông báo
$error_message = '';
$success_message = '';

// Kiểm tra token từ POST
if (isset($_POST['token'])) {
    $token = $_POST['token'];
} else {
    $token = null;
    $error_message = "Vui lòng nhập token từ email để đặt lại mật khẩu.";
}

// Xử lý khi có token
if (!empty($token)) {
    // Kiểm tra token trong database bằng prepared statement
    $sql = "SELECT * FROM tai_khoan WHERE reset_token = ? AND token_expiries > NOW()";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $kq = mysqli_stmt_get_result($stmt);

    if ($kq === false) {
        $error_message = "Lỗi truy vấn SQL: " . mysqli_error($conn);
    } else {
        $user = mysqli_fetch_array($kq);

        if ($user) {
            // Token hợp lệ, xử lý form đặt lại mật khẩu
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Kiểm tra mật khẩu và mật khẩu nhập lại
                if ($password !== $confirm_password) {
                    $error_message = "Mật khẩu không khớp, vui lòng nhập lại!";
                } else {
                    // Mã hóa mật khẩu mới bằng md5 và cập nhật vào database
                    $new_password = md5($password);
                    $update_sql = "UPDATE tai_khoan SET mat_khau = ?, reset_token = NULL, token_expiries = NULL WHERE reset_token = ?";
                    $update_stmt = mysqli_prepare($conn, $update_sql);
                    mysqli_stmt_bind_param($update_stmt, "ss", $new_password, $token);
                    if (mysqli_stmt_execute($update_stmt)) {
                        $success_message = "Cập nhật mật khẩu thành công!";
                    } else {
                        $error_message = "Không thể cập nhật mật khẩu: " . mysqli_error($conn);
                    }
                }
            }
        } else {
            // Kiểm tra lý do token không hợp lệ
            $check_token_sql = "SELECT * FROM tai_khoan WHERE reset_token = ?";
            $check_stmt = mysqli_prepare($conn, $check_token_sql);
            mysqli_stmt_bind_param($check_stmt, "s", $token);
            mysqli_stmt_execute($check_stmt);
            $check_token_result = mysqli_stmt_get_result($check_stmt);
            if ($check_token_result && mysqli_num_rows($check_token_result) > 0) {
                $error_message = "Token đã hết hạn! Vui lòng yêu cầu khôi phục mật khẩu mới.";
            } else {
                $error_message = "Token không hợp lệ! Vui lòng kiểm tra lại token.";
            }
        }
    }
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
                        <?php if (empty($user) && empty($success_message)) { ?>
                            <!-- Biểu mẫu nhập token nếu không có token -->
                            <div class="form-group">
                                <ion-icon name="key-outline"></ion-icon>
                                <input type="text" id="token" name="token" placeholder="Nhập token từ email" required>
                            </div>
                            <button type="submit">Kiểm tra token</button>
                        <?php } elseif (isset($user) && empty($success_message)) { ?>
                            <!-- Biểu mẫu đặt lại mật khẩu nếu token hợp lệ -->
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
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