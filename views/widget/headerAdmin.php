<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Admin - Hệ Thống Thi Trắc Nghiệm</title>
    <link rel="stylesheet" href="../style/css/homeAdmin.css">   
    <link rel="shortcut icon" href="../style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="neon-background"></div>
    <header>
        <div class="logo-container">
            <a href="../index.php?page=homeAdmin">
                <img class="logo" src="../style/img/image.png" alt="Logo" >
            </a>
            <h1>Hệ Thống Thi Trắc Nghiệm Online - Admin</h1>
        </div>

        <div class="user-area">
            <div class="user-name">
                Chào mừng Admin
            </div>
            <div class="user-menu">
                <i class="fa-solid fa-user"></i>
                <div class="dropdown" id="userDropdown">
                    <a href="../controllers/Logout.php" id="registerOption">Đăng xuất</a>
                </div>
            </div>
        </div>
    </header>
</body>