$(document).ready(function() {
    // Xử lý sự kiện nhấp vào nút "Xem chi tiết"
    $('.editBtn').on('click', function() {
        var studentId = $(this).data('id');
        
        // Gửi yêu cầu AJAX để lấy thống kê bài thi
        $.ajax({
            url: '../controllers/get_student_stats.php',
            type: 'POST',
            data: { student_id: studentId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Cập nhật nội dung modal
                    $('#studentName').text(response.data.student_name);
                    $('#totalTests').text(response.data.total_tests);
                    $('#avgScore').text(response.data.avg_score.toFixed(2));
                    $('#avgTime').text((response.data.avg_time / 60).toFixed(2));

                    // Cập nhật bài thi gần nhất
                    if (response.data.latest_test) {
                        $('#latestId').text(response.data.latest_test.id_bai_thi);
                        $('#latestScore').text(response.data.latest_test.so_diem);
                        $('#latestTime').text((response.data.latest_test.thoi_gian_thi / 60).toFixed(2));
                        $('#latestCorrect').text(response.data.latest_test.so_cau_dung);
                        $('#latestWrong').text(response.data.latest_test.so_cau_sai);
                    } else {
                        $('#latestId').text('Chưa có bài thi');
                        $('#latestScore').text('-');
                        $('#latestTime').text('-');
                        $('#latestCorrect').text('-');
                        $('#latestWrong').text('-');
                    }

                    // Cập nhật danh sách bài thi
                    $('#testListBody').empty();
                    if (response.data.tests && response.data.tests.length > 0) {
                        response.data.tests.forEach(function(test) {
                            var row = `<tr>
                                <td>${test.id_bai_thi}</td>
                                <td>${test.so_diem}</td>
                                <td>${(test.thoi_gian_thi / 60).toFixed(2)}</td>
                                <td>${test.so_cau_dung}</td>
                                <td>${test.so_cau_sai}</td>
                            </tr>`;
                            $('#testListBody').append(row);
                        });
                    } else {
                        $('#testListBody').append('<tr><td colspan="5">Chưa có bài thi</td></tr>');
                    }

                    // Hiển thị modal ngay lập tức
                    $('#statsModal').css('display', 'block');
                } else {
                    alert('Lỗi: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi tải dữ liệu.');
            }
        });
    });

    // Xử lý đóng modal
    $('.close').on('click', function() {
        $('#statsModal').css('display', 'none');
    });

    // Đóng modal khi nhấp ra ngoài
    $(window).on('click', function(event) {
        if (event.target.id === 'statsModal') {
            $('#statsModal').css('display', 'none');
        }
    });
});