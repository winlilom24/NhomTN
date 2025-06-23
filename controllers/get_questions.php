<?php
require_once __DIR__ . '/../core/Database.php';       

//lấy gói câu hỏi theo phân trang
$sodongtrentrang = 25;
$page = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
$sql = "SELECT * FROM cau_hoi";
$result = mysqli_query($conn, $sql);
$sodongdulieu= mysqli_num_rows($result);
$sotrangdl= ceil($sodongdulieu/$sodongtrentrang);
$vtbd = ($page-1) *$sodongtrentrang;
$sqltheotrang = "SELECT * FROM cau_hoi ORDER BY id DESC LIMIT {$vtbd}, {$sodongtrentrang}";
$kqpt = mysqli_query($conn,$sqltheotrang);
$stt = $vtbd +1;

while ($row = mysqli_fetch_assoc($kqpt)) {
    echo "<tr data-id='{$row['id']}'>";
    echo "<td style='padding: 10px; text-align: center;'>$stt</td>";
    echo "<td class='question'>{$row['question']}</td>";
    echo "<td class='A'>{$row['A']}</td>";
    echo "<td class='B'>{$row['B']}</td>";
    echo "<td class='C'>{$row['C']}</td>";
    echo "<td class='D'>{$row['D']}</td>";
    echo "<td class='answer'>{$row['answer']}</td>";
    echo "<td class='chapter'>{$row['chapter']}</td>";
    echo "<td>
            <button class='editBtn'>✏️</button>
            <button class='deleteBtn'>🗑️</button>
          </td>";
    echo "</tr>";
    $stt++;
}

if (mysqli_num_rows($kqpt) == 0) {
    echo "<tr><td colspan='9' style='padding: 10px; text-align: center;'>Không có dữ liệu</td></tr>";
}

//tạo biến siêu toàn cục để phân trang trong questionManager.php 
$GLOBALS['sotrangdl'] = $sotrangdl;
$GLOBALS['page'] = $page;
?>
