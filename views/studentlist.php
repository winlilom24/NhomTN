<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../core/Database.php';

// Xử lý phân trang
$limit = 10; // Số bản ghi mỗi trang
$page = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
if ($page < 1) $page = 1; // Đảm bảo trang không nhỏ hơn 1
$offset = ($page - 1) * $limit;

// Lấy tổng số bản ghi
$total_query = "SELECT COUNT(*) as total FROM thong_tin";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Lấy dữ liệu cho trang hiện tại
$sql = "SELECT * FROM thong_tin LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link rel="stylesheet" href="../style/css/studentManager.css">
</head>
<body>
    <div class="container">
        <div class="cau_hoi">
            <div class="button-group mb-4">
                <a href="homeAdmin.php" class="action-btn"><ion-icon name="caret-back-outline"></ion-icon> Quay lại</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Số điện thoại</th>
                        <th>Giới tính</th>
                        <th>Thống kê bài thi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ho_ten']) . "</td>";
                    $ngay_sinh = date("d/m/Y", strtotime($row['ngay_sinh']));
                    echo "<td>" . htmlspecialchars($ngay_sinh) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sdt']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gioi_tinh']) . "</td>";
                    echo "<td>";
                    echo "<a href='student_details.php?student_id=" . htmlspecialchars($row['id']) . "' class='action-btn'>Xem chi tiết</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                // Trang đầu
                if ($page > 1) {
                    echo "<a href='?trang=1' class='pagination-btn'>Trang đầu</a>";
                }

                // Trang trước
                if ($page > 1) {
                    $prev_page = $page - 1;
                    echo "<a href='?trang=$prev_page' class='pagination-btn'>Trang trước</a>";
                }

                // Hiển thị các số trang
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);
                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = ($i == $page) ? "active" : "";
                    echo "<a href='?trang=$i' class='pagination-btn $active'>$i</a>";
                }

                // Trang sau
                if ($page < $total_pages) {
                    $next_page = $page + 1;
                    echo "<a href='?trang=$next_page' class='pagination-btn'>Trang sau</a>";
                }

                // Trang cuối
                if ($page < $total_pages) {
                    echo "<a href='?trang=$total_pages' class='pagination-btn'>Trang cuối</a>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="../style/js/studentManager.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <!-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> -->
</body>
</html>