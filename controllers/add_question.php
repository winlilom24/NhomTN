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

    $stmt = $conn->prepare("INSERT INTO cau_hoi (question, A, B, C, D, answer, chapter) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $question, $A, $B, $C, $D, $answer, $chapter);

    echo $stmt->execute() ? "Đã thêm câu hỏi." : "Lỗi thêm: " . $stmt->error;

    $stmt->close();
    $conn->close();
}
