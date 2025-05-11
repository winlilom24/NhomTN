<?php
session_start();
require_once __DIR__ . '/../core/Database.php'; 
require __DIR__ . '/../site6.php';
load_headerReview();

$chapter = isset($_GET['chapter']) ? intval($_GET['chapter']) : 1;
$sql = "SELECT * FROM cau_hoi WHERE chapter = $chapter ORDER BY id ASC LIMIT 40";
$result = mysqli_query($conn, $sql);

$count = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $count = 0;
    foreach ($_POST['answers'] as $id => $answer) {
        // Lấy đáp án đúng từ DB
        $sql_ans = "SELECT answer FROM cau_hoi WHERE id = $id";
        $res_ans = mysqli_query($conn, $sql_ans);
        $row_ans = mysqli_fetch_assoc($res_ans);
        if (strtoupper($answer) == strtoupper($row_ans['answer'])) {
            $count++;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/css/ontap_detail.css">
    <link rel="stylesheet" href="../style/css/headerExam.css"> 
    <link rel="shortcut icon" href="../style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Ôn tập chương <?= $chapter ?></title>
</head>

<body>
    <h1>Ôn tập chương <?= $chapter ?></h1>
    <?php if ($count !== null): ?>
        <h2>Bạn đúng <?= $count ?> / <?= count($_POST['answers']) ?> câu!</h2>
        <a href="ontap_detail.php?chapter=<?= $chapter ?>">Làm lại</a>
    <?php endif; ?>
    <?php if ($result && mysqli_num_rows($result) > 0 &&  $count === null): ?>
        <form method="post">
            <?php $i = 1;
            while ($row = mysqli_fetch_assoc($result)): ?>
                <div style="margin-bottom:18px;">
                    <b>Câu <?= $i ?>:</b> <?= htmlspecialchars($row['question']) ?><br>
                    <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                        <label>
                            <input type="radio" name="answers[<?= $row['id'] ?>]" value="<?= $option ?>" required>
                            <?= $option ?>. <?= htmlspecialchars($row[$option]) ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php $i++;
            endwhile; ?>
            <button type="submit" class="ontap-btn">Nộp bài ôn tập</button>
        </form>
    <?php elseif ($count === null): ?>
        <p>Không có dữ liệu cho chương này.</p>
    <?php endif; ?>
</body>

</html>

<?php
// Đóng kết nối sau khi hoàn thành
mysqli_free_result($result);
mysqli_close($conn);
?>
