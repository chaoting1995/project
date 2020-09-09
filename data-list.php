<?php
$page_title = '資料列表';
$page_name = 'data-list';
require __DIR__ . '/parts/__connect_db.php';

$perPage = 5; 

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) FROM `order_history`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];


if ($totalRows > 0) {
    if ($page < 1) {
        header('Location: data-list.php');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: data-list.php?page=' . $totalPages);
        exit;
    };

    $sql = sprintf("SELECT * FROM `order_history` ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
}

?>
<?php require __DIR__ . '/parts/__html_head.php'; ?>
<?php include __DIR__ . '/parts/__navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 3; $i <= $page + 3; $i++) :
                        if ($i < 1) continue;
                        if ($i > $totalPages) break;
                    ?>

                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>


                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <table class="table table-striped">
        <!-- `sid`, `order_time`, `order_price`, `take_time`, `order_address` -->
        <!-- 拷貝欄位名稱，放這裡取用 -->
        <thead>
            <tr>
                <th scope="col"><i class="fas fa-trash-alt"></i></th>
                <th scope="col"><i class="fas fa-user-times"></i></th>
                <th scope="col">訂單編號</th>
                <th scope="col">下單時間</th>
                <th scope="col">訂單價格</th>
                <th scope="col">取餐時間</th>
                <th scope="col">取餐地點</th>
                <th scope="col"><i class="fas fa-edit"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><a href="data-delete.php?sid=<?= $r['sid'] ?>" onclick="ifDel(event)" data-sid="<?= $r['sid'] ?>">
                            <i class="fas fa-trash-alt"></i>
                            <!-- 放一個垃圾桶icon -->
                        </a></td>
                    <td><a href="javascript:delete_it(<?= $r['sid'] ?>)">
                            <i class="fas fa-user-times"></i>
                        </a></td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['order_time'] ?></td>
                    <td><?= $r['order_price'] ?></td>
                    <td><?= $r['take_time'] ?></td>
                    <td><?= $r['order_address'] ?></td>


                    <td><a href="#"><i class="fas fa-edit"></i></a></td>
                </tr>
                <!-- php foreach結束在這裡 -->
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<?php include __DIR__ . '/parts/__scripts.php'; ?>
<script>
    function ifDel(event) {
        const a = event.currentTarget;
        console.log(event.target, event.currentTarget);
        const sid = a.getAttribute('data-sid');
        if (!confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
            event.preventDefault(); // 取消連往 href 的設定
        }
    }

    function delete_it(sid) {
        if (confirm(`是否要刪除編號為 ${sid} 的資料???`)) {
            location.href = 'data-delete.php?sid=' + sid;
        }
    }
</script>
<?php include __DIR__ . '/parts/__html_foot.php'; ?>