<?php
    require __DIR__ . '/../site4.php';
    load_headerDetail();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết bài thi</title>
    <link rel="stylesheet" href="style/css/trangNopBai.css">
    <link rel="stylesheet" href="style/css/headerDetail.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="result-container">
        <h2>Chi tiết bài thi</h2>
        <?php foreach ($questions as $index => $q): ?>
            <div class="questionBox">
                <h5>Câu <?= $index + 1 ?>: <?= $q['question'] ?></h5>

                <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                    <?php
                        $isCorrect = ($q['correct_answer'] == $option);
                        $isUserAnswer = ($q['user_answer'] == $option);
                        $class = $isCorrect ? 'correct-answer' : '';
                        if ($isUserAnswer && !$isCorrect) $class = 'incorrect';
                    ?>
                    <label class="answer-label <?= $class ?>">
                        <?= $option ?>. <?= $q[$option] ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
