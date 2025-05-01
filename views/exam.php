<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Làm bài</title>
    <link rel="stylesheet" href="style/css/trangLamBai.css">
    <link rel="stylesheet" href="style/css/headerExam.css">
    <link rel="shortcut icon" href="../style/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require __DIR__ . '/../site3.php';
        load_headerExam();
        $cur_question = $_GET['question'] ?? 1;
        $question = $_SESSION['questions'][$cur_question];
        $selected = $_SESSION['answers'][$cur_question] ?? '';
        ?>
<div class="container">
    <div class="exam">
        <form method="POST">
            <div style="text-align: left; font-weight: bold; color: red;">
                ⏳ Thời gian còn lại: <span id="countdown">Đang tải...</span>
            </div>

            <h5>Câu <?= $cur_question ?>: <?= $question['question'] ?></h5>

            <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                <label>
                    <input type="radio" name="answer" value="<?= $option ?>" <?= $selected === $option ? 'checked' : '' ?>>
                    <?= $question[$option] ?>
                </label><br>
            <?php endforeach; ?>

            <button name="<?= $cur_question < 40 ? 'submit_answer' : 'submit_test' ?>" id="<?= $cur_question < 40 ? 'saveAnswer' : 'submitAnswer' ?>">
                <?= $cur_question < 40 ? 'Lưu đáp án' : 'Nộp bài' ?>
            </button>
        </form>
    </div>

    <div class="tableQuestion">
        <div class="number-question">
            <?php for ($i = 1; $i <= 40; $i++): ?>
                <li type="none">
                    <button class="question-btn"
                            <?= isset($_SESSION['answers'][$i]) ? 'style="background-color: #45a049; color: white;"' : '' ?>
                            data-id="<?= $i ?>">
                        <?= $i ?>
                    </button>
                </li>
            <?php endfor; ?>
        </div>
        <div class="question-done">
            <p>Số câu đã làm: <span id="answered"><?= count($_SESSION['answers'] ?? []) ?></span>/40</p>
        </div>
    </div>
</div>

<script>
    // Điều hướng khi bấm vào nút số câu
    $(function () {
        $(".question-btn").click(function () {
            const questionId = $(this).data("id");
            window.location.href = `index.php?page=exam&question=${questionId}`;
        });
    });

    // Đếm ngược thời gian
    <?php
    $remaining_seconds = ($_SESSION['quiz_start_time'] + $_SESSION['quiz_duration']) - time();
    $remaining_seconds = max($remaining_seconds, 0); // Không để âm
    ?>
    
    // JS nhận số giây còn lại từ server
    let remaining = <?= $remaining_seconds ?>;

    function updateCountdown() {
        if (remaining <= 0) {
            clearInterval(timer);
            alert("⏰ Hết giờ! Bài thi sẽ được nộp tự động.");
            window.location.href = "index.php?page=submit";
        } else {
            const minutes = Math.floor((remaining / 60) % 60);
            const seconds = Math.floor(remaining % 60);
            document.getElementById("countdown").textContent = 
                `00:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            remaining--;
        }
    }

    const timer = setInterval(updateCountdown, 1000);

</script>
</body>
</html>
