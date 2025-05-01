<?php
$page = isset($_GET['page_num']) ? $_GET['page_num'] : 1;
$limit = 5;
$from = ($page - 1) * $limit;
$so_bai = count($tests);
$so_trang = ceil($so_bai / $limit);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/review.css">
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
            <?php foreach (array_slice($tests, $from, $limit) as $index => $test): ?>
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
