<?php
// 不提供頁面，沒有html
// 表單送入資料送入「data-insert-api.php」，轉成JSON格式送回「data-insert.php」
require __DIR__ . '/parts/__connect_db.php';

header('Content-Type: application/json');
// TODO: 檢查資料格式

$output = [
        'success' => false,
        'postData' => $_POST,
        'code' => 0,
        'error' => ''
];

// TODO: 檢查資料格式
// email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
// mobile_pattern = /^09\d{2}-?\d{3}-?\d{3}$/;



// if (mb_strlen($_POST['name']) < 2) {
//         $output['code'] = 410;
//         $output['error'] = '姓名長度要大於 2';
//         echo json_encode($output, JSON_UNESCAPED_UNICODE);
//         exit;
// }

// if (!preg_match('/^09\d{2}-?\d{3}-?\d{3}$/', $_POST['mobile'])) {
//         $output['code'] = 420;
//         $output['error'] = '手機號碼格式錯誤';
//         echo json_encode($output, JSON_UNESCAPED_UNICODE);
//         exit;
// }

// `sid`, `name`, `email`, `mobile`, `birthday`, `order_time`, `order_price`, `take_date`, `take_time`, `order_address`
$sql = "INSERT INTO `order_manage`(
`name`, `email`, `mobile`, `birthday`, 
`order_time`, 
`order_price`, 
`take_date`, `take_time`, 
`order_address`) 
VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['mobile'],
        $_POST['birthday'],
        $_POST['order_price'],
        $_POST['take_date'],
        $_POST['take_time'],
        $_POST['order_address'],
]);

if ($stmt->rowCount()) {
        $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
