<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Hệ Thống Thi Trắc Nghiệm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style/css/homepage.css">
    <link rel="shortcut icon" href="icon/favicon.ico" type="image/x-icon">
    <style>
        .user-name {
            font-size: 18px;
            color: #ffe600;
            font-weight: bold;
            padding-left: 250px;
        }
    </style>
</head>
<body>
<header>
        <div class="logo-container">
            <a href="../views/homeAfterLogin.php">
                <img src="../style/img/image.png" alt="Logo Trang Web" class="logo">
            </a>
            <h1>Hệ Thống Thi Trắc Nghiệm Online</h1>
        </div>
        <?php if (isset($_SESSION['ho_ten'])): ?>
        <div class="user-name">
            Chào mừng: <?php echo htmlspecialchars($_SESSION['ho_ten']); ?>
        </div>
        <?php endif; ?>
        <div class="user-menu">
            <i class="fa-solid fa-user"></i>
            <div class="dropdown" id="userDropdown">
                <a href="../index.php?page=exam" id="loginOption">Vào thi</a>
                <a href="../index.php?page=reviewList" id="loginOption">Xem lại</a>
                <a href="../controllers/Logout.php" id="registerOption">Đăng xuất</a>
            </div>
        </div>
    </header>
</body>