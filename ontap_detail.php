<?php
$conn = new mysqli('localhost', 'root', '', 'duantnnhom');
$conn->set_charset('utf8');

$chapter = isset($_GET['chapter']) ? intval($_GET['chapter']) : 1;
$sql = "SELECT * FROM cau_hoi WHERE chapter = $chapter ORDER BY id ASC LIMIT 40";
$result = $conn->query($sql);

$count = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $count = 0;
    foreach ($_POST['answers'] as $id => $answer) {
        // Lấy đáp án đúng từ DB
        $sql_ans = "SELECT answer FROM cau_hoi WHERE id = $id";
        $res_ans = $conn->query($sql_ans);
        $row_ans = $res_ans->fetch_assoc();
        if (strtoupper($answer) == strtoupper($row_ans['answer'])) {
            $count++;
        }
    }
    // echo "<h2>Bạn đúng $count / " . count($_POST['answers']) . " câu!</h2>";
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/ontap_detail.css">
    <title>Ôn tập chương <?= $chapter ?></title>
</head>

<body>
    <h1>Ôn tập chương <?= $chapter ?></h1>
    <?php if ($count !== null): ?>
        <h2>Bạn đúng <?= $count   ?> / <?= count($_POST['answers']) ?> câu!</h2>
        <a href="ontap_detail.php?chapter=<?= $chapter ?>">Làm lại</a>
    <?php endif; ?>
    <?php if ($result && $result->num_rows > 0 &&  $count  === null): ?>
        <form method="post">
            <?php $i = 1;
            while ($row = $result->fetch_assoc()): ?>
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
    <?php elseif ($count  === null): ?>
        <p>Không có dữ liệu cho chương này.</p>
    <?php endif; ?>
</body>

</html>