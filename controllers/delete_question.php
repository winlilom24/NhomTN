<?php
    require_once __DIR__ . '/../core/Database.php';        

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM cau_hoi WHERE id = ?");
    $stmt->bind_param("i", $id);

    echo $stmt->execute() ? "Đã xóa câu hỏi." : "Lỗi xóa: " . $stmt->error;

    $stmt->close();
    $conn->close();
}
