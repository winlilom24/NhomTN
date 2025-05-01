<header>
        <div class="logo-container">
                <img src="style/img/image.png" alt="Logo Trang Web" class="logo">
            </a>
            <h1>Hệ Thống Thi Trắc Nghiệm Online</h1>
        </div>
        <?php if (isset($_SESSION['ho_ten'])): ?>
        <div class="user-name">
            Thí sinh: <?php echo htmlspecialchars($_SESSION['ho_ten']); ?>
        </div>
        <?php endif; ?>
        <div class="user-menu">
            <i class="fa-solid fa-user"></i>
        </div>
</header>
