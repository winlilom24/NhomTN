<header>
    <div class="logo-container">
        <a href="views/homeAfterLogin.php">
            <img src="style/img/image.png" alt="Logo Trang Web" class="logo">
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
                <a href="index.php?page=exam" id="loginOption">Vào thi</a>
                <a href="views/homeAfterLogin.php" id="loginOption">Quay lại</a>
                <a href="controllers/Logout.php" id="registerOption">Đăng xuất</a>
            </div>
        </div>
</header>