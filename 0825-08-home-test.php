<?php
$page_title = '首頁';
// 裡面的$page_title會吃到這個
// 「__DIR__ 」，當下的資料夾
require __DIR__ . '/parts/__connect_db.php';
?>
<?php require __DIR__ . '/parts/__html_head.php'; ?>
<?php include __DIR__ . '/parts/__navbar.php'; ?>
<!-- 包含其他頁面進來，用 include + 引用資料夾位置 -->

<div class="container">
    <h2>Hello~</h2>

</div>
<?php include __DIR__ . '/parts/__scripts.php'; ?>
<?php include __DIR__ . '/parts/__html_foot.php'; ?>

<!-- 功能：可以讓好幾個頁面，吃一個HTML

include、require兩個都可以
include、require相當於備份檔案，貼到此處
錯誤等級不同
→ include：有錯誤，照樣執行
→ require：我一定要有這個東西，沒有會出錯

連資料庫較重要，會用require