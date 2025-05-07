document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút "Xem chi tiết"
    const editButtons = document.querySelectorAll('.editBtn');
    
    // Thêm sự kiện click cho từng nút
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-id');
            
            // Gửi yêu cầu AJAX bằng fetch
            fetch('../controllers/get_student_stats.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `student_id=${encodeURIComponent(studentId)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật nội dung modal
                    document.getElementById('studentName').innerText = data.data.student_name;
                    document.getElementById('totalTests').innerText = data.data.total_tests;
                    document.getElementById('avgScore').innerText = data.data.avg_score.toFixed(2);
                    document.getElementById('avgTime').innerText = (data.data.avg_time / 60).toFixed(2);

                    // Cập nhật danh sách bài thi
                    const testListBody = document.getElementById('testListBody');
                    testListBody.innerHTML = ''; // Xóa nội dung cũ
                    if (data.data.tests && data.data.tests.length > 0) {
                        data.data.tests.forEach(test => {
                            const row = `
                                <tr>
                                    <td>${test.id_bai_thi}</td>
                                    <td>${test.so_diem}</td>
                                    <td>${(test.thoi_gian_thi / 60).toFixed(2)}</td>
                                    <td>${test.so_cau_dung}</td>
                                    <td>${test.so_cau_sai}</td>
                                </tr>`;
                            testListBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        testListBody.innerHTML = '<tr><td colspan="5">Chưa có bài thi</td></tr>';
                    }

                    // Hiển thị modal ngay lập tức
                    document.getElementById('statsModal').style.display = 'block';
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                alert('Đã xảy ra lỗi khi tải dữ liệu.');
                console.error('Error:', error);
            });
        });
    });

    // Xử lý đóng modal khi nhấp vào nút "×"
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('statsModal').style.display = 'none';
    });

    // Đóng modal khi nhấp ra ngoài
    window.addEventListener('click', function(event) {
        if (event.target.id === 'statsModal') {
            document.getElementById('statsModal').style.display = 'none';
        }
    });
});document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút "Xem chi tiết"
    const editButtons = document.querySelectorAll('.editBtn');
    
    // Thêm sự kiện click cho từng nút
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-id');
            // Chuyển hướng đến trang chi tiết sinh viên
            window.location.href = `student_details.php?student_id=${encodeURIComponent(studentId)}`;
        });
    });
});