<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý câu hỏi</title>
    <!-- <link rel="stylesheet" href="../style/css/modal.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../style/css/questionManager.css">
</head>
<body>

    <button id="add">➕ Thêm câu hỏi</button>
    
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

            //trang trước
            if ($page > 1) {
                $prev_page = $page - 1;
                echo "<a href='?trang=$prev_page' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang trước</a>";
            }
            //theo số thứ tự 
            for ($i = 1; $i <= $sotrangdl; $i++) {
                $active = ($i == $page) ? "background-color: #007bff; color: white;" : "";
                echo "<a href='?trang=$i' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; $active'>$i</a>";
            }
            //trang sau 
            if ($page < $sotrangdl) {
                $next_page = $page + 1;
                echo "<a href='?trang=$next_page' style='padding: 8px 12px; margin: 0 5px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px;'>Trang sau</a>";
            }
            ?>
        </div>
    </div>

    <?php include 'modal.php'; ?>
    <script src="../style/js/questionManager.js"></script>
</body>
</html>
