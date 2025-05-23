<?php
    require __DIR__ . '/widget/headerList.php';
?>
<?php
//phân trang
$page = isset($_GET['page_num']) ? $_GET['page_num'] : 1;
$limit = 5;                         //sô bài làm trên 1 trang
$from = ($page - 1) * $limit;
$so_bai = count($tests);
$so_trang = ceil($so_bai / $limit);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/review.css">
    <link rel="stylesheet" href="style/css/headerDetail.css"> 
    <link rel="shortcut icon" href="./style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Bài thi đã làm</title>
</head>
<body>
    <div class="div container">
    <h2>Danh sách bài thi bạn đã làm</h2>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Thông tin bài thi</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                //chỉ lấy trong $test các hàng từ $from và lấy đúng $limit hàng
                foreach (array_slice($tests, $from, $limit) as $index => $test): 
            ?>
                <tr>
                    <td><?= $from + $index + 1 ?></td>
                    <td>
                        Thời gian: <?= floor($test['thoi_gian_thi'] / 60) ?> phút <?= $test['thoi_gian_thi'] % 60 ?> giây<br>
                        Điểm: <?= $test['so_diem'] ?><br>
                        Đúng: <?= $test['so_cau_dung'] ?> / Sai: <?= $test['so_cau_sai'] ?>
                    </td>
                    <td>
                        <a href="?page=reviewDetail&test_id=<?= $test['id_bai_thi'] ?>">Xem chi tiết</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php for ($i = 1; $i <= $so_trang; $i++): ?>
            <a href="?page=reviewList&page_num=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    </div>
</body>
</html>
