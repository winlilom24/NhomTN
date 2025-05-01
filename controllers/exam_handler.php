<?php
require_once __DIR__ . '/question_functions.php';

function start_exam() {
    session_start();

    if (!isset($_SESSION['questions'])) {
        $_SESSION['questions'] = get_random_questions();
        $_SESSION['test_id'] = "test_" . time() . "_" . uniqid();
    }

    if (!isset($_SESSION['quiz_start_time'])) {
        $_SESSION['quiz_start_time'] = time();
        $_SESSION['quiz_duration'] = 60 * 60;
    }

    $cur_question = $_GET['question'] ?? 1;
    handle_exam_submit($cur_question);

    include __DIR__ . '/../views/exam.php';
}

function handle_exam_submit($cur_question) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['answer'])) {
            echo "<script>alert('Bạn chưa chọn đáp án!');</script>";
            return;
        }

        $_SESSION['answers'][$cur_question] = $_POST['answer'];

        if (isset($_POST['submit_answer'])) {
            header("Location: index.php?page=exam&question=" . ($cur_question + 1));
            exit();
        }

        if (isset($_POST['submit_test'])) {
            if (count($_SESSION['answers']) < 40) {
                echo "<script>alert('Bạn chưa làm đủ 40 câu!');</script>";
            } else {
                header("Location: index.php?page=submit");
                exit();
            }
        }
    }
}
