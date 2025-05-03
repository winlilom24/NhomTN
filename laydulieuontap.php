<?php
// Lấy 100 câu đầu chương 1
$sql1 = "SELECT * FROM cau_hoi WHERE chapter = 1 ORDER BY id ASC LIMIT 100;";
// Lấy 100 câu tiếp theo cho chương 2
$sql2 = "SELECT * FROM cau_hoi WHERE chapter = 2 ORDER BY id ASC LIMIT 100;";
// Lấy 100 câu tiếp theo cho chương 3
$sql3 = "SELECT * FROM cau_hoi WHERE chapter = 3 ORDER BY id ASC LIMIT 100;";
