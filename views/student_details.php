<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../core/Database.php';

if (!isset($_GET['student_id'])) {
    header("Location: studentlist.php");
    exit();
}

$student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

// Lấy thông tin sinh viên
$student_query = "SELECT ho_ten FROM thong_tin WHERE id = '$student_id'";
$student_result = mysqli_query($conn, $student_query);

if (!$student_result || mysqli_num_rows($student_result) == 0) {
    header("Location: studentlist.php");
    exit();
}
$student = mysqli_fetch_assoc($student_result);

// Lấy thống kê bài thi
$stats_query = "
    SELECT 
        COUNT(*) as total_tests,
        AVG(so_diem) as avg_score,
        AVG(thoi_gian_thi) as avg_time
    FROM ket_qua_thi
    WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'
";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Xử lý phân trang cho danh sách bài thi
$test_limit = 5; // Số bài thi mỗi trang
$test_page = isset($_GET['test_page']) ? (int)$_GET['test_page'] : 1;
if ($test_page < 1) $test_page = 1;
$test_offset = ($test_page - 1) * $test_limit;

// Lấy tổng số bài thi
$total_tests_query = "SELECT COUNT(*) as total FROM ket_qua_thi WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'";
$total_tests_result = mysqli_query($conn, $total_tests_query);
$total_tests_row = mysqli_fetch_assoc($total_tests_result);
$total_test_records = $total_tests_row['total'];
$total_test_pages = ceil($total_test_records / $test_limit);

// Lấy danh sách bài thi cho trang hiện tại
$tests_query = "
    SELECT id_bai_thi, so_diem, thoi_gian_thi, so_cau_dung, so_cau_sai
    FROM ket_qua_thi
    WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'
    ORDER BY id_bai_thi DESC
    LIMIT $test_limit OFFSET $test_offset
";
$tests_result = mysqli_query($conn, $tests_query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sinh viên - <?php echo $student['ho_ten']); ?></title>
    <link rel="shortcut icon" href="../style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/css/studentManager.css">
</head>
<body>
    <div class="container">
        <div class="cau_hoi">
            <h2 class="text-2xl font-bold mb-4">Chi tiết sinh viên</h2>
            <div class="mb-6">
                <p><strong>Họ tên:</strong> <?php echo $student['ho_ten']; ?></p>
                <p><strong>Số lần làm bài:</strong> <?php echo (int)$stats['total_tests']; ?></p>
                <p><strong>Điểm trung bình:</strong> <?php echo number_format((float)$stats['avg_score'], 2); ?></p>
                <p><strong>Thời gian làm bài trung bình:</strong> <?php echo number_format((float)$stats['avg_time'] / 60, 2); ?> phút</p>
                <div class="button-group mt-4">
                    <a href="../controllers/export_student_details_to_excel.php?student_id=<?php echo $student_id); ?>" class="action-btn">📥 Tải thông tin chi tiết</a>
                    <a href="studentlist.php" class="action-btn"><ion-icon name="caret-back-outline"></ion-icon> Quay lại danh sách</a>
                </div>
            </div>
            <h3 class="text-xl font-semibold mb-2">Danh sách bài thi</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Bài thi</th>
                        <th>Điểm</th>
                        <th>Thời gian (phút)</th>
                        <th>Số câu đúng</th>
                        <th>Số câu sai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($tests_result) > 0) {
                        while ($test = mysqli_fetch_assoc($tests_result)) {
                            echo "<tr>";
                            echo "<td>" . $test['id_bai_thi'] . "</td>";
                            echo "<td>" . $test['so_diem'] . "</td>";
                            echo "<td>" . number_format($test['thoi_gian_thi'] / 60, 2) . "</td>";
                            echo "<td>" . $test['so_cau_dung'] . "</td>";
                            echo "<td>" . $test['so_cau_sai'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Chưa có bài thi</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                // Trang đầu
                if ($test_page > 1) {
                    echo "<a href='?student_id=$student_id&test_page=1' class='pagination-btn'>Trang đầu</a>";
                }

                // Trang trước
                if ($test_page > 1) {
                    $prev_test_page = $test_page - 1;
                    echo "<a href='?student_id=$student_id&test_page=$prev_test_page' class='pagination-btn'>Trang trước</a>";
                }

                // Hiển thị các số trang
                $start_test_page = max(1, $test_page - 2);
                $end_test_page = min($total_test_pages, $test_page + 2);
                for ($i = $start_test_page; $i <= $end_test_page; $i++) {
                    $active = ($i == $test_page) ? "active" : "";
                    echo "<a href='?student_id=$student_id&test_page=$i' class='pagination-btn $active'>$i</a>";
                }

                // Trang sau
                if ($test_page < $total_test_pages) {
                    $next_test_page = $test_page + 1;
                    echo "<a href='?student_id=$student_id&test_page=$next_test_page' class='pagination-btn'>Trang sau</a>";
                }

                // Trang cuối
                if ($test_page < $total_test_pages) {
                    echo "<a href='?student_id=$student_id&test_page=$total_test_pages' class='pagination-btn'>Trang cuối</a>";
                }
                ?>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>