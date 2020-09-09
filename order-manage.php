<?php
$page_title = '訂單管理';
$page_name = 'order-manage';
require __DIR__. '/parts/__connect_db.php';

$perPage = 10; // 每頁有幾筆資料

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) FROM `order_manage`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// die('~~~'); //exit; // 結束程式
$totalPages = ceil($totalRows/$perPage);

$rows = [];
if($totalRows > 0){
    if($page < 1){
        header('Location: order-manage.php');
        exit;
    }
    if($page > $totalPages){
        header('Location: order-manage.php?page='. $totalPages);
        exit;
    };

    $sql = sprintf("SELECT * FROM `order_manage` ORDER BY sid DESC LIMIT %s, %s", ($page-1)*$perPage, $perPage);
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
}
# 正規表示式
// https://developer.mozilla.org/zh-TW/docs/Web/JavaScript/Guide/Regular_Expressions
?>
<?php require __DIR__. '/parts/__html_head.php'; ?>
<?php include __DIR__. '/parts/__navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page==1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>
                    <?php for($i=$page-3; $i<=$page+3; $i++):
                        if($i<1) continue;
                        if($i>$totalPages) break;
                        ?>
                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page==$totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>


    <table class="table table-striped">
        <!-- `sid`, `name`, `email`, `mobile`, `birthday`, `order_time`, `order_price`, `take_date`, `take_time`, `order_address` -->
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">姓名</th>
            <th scope="col">電郵</th>
            <th scope="col">手機</th>
            <th scope="col">生日</th>
            <th scope="col">下單時間</th>
            <th scope="col">訂單金額</th>
            <th scope="col">取餐日期</th>
            <th scope="col">取餐時間</th>
            <th scope="col">取餐地址</th>
            <th scope="col"><i class="fas fa-edit"></i></th>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
            <td><?= $r['sid'] ?></td>
            <td><?= $r['name'] ?></td>
            <td><?= $r['email'] ?></td>
            <td><?= $r['mobile'] ?></td>
            <td><?= $r['birthday'] ?></td>
            <td><?= $r['order_time'] ?></td>
            <td><?= $r['order_price'] ?></td>
            <td><?= $r['take_date'] ?></td>
            <td><?= $r['take_time'] ?></td>
            <td><?= $r['order_address'] ?></td>

            <td><a href="order-edit.php?sid=<?= $r['sid'] ?>"><i class="fas fa-edit"></i></a></td>
            <td><a href="javascript:delete_it(<?= $r['sid'] ?>)">
                    <i class="fas fa-trash-alt"></i>
                </a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
<?php include __DIR__. '/parts/__scripts.php'; ?>
<script>
    function delete_it(sid){
        if(confirm(`是否要刪除編號為 ${sid} 的資料???`)){
            location.href = 'order-delete.php?sid=' + sid;
        }
    }

</script>
<?php include __DIR__. '/parts/__html_foot.php'; ?>


