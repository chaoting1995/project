<?php
$page_title = '購物清單';
$page_name = 'shopping-list';
require __DIR__ . '/parts/__connect_db.php';

$perPage = 5; 

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) FROM `shopping_list`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];


if ($totalRows > 0) {
    if ($page < 1) {
        header('Location: shopping-list.php');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: shopping-list.php?page=' . $totalPages);
        exit;
    };

    $sql = sprintf("SELECT * FROM `shopping_list` ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

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
        <!--`sid`, `product_image`, `product_name`, `product_price`, `product_count` -->
        <!-- 拷貝欄位名稱，放這裡取用 -->
        
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    
                    <td><?= $r['sid'] ?></td>
                    <td><img src="" alt=""></td>
                    <td><?= $r['product_name'] ?></td>
                    <td><?= $r['product_price'] ?></td>
                    <td><?= $r['product_count'] ?></td>
                    <td><a href="#"><i class="fas fa-edit"></i></a></td>
                    <td>
                        <a href="javascript:delete_it(<?= $r['sid'] ?>)">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <!-- php foreach結束在這裡 -->
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<?php include __DIR__ . '/parts/__scripts.php'; ?>
<script>
    function delete_it(sid) {
        if (confirm(`是否要刪除編號為 ${sid} 的資料???`)) {
            location.href = 'data-delete.php?sid=' + sid;
        }
    }
</script>
<?php include __DIR__ . '/parts/__html_foot.php'; ?>