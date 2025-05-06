<?php
require_once __DIR__ . '/../core/Database.php'; // Đảm bảo trong đó có mysqli_connect()

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM cau_hoi WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Đã xóa câu hỏi.";
        } else {
            echo "Lỗi xóa!";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Lỗi chuẩn bị câu lệnh!";
    }

    mysqli_close($conn);
}
?>
