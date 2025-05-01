<?php
require_once __DIR__ . '/../core/Database.php';

if (isset($_POST['signup'])) {
    $username   = trim($_POST['user']);
    $hoten      = trim($_POST['tkf']);
    $password   = $_POST['mk'];
    $email      = trim($_POST['email']);
    $sodienthoai = trim($_POST['sdt']);
    $ngaysinh   = $_POST['ns'];
    $diachi     = trim($_POST['diachi']);
    $gioitinh   = $_POST['gender'];

    $user_id = 'id_' . time() . '_' . random_int(1000, 9999);
    $md5Password = md5($password);

    $checkStmt = $conn->prepare("SELECT * FROM tai_khoan WHERE tai_khoan = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        header("Location: ../views/dangky.php?message=exist");
        exit;
    }
    
    $stmt1 = $conn->prepare("INSERT INTO thong_tin (id, ho_ten, ngay_sinh, sdt, dia_chi, gioi_tinh)
                             VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssss", $user_id, $hoten, $ngaysinh, $sodienthoai, $diachi, $gioitinh);
    $stmt1->execute();

    $stmt2 = $conn->prepare("INSERT INTO tai_khoan (id, tai_khoan, mat_khau, email)
                             VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $user_id, $username, $md5Password, $email);
    $stmt2->execute();

    header("Location: ../views/dangky.php?message=success");
    exit;

    $stmt1->close();
    $stmt2->close();
    $checkStmt->close();
    $conn->close();
}
?>
