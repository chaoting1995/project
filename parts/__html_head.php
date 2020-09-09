<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= WEB_ROOT ?>/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= WEB_ROOT ?>/fontawesome/css/all.css">
    <!-- 這裡就能抓到我定義好的常數「WEB_ROOT」 -->
    <!-- 不用靠相對路徑 -->
    <!-- 也可以寫死，寫成：mfee09-proj/fontawesome/css/all.css">，但是如果發佈到server上，未必有 mfee09-proj的路徑-->
    <title><?= $page_title ?? '' ?></title>
    <!-- 如果有，就顯示，沒有就顯示空字串 -->
</head>

<body>