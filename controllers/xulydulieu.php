<?php
require_once __DIR__ . '/../core/Database.php'; // $conn được mysqli_connect()

if (isset($_POST['signup'])) {
    $username    = trim($_POST['user']);
    $hoten       = trim($_POST['tkf']);
    $password    = $_POST['mk'];
    $email       = trim($_POST['email']);
    $sodienthoai = trim($_POST['sdt']);
    $ngaysinh    = $_POST['ns'];
    $diachi      = trim($_POST['diachi']);
    $gioitinh    = $_POST['gender'];

    $user_id     = 'id_' . time() . '_' . random_int(1000, 9999);
    $md5Password = md5($password);

    // Kiểm tra tài khoản tồn tại
    $sql_check = "SELECT * FROM tai_khoan WHERE tai_khoan = ?";
    $checkStmt = mysqli_prepare($conn, $sql_check);

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "s", $username);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($checkResult) > 0) {
            header("Location: ../views/dangky.php?message=exist");
            exit;
        }
        mysqli_stmt_close($checkStmt);
    } else {
        die("Lỗi truy vấn kiểm tra!");
    }

    // Thêm vào bảng thong_tin
    $sql1 = "INSERT INTO thong_tin (id, ho_ten, ngay_sinh, sdt, dia_chi, gioi_tinh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $sql1);

    if ($stmt1) {
        mysqli_stmt_bind_param($stmt1, "ssssss", $user_id, $hoten, $ngaysinh, $sodienthoai, $diachi, $gioitinh);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
    } else {
        die("Lỗi khi chèn vào thong_tin!");
    }

    // Thêm vào bảng tai_khoan
    $sql2 = "INSERT INTO tai_khoan (id, tai_khoan, mat_khau, email) VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql2);

    if ($stmt2) {
        mysqli_stmt_bind_param($stmt2, "ssss", $user_id, $username, $md5Password, $email);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    } else {
        die("Lỗi khi chèn vào tai_khoan!");
    }

    mysqli_close($conn);
    header("Location: ../views/dangky.php?message=success");
    exit;
}
?>
