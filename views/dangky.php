<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/css/main.css">
    <script src="../style/js/main.js" defer></script>
    <title> Form Register </title>
</head>
<body>
     <div class="wrapper">
     <div class="form">
         <h1 class="title" style="text-align: center;" >Create an account</h1>
         <?php if (isset($_GET['message'])): ?>
                <div style="text-align: center; margin-bottom: 20px;">
                    <?php if ($_GET['message'] === 'success'): ?>
                        <div style="color: green;">Đăng ký thành công! <a href="dangnhap.php">Đăng nhập</a></div>
                    <?php elseif ($_GET['message'] === 'error'): ?>
                        <div style="color: red;">Có lỗi xảy ra, vui lòng thử lại!</div>
                    <?php elseif ($_GET['message'] === 'exist'): ?>
                        <div style="color: orange;">Tên đăng nhập đã tồn tại!</div>
                    <?php endif; ?>
                </div>
        <?php endif; ?>
         <form action="../controllers/xulydulieu.php" method="POST" class="myform">
            <div class="control-from">
                 <label for="account">Username *</label>
                 <input type="text" id="username" name="user" value="" required>
             </div>

            <div class="control-from">
                 <label for="firstname">Full Name *</label>
                 <input type="text" id="fullname" name="tkf" value="" required>
             </div>

              <div class="control-from">
                 <label for="password"> PassWord *</label>
                 <input type="password" id="password" name="mk"  value="" required>
             </div>

                <div class="control-from">
                  <label for="password">Confirm password *</label>
                  <input type="password" id="confirm-password" name="nmk" value="" required>
            </div>

             <div class="control-from">
                 <label for="emailaddress">Email *</label>
                 <input type="email" id="emailaddress" name="email"  value="" required>
             </div>

             <div class="control-from">
                 <label for="phonenumber">Phone Number</label>
                 <input type="tel" id="phonenumber" name="sdt" value="" required>
             </div>

             <div class="full-width">
                 <label for="dateofbirth">Date of birth</label>
                 <input type="date" id="dateofbirth" name="ns" value="" required>
             </div>

             <div class="control-from">
                 <label for="placeofresidence">Place of residence</label>
                 <input type="text" id="placeofresidence" name="diachi"  value="" required>
             </div>

             <div class="control-from" id="gender-group">
                 <label for="gender-female"> Gender </label>
                 <input type="radio" id="gender-male" name="gender" value="0"> Nam 
                 <input type="radio" id="gender-female" name="gender" value="1"> Nữ
             </div>
             <div class="button">
                <button id="register" type="submit" name="signup">Register</button>
             </div>
         </form>
     </div>
 </div>
</body>
</html>