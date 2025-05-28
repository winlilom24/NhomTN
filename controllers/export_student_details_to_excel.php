<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../core/Database.php';

// Kiểm tra student_id
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

// Tạo tên file động, giữ tiếng Việt
$ho_ten = $student['ho_ten'];
// Loại bỏ ký tự không hợp lệ cho tên file, giữ dấu tiếng Việt
$invalid_chars = ['\\', '/', ':', '*', '?', '"', '<', '>', '|'];
$clean_ho_ten = str_replace($invalid_chars, '', trim($ho_ten));
$filename = "Thông tin chi tiết sinh viên " . $clean_ho_ten . ".xls";

// Thiết lập header
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

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

// Lấy danh sách bài thi
$tests_query = "
    SELECT id_bai_thi, so_diem, thoi_gian_thi, so_cau_dung, so_cau_sai
    FROM ket_qua_thi
    WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'
    ORDER BY id_bai_thi DESC
";
$tests_result = mysqli_query($conn, $tests_query);
?>

<meta charset="utf-8" />
<table>
    <thead>
        <tr>
            <th colspan="2">Thông tin chi tiết sinh viên</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Họ tên</strong></td>
            <td><?php echo htmlspecialchars($student['ho_ten']); ?></td>
        </tr>
        <tr>
            <td><strong>Số lần làm bài</strong></td>
            <td><?php echo (int)$stats['total_tests']; ?></td>
        </tr>
        <tr>
            <td><strong>Điểm trung bình</strong></td>
            <td><?php echo number_format((float)$stats['avg_score'], 2); ?></td>
        </tr>
        <tr>
            <td><strong>Thời gian làm bài trung bình</strong></td>
            <td><?php echo number_format((float)$stats['avg_time'] / 60, 2); ?> phút</td>
        </tr>
    </tbody>
</table>
<br>
<table>
    <thead>
        <tr>
            <th colspan="5">Danh sách bài thi</th>
        </tr>
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
                echo "<td>" . htmlspecialchars($test['id_bai_thi']) . "</td>";
                echo "<td>" . htmlspecialchars($test['so_diem']) . "</td>";
                echo "<td>" . number_format($test['thoi_gian_thi'] / 60, 2) . "</td>";
                echo "<td>" . htmlspecialchars($test['so_cau_dung']) . "</td>";
                echo "<td>" . htmlspecialchars($test['so_cau_sai']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Chưa có bài thi</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </tbody>
</table>