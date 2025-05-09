<?php
function list_tests() {
    session_start();

    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo "Bạn chưa đăng nhập!";
        exit();
    }
    require_once __DIR__ . '/../core/Database.php';
    //lấy ds bài thi theo thứ tự mới nhất của user_id
    $stmt = mysqli_prepare($conn, "
        SELECT id_bai_thi, so_cau_dung, so_cau_sai, so_diem, thoi_gian_thi 
        FROM ket_qua_thi 
        WHERE id_ng_dung = ? 
        ORDER BY id_bai_thi DESC
    ");
    
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tests = mysqli_fetch_all($result, MYSQLI_ASSOC); //lấy toàn bộ dữ liệu
    mysqli_stmt_close($stmt);

    include __DIR__ . '/../views/review_list.php';
}

function show_test_detail($test_id) {
    require_once __DIR__ . '/../core/Database.php';
    $stmt = mysqli_prepare($conn, "
        SELECT c.id, c.question, c.A, c.B, c.C, c.D, c.answer AS correct_answer, b.dap_an_lam_bai AS user_answer
        FROM bai_da_lam b
        JOIN cau_hoi c ON b.id_cau_hoi = c.id
        WHERE b.id_bai_thi = ?
    ");
    mysqli_stmt_bind_param($stmt, "s", $test_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    include __DIR__ . '/../views/review_detail.php';
}
