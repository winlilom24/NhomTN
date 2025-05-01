<?php
    require_once __DIR__ . '/../core/Database.php';        

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $A = $_POST['A'];
    $B = $_POST['B'];
    $C = $_POST['C'];
    $D = $_POST['D'];
    $answer = $_POST['answer'];
    $chapter = $_POST['chapter'];

    $stmt = $conn->prepare("UPDATE cau_hoi SET question=?, A=?, B=?, C=?, D=?, answer=?, chapter=? WHERE id=?");
    $stmt->bind_param("sssssssi", $question, $A, $B, $C, $D, $answer, $chapter, $id);

    echo $stmt->execute() ? "Đã cập nhật." : "Lỗi cập nhật: " . $stmt->error;

    $stmt->close();
    $conn->close();
}
