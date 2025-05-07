<?php
require_once __DIR__ . '/result_functions.php';

//hàm hiển kết quả
function show_result() {
    session_start();

    if (!isset($_SESSION['answers']) || empty($_SESSION['answers'])) {
        echo "Bạn chưa làm bài!";
        exit();
    }

    $result = calculate_result($_SESSION);
    extract($result);                       //giải nén biến result
    include __DIR__ . '/../views/result.php';
}
