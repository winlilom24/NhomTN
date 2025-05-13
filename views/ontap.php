<?php
session_start();
require __DIR__ . '/../site5.php';
load_headerList();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Ôn tập</title>
    <link rel="stylesheet" href="style/css/ontap.css">
    <link rel="stylesheet" href="style/css/headerExam.css">
    <link rel="shortcut icon" href="style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="ontap-header">
        <h1>Ôn tập các chương</h1>
        <p>Chọn chương bạn muốn ôn luyện!</p>
    </div>
    <div class="ontap-container">
        <div class="ontap-topic">
            <h2>Chương 1</h2>
            <a href="views/ontap_detail.php?chapter=1" class="ontap-btn">Bắt đầu ôn tập</a>
        </div>
        <div class="ontap-topic">
            <h2>Chương 2</h2>
            <a href="views/ontap_detail.php?chapter=2" class="ontap-btn">Bắt đầu ôn tập</a>
        </div>
        <div class="ontap-topic">
            <h2>Chương 3</h2>
            <a href="views/ontap_detail.php?chapter=3" class="ontap-btn">Bắt đầu ôn tập</a>
        </div>
    </div>
</body>

</html>