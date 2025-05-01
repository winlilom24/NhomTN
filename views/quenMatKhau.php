<?php
require __DIR__ . '/../site.php';
load_header();
require_once __DIR__ . '/../core/Database.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Thông tin cấu hình email tách riêng (bạn nên tạo file .env hoặc config riêng)
$mailUser = 'trananhvu1412@gmail.com';
$mailPass = 'aamf daop kwvb jmzu'; // Tốt nhất lưu file config bên ngoài public_html

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = Database::connect();
    $email = trim($_POST['email']);

    // Kiểm tra email có tồn tại không (dùng prepared statements)
    $stmt = $conn->prepare("SELECT * FROM tai_khoan WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($dong = $result->fetch_assoc()) {
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Cập nhật token
        $update = $conn->prepare("UPDATE tai_khoan SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $update->bind_param("sss", $token, $expiry, $email);
        $update->execute();

        // Link reset
        $reset_link = "http://localhost/duanDangNhap/reset_password.php?token=$token";

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

            $mail->setFrom($mailUser, 'Hệ thống đăng nhập');
            $mail->addAddress($email);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = 'Khôi phục mật khẩu';
            $mail->Body = "Chào bạn,<br><br>Nhấn vào liên kết sau để đặt lại mật khẩu của bạn: <a href='$reset_link'>$reset_link</a><br><br>Liên kết này có hiệu lực trong 1 giờ.<br>Trân trọng,<br>Hệ thống đăng nhập";
            $mail->AltBody = "Chào bạn,\n\nNhấn vào liên kết sau để đặt lại mật khẩu của bạn: $reset_link\n\nLiên kết này có hiệu lực trong 1 giờ.\nTrân trọng,\nHệ thống đăng nhập";

            $mail->send();
            $message = "<span style='color:green;'>Link khôi phục đã được gửi tới $email!</span>";
        } catch (Exception $e) {
            $message = "<span style='color:red;'>Không thể gửi email. Lỗi: {$mail->ErrorInfo}</span>";
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
