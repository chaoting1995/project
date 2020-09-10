<?php
if (!isset($page_name)) $page_name = '';
?>
<!-- 假如沒定義到，這個是保險 -->
<!-- 有設，給空字串 -->
<!-- 沒設，給$page_name -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">C食堂</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item <?= $page_name == 'shopping-cart' ? 'active' : '' ?>">
                    <!-- 什麼狀況我要去顯示active? -->
                    <!-- 當$page_name == 'data-list'，三元運算子，顯示active，否則顯示空字串 -->

                    <a class="nav-link" href="<?= WEB_ROOT ?>/shopping-cart.php">購物車</a>
                    <!-- 修改 -->
                    <!-- WEB_ROOT，引入data-list.php-->
                </li>

                <li class="nav-item <?= $page_name == 'order-manage' ? 'active' : '' ?>">
                    <!-- 什麼狀況我要去顯示active? -->
                    <!-- 當$page_name == 'data-list'，三元運算子，顯示active，否則顯示空字串 -->

                    <a class="nav-link" href="<?= WEB_ROOT ?>/order-manage.php">訂單管理</a>
                    <!-- 修改 -->
                    <!-- WEB_ROOT，引入data-list.php-->
                </li>

                <li class="nav-item <?= $page_name == 'order-insert' ? 'active' : '' ?>">
                    <!-- 什麼狀況我要去顯示active? -->
                    <!-- 當$page_name == 'data-insert'，三元運算子，顯示active，否則顯示空字串 -->
                    <a class="nav-link" href="<?= WEB_ROOT ?>/order-insert.php">新增訂單</a>
                    <!-- WEB_ROOT，引入data-insert.php"-->
                </li>

            </ul>

            <ul class="navbar-nav">
                <?php if (isset($_SESSION['admin'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link"><?= $_SESSION['admin']['nickname'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= WEB_ROOT ?>/logout.php">登出</a>
                    </li>

                <?php else : ?>
                    <li class="nav-item <?= $page_name == 'login' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= WEB_ROOT ?>/login.php">登入</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<style>
    .navbar .nav-item.active {
        /* <nav>裡面的<li> */
        background-color: #7abaff;
        border-radius: 10px;
        /* 選取到的時候會變色 */
        /* 選到列表 */
    }
</style>