<?php
session_start();
require_once __DIR__ . '/../core/Database.php';
require __DIR__ . '/widget/headerReview.php';

$chapter = isset($_GET['chapter']) ? intval($_GET['chapter']) : 1;
$count = null;
$questions = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $questions = $_SESSION['questions'] ?? [];
    $correct = 0;
    $evaluated = [];

    foreach ($questions as $q) {
        $qid = $q['id'];
        if (!isset($_POST['answers'][$qid])) continue;

        $q['user_answer'] = $_POST['answers'][$qid];
        $q['is_correct'] = ($q['answer'] === $q['user_answer']);
        if ($q['is_correct']) $correct++;
        $evaluated[] = $q;
    }
    $questions = $evaluated;
    $count = $correct;
    unset($_SESSION['questions']); // optional: clear session after submit
} else {
    $sql = "SELECT * FROM cau_hoi WHERE chapter = $chapter ORDER BY id ASC LIMIT 40";
    $result = mysqli_query($conn, $sql);
    $questions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row;
    }
    $_SESSION['questions'] = $questions;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Ôn tập chương <?= $chapter ?></title>
    <link rel="stylesheet" href="../style/css/ontap_detail.css">
    <link rel="stylesheet" href="../style/css/headerExam.css">
    <link rel="shortcut icon" href="../style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <h1>Ôn tập chương <?= $chapter ?></h1>

    <?php if ($count !== null): ?>
        <h2>Bạn đúng <?= $count ?> / <?= count($questions) ?> câu!</h2>
        <div class="result-container">
            <?php foreach ($questions as $q): ?>
                <div class="result-item <?= $q['is_correct'] ? 'correct' : 'incorrect' ?>">
                    <b><?= ($q['question']) ?></b><br><br>
                    <?php foreach (['A', 'B', 'C', 'D'] as $opt):
                        $isCorrect = ($q['answer'] == $opt);
                        $isUserAnswer = ($q['user_answer'] == $opt);
                        $class = $isCorrect ? 'correct-answer' : '';
                        if ($isUserAnswer && !$isCorrect) $class = 'user-answer';
                    ?>
                        <div class="result-option <?= $class ?>">
                            <strong><?= $opt ?>.</strong> <?= ($q[$opt]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="ontap-btn">
            <a href="ontap_detail.php?chapter=<?= $chapter ?>" id="again">Làm lại</a>
        </button>

    <?php elseif (!empty($questions)): ?>
        <form method="post">
            <?php $i = 1;
            foreach ($questions as $row): ?>
                <div style="margin-bottom:18px;">
                    <b>Câu <?= $i ?>:</b> <?= ($row['question']) ?><br>
                    <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
                        <label>
                            <input type="radio" name="answers[<?= $row['id'] ?>]" value="<?= $opt ?>" required>
                            <?= $opt ?>. <?= ($row[$opt]) ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php $i++; endforeach; ?>
            <button type="submit" class="ontap-btn">Nộp bài ôn tập</button>
        </form>
    <?php else: ?>
        <p>Không có dữ liệu cho chương này.</p>
    <?php endif; ?>
</body>
</html>

<?php
if (isset($result)) mysqli_free_result($result);
mysqli_close($conn);
?>
