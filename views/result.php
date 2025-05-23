<?php
require __DIR__ . '/widget/headerSubmit.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả bài thi</title>
    <link rel="stylesheet" href="style/css/trangNopBai.css">
    <link rel="stylesheet" href="style/css/headerDetail.css">
    <link rel="shortcut icon" href="./style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="result-container">

        <h2>Kết quả bài thi</h2>
        <div class = "result-summary">
        <p><strong>Số câu đúng:</strong> <?= $correct ?></p>
        <p><strong>Số câu sai:</strong> <?= $wrong ?></p>
        <p><strong>Điểm:</strong> <?= $score ?></p>
        <p><strong>Thời gian làm bài:</strong> <?= floor($time_taken / 60) ?> phút <?= $time_taken % 60 ?> giây</p>
        </div>  

        <?php foreach ($results as $index => $q): ?>
            <div class="questionBox">
<!-- hiển thị câu hỏi  -->
                <h5>Câu <?= $index + 1 ?>: <?= $q['question'] ?></h5>
<!-- hiển thị các đáp án  -->
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
        <a href="index.php?page=exam"><button>🔁 Làm lại</button></a>
        <a href="index.php?page=homeAfterLogin"><button>🏠 Về trang chủ</button></a>
    </div>
</body>
</html>
