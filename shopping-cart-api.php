<?php
require __DIR__ . '/parts/__connect_db.php';
// require __DIR__ . '/parts/__admin_required.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

// `sid`, `product_image`, `product_name`, `product_price`, `product_count`
$sql = "UPDATE `shopping_cart` SET
    `product_image`=?,
    `product_name`=?,
    `product_price`=?,
    `product_count`=?
    WHERE `sid`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['product_image'],
    $_POST['product_name'],
    $_POST['product_price'],
    $_POST['product_count'],
    $_POST['sid'],

]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
