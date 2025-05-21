<?php
require_once __DIR__ . '/../core/Database.php'; //lấy kết nối

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');

require __Dir__.'/../views/mailAdminAcount.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['signup'])) {
    //lấy dữ liệu từ form
    $username    = trim($_POST['user']);
    $hoten       = trim($_POST['tkf']);
    $password    = $_POST['mk'];
    $email       = trim($_POST['email']);
    $sodienthoai = trim($_POST['sdt']);
    $ngaysinh    = $_POST['ns'];
    $diachi      = trim($_POST['diachi']);
    $gioitinh    = $_POST['gender'];

    $user_id     = 'id_' . time() . '_' . random_int(1000, 9999); //tạo id mới ngẫu nhiên
    $md5Password = md5($password); //mã hóa mật khẩu

    // Kiểm tra tài khoản tồn tại
    $sql_check = "SELECT * FROM tai_khoan WHERE ten_tai_khoan = ?";
    $checkStmt = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($checkStmt, "s", $username);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        header("Location: ../views/dangky.php?message=exist"); //tải lại trang với mess là đã tồn tại
        exit;
    }
    mysqli_stmt_close($checkStmt);

    // Thêm vào bảng thong_tin
    $sql1 = "INSERT INTO thong_tin (id, ho_ten, ngay_sinh, sdt, dia_chi, gioi_tinh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $sql1);

    mysqli_stmt_bind_param($stmt1, "ssssss", $user_id, $hoten, $ngaysinh, $sodienthoai, $diachi, $gioitinh);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    // Thêm vào bảng tai_khoan
    $sql2 = "INSERT INTO tai_khoan (id, ten_tai_khoan, mat_khau, email) VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql2);
    
    mysqli_stmt_bind_param($stmt2, "ssss", $user_id, $username, $md5Password, $email);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

     // Gửi email thông báo đăng ký thành công
    $mail = new PHPMailer(true);
    try {
        // Cấu hình server SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $mailUser;
        $mail->Password = $mailPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Thiết lập người gửi và người nhận
        $mail->setFrom($mailUser, 'Hệ thống trắc nghiệm');
        $mail->addAddress($email, $hoten);
        $mail->CharSet = 'UTF-8';

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'Đăng ký tài khoản thành công';
        $mail->Body = "
            <h2>Chào $hoten,</h2>
            <p>Cảm ơn bạn đã đăng ký tài khoản!</p>
            <p><strong>Tên đăng nhập:</strong> $username</p>
            <p><strong>Email:</strong> $email</p>
            <p>Trân trọng</p>
        ";
        $mail->AltBody = "Chào $hoten,\n\nCảm ơn bạn đã đăng ký tài khoản!\nTên đăng nhập: $username\nEmail: $email\nTrân trọng,\nHệ thống đăng nhập";

        $mail->send();
    } catch (Exception $e) {
        // Ghi log lỗi nếu cần
        error_log("Failed to send email to $email: {$mail->ErrorInfo}");
    }

    //đóng kết nối
    mysqli_close($conn);
    header("Location: ../views/dangky.php?message=success"); //tải lại trang với mess là thành công
    exit;
}
?>
