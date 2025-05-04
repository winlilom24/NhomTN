<?php
$page = $_GET['page'] ?? 'homeAdmin';

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
    case 'questionManager':
        header ('Location: views/questionManager.php');
        break;
    case 'studentlist':
        header ('Location: views/studentlist.php');
        break;
    case 'exam':
        require_once 'controllers/ExamController.php';
        ExamController::start();
        break;
    case 'submit':
        require_once 'controllers/SubmitController.php';
        SubmitController::showResult();
        break;
    case 'reviewList':
        require_once 'controllers/ReviewController.php';
        ReviewController::listTests();
        break;
    case 'reviewDetail':
        require_once 'controllers/ReviewController.php';
        ReviewController::showDetail($_GET['test_id']); 
        break;
        
    default:
        echo "404 Not Found";
}
?>