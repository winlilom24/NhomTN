<?php
session_unset();      // Xóa toàn bộ session
session_destroy();    // Hủy session hiện tại
header("Location: ../index.php"); // hoặc quay về trang login
exit();
?>