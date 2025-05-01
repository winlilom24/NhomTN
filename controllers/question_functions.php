<?php
function get_random_questions($limit = 40) {
    require_once __DIR__ . '/../core/Database.php';
    $sql = "SELECT * FROM cau_hoi ORDER BY RAND() LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    $questions = [];
    $index = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[$index++] = [
            'id' => $row['id'],
            'question' => $row['question'],
            'A' => $row['A'],
            'B' => $row['B'],
            'C' => $row['C'],
            'D' => $row['D'],
            'answer' => $row['answer']
        ];
    }
    return $questions;
}
