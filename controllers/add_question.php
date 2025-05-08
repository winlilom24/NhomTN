<?php
require_once __DIR__ . '/../core/Database.php';        

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question = $_POST['question'] ?? '';
    $A = $_POST['A'] ?? '';
    $B = $_POST['B'] ?? '';
    $C = $_POST['C'] ?? '';
    $D = $_POST['D'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $chapter = $_POST['chapter'] ?? '';

    $sql = "INSERT INTO cau_hoi (question, A, B, C, D, answer, chapter) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssss", $question, $A, $B, $C, $D, $answer, $chapter);
        if (mysqli_stmt_execute($stmt)) {
            echo "Đã thêm câu hỏi thành công!";
        } else {
            echo "Lỗi thêm!";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Lỗi chuẩn bị câu lệnh!";
    }

    mysqli_close($conn);
}
