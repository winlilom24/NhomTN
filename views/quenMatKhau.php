<?php
require __DIR__ . '/../site.php';
load_header();
require_once __DIR__ . '/../core/Database.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
require 'mailAdminAcount.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    
    // Kiểm tra email có tồn tại không (dùng prepared statements)
    $sql = "SELECT * FROM tai_khoan WHERE ten_tai_khoan = ? AND email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss",$username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Cập nhật token
        $update = $conn->prepare("UPDATE tai_khoan SET reset_token = ?, token_expiries = ? WHERE ten_tai_khoan = ? AND email = ?");
        $update->bind_param("ssss", $token, $expiry,$username, $email);
        $update->execute();

        // Link reset
    //    $reset_link = "http://localhost/Nhom=TN2/views/reset_password.php?token=$token";
        $reset_link = "http://localhost/NhomTN/views/reset_password.php";
        // Gửi mail
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $mailUser;
            $mail->Password = $mailPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom($mailUser, 'Hệ thống trắc nghiệm');
            $mail->addAddress($email);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = 'Khôi phục mật khẩu';
            $mail->Body = "Chào bạn,<br><br>Để đặt lại mật khẩu, vui lòng truy cập liên kết sau: <a href='$reset_link'>$reset_link</a><br><br>Sử dụng mã token sau trong trang đặt lại mật khẩu:<br><strong>$token</strong><br><br>Mã token này có hiệu lực trong 1 giờ.<br>Trân trọng,<br>Hệ thống đăng nhập";
            $mail->AltBody = "Chào bạn,\n\nĐể đặt lại mật khẩu, vui lòng truy cập: $reset_link\n\nSử dụng mã token sau: $token\n\nMã token này có hiệu lực trong 1 giờ.\nTrân trọng,\nHệ thống đăng nhập";

            $mail->send();
            $message = "<span style='color:green;'>Link khôi phục đã được gửi tới gmail của bạn!</span>";
        } catch (Exception $e) {
            $message = "<span style='color:red;'>Không thể gửi email. Lỗi: {$mail->ErrorInfo}</span>";
            // Xóa token nếu gửi email thất bại
            mysqli_query($conn, "UPDATE tai_khoan SET reset_token = NULL, token_expiries = NULL WHERE ten_tai_khoan = '$username' AND email = '$email'");
        }
    } else {
        $message = "<span style='color:red;'>Email không tồn tại trong hệ thống!</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên Mật Khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="../style/css/DangNhap.css">
</head>
<body>
    <section>
        <div class="main">
            <div class="form-box">
                <div class="form-value">
                    <form id="forgot-password" method="POST">
                        <h1 class="form-heading">Quên mật khẩu</h1>
                         <div class="form-group">
                            <ion-icon name="person-circle-outline"></ion-icon>
                            <input type="text" id="username" name="username" placeholder="Tên tài khoản" required>
                        </div>
                        <div class="form-group">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
                        </div>
                        <button type="submit">Gửi yêu cầu</button>
                        <div class="register-link">
                            <p>Quay lại? <a href="dangNhap.php">Đăng nhập</a></p>
                        </div>
                        <p id="message"><?= $message ?></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
