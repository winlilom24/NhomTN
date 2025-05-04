<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../core/Database.php';

// Xử lý phân trang
$limit = 10; // Số bản ghi mỗi trang
$page = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../style/css/studentManager.css">
    <link rel="stylesheet" href="../style/css/modalStudent.css">
</head>
<body>
    <div class="container">
        <div class="cau_hoi">
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
                    echo "<td>" . ($row['gioi_tinh'] ? 'Nam' : 'Nữ') . "</td>";
                    echo "<td>";
                    echo "<button class='editBtn' data-id='" . htmlspecialchars($row['id']) . "'>Xem chi tiết</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                // Trang trước
                if ($page > 1) {
                    $prev_page = $page - 1;
                    echo "<a href='?trang=$prev_page' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang trước</a>";
                }

                // Số trang
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? "background-color: #007bff; color: white;" : "";
                    echo "<a href='?trang=$i' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; $active'>$i</a>";
                }

                // Trang sau
                if ($page < $total_pages) {
                    $next_page = $page + 1;
                    echo "<a href='?trang=$next_page' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang sau</a>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal cho thống kê bài thi -->
    <div id="statsModal" style="display: none;">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Thống kê bài thi</h2>
            <div id="statsContent">
                <p><strong>Họ tên:</strong> <span id="studentName"></span></p>
                <p><strong>Số lần làm bài:</strong> <span id="totalTests"></span></p>
                <p><strong>Điểm trung bình:</strong> <span id="avgScore"></span></p>
                <p><strong>Thời gian làm bài trung bình:</strong> <span id="avgTime"></span> phút</p>
                <h3>Bài thi gần nhất</h3>
                <p><strong>ID bài thi:</strong> <span id="latestId"></span></p>
                <p><strong>Điểm:</strong> <span id="latestScore"></span></p>
                <p><strong>Thời gian:</strong> <span id="latestTime"></span> phút</p>
                <p><strong>Số câu đúng:</strong> <span id="latestCorrect"></span></p>
                <p><strong>Số câu sai:</strong> <span id="latestWrong"></span></p>
                <h3>Danh sách bài thi</h3>
                <table id="testList">
                    <thead>
                        <tr>
                            <th>ID Bài thi</th>
                            <th>Điểm</th>
                            <th>Thời gian (phút)</th>
                            <th>Số câu đúng</th>
                            <th>Số câu sai</th>
                        </tr>
                    </thead>
                    <tbody id="testListBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../style/js/studentManager.js"></script>
</body>
</html>