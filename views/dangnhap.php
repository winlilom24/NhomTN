<?php
require __DIR__ . '/../site.php';
load_header();
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../style/css/DangNhap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<section>
    <div class="main">
        <div class="form-box">
            <div class="form-value">
                <form method="POST" id="form-dangnhap" action="../controllers/login_process.php">
                    <h1 style="font-size: 2em; color: rgb(36, 20, 20);  text-align: center;">Đăng nhập</h1>

                    <div class="form-group">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <input type="text" name="tk" placeholder="Tên đăng nhập" id="username" 
                            value="<?php echo isset($_COOKIE['username']) ? ($_COOKIE['username']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <ion-icon name="lock-closed"></ion-icon>
                        <input type="password" name="pass" placeholder="Mật khẩu" id="password" 
                            value="<?php echo isset($_COOKIE['password']) ? ($_COOKIE['password']) : ''; ?>" required>
                        <span class="toggle-password"><ion-icon name="eye"></ion-icon></span>
                    </div>

                    <div class="remember-forgot">
                        <label>
                            <input type="checkbox" id="rememberMe" name="rememberMe" 
                                <?php if (isset($_COOKIE['username'])) echo 'checked'; ?> >Nhớ mật khẩu
                        </label>
                        <a href="quenMatKhau.php">Quên mật khẩu?</a>
                    </div>

                    <button type="submit">Đăng nhập</button>

                    <div class="register-link">
                        <p>Bạn chưa có tài khoản? <a href="dangky.php">Tạo tài khoản</a></p>
                    </div>

                    <p id="message" style="color: red;"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?></p>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // function getCookie(name) {
    //     const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    //     return match ? match[2] : null;
    // }
    
    // function setCookie(name, value, days) {
    //     const date = new Date();
    //     date.setTime(date.getTime() + days * 864e5);
    //     document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/; Secure; SameSite=Strict`;
    // }

    $(document).ready(function() {
        $('.toggle-password').click(() => {
            const input = $('#password');
            const icon = $('.toggle-password ion-icon');
            const isText = input.attr('type') === 'text';
            input.attr('type', isText ? 'password' : 'text');
            icon.attr('name', isText ? 'eye' : 'eye-off');
        });        
    });
</script>
</body>
</html>
