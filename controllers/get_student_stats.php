<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../core/Database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    // Lấy thông tin sinh viên
    $student_query = "SELECT ho_ten FROM thong_tin WHERE id = '$student_id'";
    $student_result = mysqli_query($conn, $student_query);
    
    if ($student_result && mysqli_num_rows($student_result) > 0) {
        $student = mysqli_fetch_assoc($student_result);
        $response['data']['student_name'] = $student['ho_ten'];

        // Lấy thống kê bài thi
        $stats_query = "
            SELECT 
                COUNT(*) as total_tests,
                AVG(so_diem) as avg_score,
                AVG(thoi_gian_thi) as avg_time,
                AVG(so_cau_dung / (so_cau_dung + so_cau_sai) * 100) as avg_correct_rate
            FROM ket_qua_thi
            WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'
        ";
        $stats_result = mysqli_query($conn, $stats_query);
        $stats = mysqli_fetch_assoc($stats_result);

        $response['data']['total_tests'] = (int)$stats['total_tests'];
        $response['data']['avg_score'] = (float)$stats['avg_score'];
        $response['data']['avg_time'] = (float)$stats['avg_time'];
        $response['data']['avg_correct_rate'] = (float)$stats['avg_correct_rate'];

        // Lấy bài thi gần nhất
        $latest_query = "
            SELECT id_bai_thi, so_diem, thoi_gian_thi, so_cau_dung, so_cau_sai
            FROM ket_qua_thi
            WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'
            ORDER BY id_bai_thi DESC
            LIMIT 1
        ";
        $latest_result = mysqli_query($conn, $latest_query);
        if ($latest_result && mysqli_num_rows($latest_result) > 0) {
            $response['data']['latest_test'] = mysqli_fetch_assoc($latest_result);
        }

        // Lấy danh sách bài thi
        $tests_query = "
            SELECT id_bai_thi, so_diem, thoi_gian_thi, so_cau_dung, so_cau_sai
            FROM ket_qua_thi
            WHERE id_ng_dung = '$student_id' AND id_bai_thi != '0'
            ORDER BY id_bai_thi DESC
        ";
        $tests_result = mysqli_query($conn, $tests_query);
        $response['data']['tests'] = [];
        while ($test = mysqli_fetch_assoc($tests_result)) {
            $response['data']['tests'][] = $test;
        }

        $response['success'] = true;
    } else {
        $response['message'] = 'Không tìm thấy sinh viên.';
    }
} else {
    $response['message'] = 'Yêu cầu không hợp lệ.';
}

echo json_encode($response);
?>