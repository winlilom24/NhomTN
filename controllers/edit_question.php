<?php
require_once __DIR__ . '/../core/Database.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? '';
    $question = $_POST['question'] ?? '';
    $A = $_POST['A'] ?? '';
    $B = $_POST['B'] ?? '';
    $C = $_POST['C'] ?? '';
    $D = $_POST['D'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $chapter = $_POST['chapter'] ?? '';

    $sql = "UPDATE cau_hoi SET question=?, A=?, B=?, C=?, D=?, answer=?, chapter=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssi", $question, $A, $B, $C, $D, $answer, $chapter, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Đã cập nhật.";
        } else {
            echo "Lỗi cập nhật!";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Lỗi chuẩn bị truy vấn!";
    }

    mysqli_close($conn);
}
?>
