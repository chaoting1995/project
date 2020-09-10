<?php
$page_title = '購物清單';
$page_name = 'shopping-cart';
require __DIR__ . '/parts/__connect_db.php';

$perPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;


$t_sql = "SELECT COUNT(1) FROM `shopping_cart`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];


if ($totalRows > 0) {
    if ($page < 1) {
        header('Location: shopping-cart.php');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: shopping-cart.php?page=' . $totalPages);
        exit;
    };

    $sql = sprintf("SELECT * FROM `shopping_cart` ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);


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
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">圖片</th>
                <th scope="col">品名</th>
                <th scope="col">價格</th>
                <th scope="col">數量</th>
                <!-- <th scope="col"><i class="fas fa-edit"></i></th> -->
                <th scope="col"><i class="fas fa-trash-alt"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>

                        <td><input type="hidden" id="sid" name="sid" value="<?= $r['sid'] ?>"><?= $r['sid'] ?></td>

                        <td><input type="hidden" id="product_image" name="product_image" value="<?= $r['product_image'] ?>"><img src="<?= htmlentities($r['product_image']) ?>" alt="" width="100px"></td>

                        <td><input type="hidden" id="product_name" name="product_name" value="<?= $r['product_name'] ?>"><?= $r['product_name'] ?></td>

                        <td><input type="hidden" id="product_price" name="product_price" value="<?= $r['product_price'] ?>"><?= $r['product_price'] ?></td>

                        <!-- 計數器 -->
                        <td>
                            <div class="form-group form-row">
                                <input type="number" class="form-control col-3" id="product_count" name="product_count" value="<?= $r['product_count'] ?>">
                                <button type="submit" class="btn btn-primary">送出
                                </button>
                            </div>


                    </td>
                    <!-- <td><a href="#"><i class="fas fa-edit"></i></a></td> -->
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
    const submitBtn = document.querySelector('button[type=submit]');

    // function checkForm() {

    //     const fd = new FormData(document.form1);

    //     fetch('shopping-cart-api.php', {
    //             method: 'POST',
    //             body: fd
    //         })
    //         .then(r => r.json())
    //         .then(obj =>
    //             if (obj.success) {
    //             console.log(obj)
    //             ;} )
    // }

    function checkForm(obj) {

        console.log(obj.form1.value)
    }

    // }ˇˇˇˇˇˇ
    //     function checkForm() {
    //         let isPass = true;


    //         const fd = new FormData(document.form1);

    //         fetch('shopping-cart-api.php', {
    //                 method: 'POST',
    //                 body: fd
    //             })
    //             .then(r => r.json())
    //             .then(obj => {});
    //     }


    function delete_it(sid) {
        if (confirm(`是否要刪除編號為 ${sid} 的資料???`)) {
            location.href = 'shopping-cart-delete.php?sid=' + sid;
        }
    }
</script>


<?php include __DIR__ . '/parts/__html_foot.php'; ?>