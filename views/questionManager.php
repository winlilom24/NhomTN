<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý câu hỏi</title>
    <!-- <link rel="stylesheet" href="../style/css/modal.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../style/css/questionManager.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <div class="header-controls">
        <a href= "homeAdmin.php">
        <button id="back"><ion-icon name="caret-back-outline"></ion-icon>Quay lại</button>
        </a>

        <button id="add">➕ Thêm câu hỏi</button>
    </div>
    <div class="cau_hoi">
        <table border="1">
            <thead>
                <tr>
                    <th>Số thứ tự</th>
                    <th>Câu hỏi</th>
                    <th>Câu A</th>
                    <th>Câu B</th>
                    <th>Câu C</th>
                    <th>Câu D</th>
                    <th>Đáp án</th>
                    <th>Chương</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../controllers/get_questions.php'; ?>
            </tbody>
        </table>
        <!-- thêm nút chuyển trang -->

        <div class="pagination" style="text-align: center; margin-top: 20px;">
             <?php
            $sotrangdl = $GLOBALS['sotrangdl'];
            $page = $GLOBALS['page'];
            $max_buttons = 10; // Số nút tối đa muốn hiển thị
             $half_buttons = floor($max_buttons / 2); // Số nút hiển thị mỗi bên của trang hiện tại

            // Tính toán trang bắt đầu và kết thúc
            $start_page = max(1, $page - $half_buttons);
             $end_page = min($sotrangdl, $page + $half_buttons);

            // Điều chỉnh để luôn hiển thị đúng 5 nút (nếu có đủ trang)
             if ($end_page - $start_page + 1 < $max_buttons) {
             if ($start_page == 1) {
                $end_page = min($sotrangdl, $start_page + $max_buttons - 1);
             } else {
                $start_page = max(1, $end_page - $max_buttons + 1);
            }
    }
    // Nút "Trang đầu"
    if ($page > 1) {
        echo "<a href='?trang=1' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang đầu</a>";
    }

    // Nút "Trang trước"
    if ($page > 1) {
        $prev_page = $page - 1;
        echo "<a href='?trang=$prev_page' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang trước</a>";
    }

    // Hiển thị các nút số trang
    for ($i = $start_page; $i <= $end_page; $i++) {
        $active = ($i == $page) ? "background-color: #007bff; color: white;" : "";
        echo "<a href='?trang=$i' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; $active'>$i</a>";
    }

    // Nút "Trang sau"
    if ($page < $sotrangdl) {
        $next_page = $page + 1;
        echo "<a href='?trang=$next_page' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang sau</a>";
    }
    // Nút "Trang cuối"
    if ($page < $sotrangdl) {
        echo "<a href='?trang=$sotrangdl' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang cuối</a>";
    }
    
    ?>
</div>
    </div>

    <?php include 'modal.php'; ?>
    <script src="../style/js/questionManager.js"></script>
</body>
</html>
