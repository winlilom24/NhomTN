<?php
require_once __DIR__ . '/../core/Database.php';
session_start();

// Kiểm tra xem người dùng đã làm bài chưa
if (!isset($_SESSION['answers']) || empty($_SESSION['answers'])) {
    echo "Bạn chưa làm bài!";
    exit();
}

// Xử lý kết quả trực tiếp tại đây
$correct = 0;
$wrong = 0;
$results = [];

foreach ($_SESSION['questions'] as $index => $question) {
    $user_answer = $_SESSION['answers'][$index] ?? null;
    $correct_answer = $question['answer'];

    if ($user_answer === $correct_answer) $correct++;
    else $wrong++;

    $results[] = [
        'question' => $question['question'],
        'A' => $question['A'],
        'B' => $question['B'],
        'C' => $question['C'],
        'D' => $question['D'],
        'user_answer' => $user_answer,
        'correct_answer' => $correct_answer,
        'id' => $question['id']
    ];
}

$score = $correct * 0.25;
$time_taken = time() - $_SESSION['quiz_start_time'];

// Lưu kết quả vào database
save_result_to_db($_SESSION['test_id'], $correct, $wrong, $score, $time_taken, $results);

// Hiển thị kết quả
require __DIR__ . '/../views/result.php';
?>

<?php
// Hàm lưu kết quả vào CSDL
function save_result_to_db($test_id, $correct, $wrong, $score, $time, $results) {
    require __DIR__ . '/../core/Database.php';  
    $user_id = $_SESSION['user_id'];

    $stmt = mysqli_prepare($conn, "INSERT INTO ket_qua_thi (id_ng_dung, id_bai_thi, so_cau_dung, so_cau_sai, so_diem, thoi_gian_thi) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssiidi", $user_id, $test_id, $correct, $wrong, $score, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    foreach ($results as $r) {
        $stmt = mysqli_prepare($conn, "INSERT INTO bai_da_lam (id_bai_thi, id_cau_hoi, dap_an_lam_bai) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sis", $test_id, $r['id'], $r['user_answer']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    unset($_SESSION['quiz_start_time'], $_SESSION['answers'], $_SESSION['questions'], $_SESSION['test_id']);
}
?>