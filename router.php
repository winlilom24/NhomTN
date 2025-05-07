<?php
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        header('Location: views/home.php');
        break;
    case 'homeAfterLogin':
        header('Location: views/homeAfterLogin.php');
        break;
    case 'homeAdmin':
        header('Location: views/homeAdmin.php');
        break;
    case 'exam':
        require_once 'controllers/exam_handler.php';
        start_exam();
        break;
    case 'submit':
        require_once 'controllers/submit_handler.php';
        show_result();
        break;
    case 'reviewList':
        require_once 'controllers/review_handler.php';
        list_tests();
        break;
    case 'reviewDetail':
        require_once 'controllers/review_handler.php';
        show_test_detail($_GET['test_id']);
        break;
    case 'baiontap':
        require_once 'views/ontap.php';
        break;

    default:
        echo "404 Not Found";
}
