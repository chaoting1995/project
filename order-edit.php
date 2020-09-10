<?php
$page_title = '編輯訂單';
$page_name = 'order-edit';
require __DIR__ . '/parts/__connect_db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: order-manage.php');
    exit;
}

$sql = " SELECT * FROM order_manage WHERE sid=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: order-manage.php');
    exit;
}

$c_sql = "SELECT * FROM `take_time_select`";
$cates = $pdo->query($c_sql)->fetchAll();

?>
<?php require __DIR__ . '/parts/__html_head.php'; ?>
<style>
    span.red-stars {
        color: red;
    }

    small.error-msg {
        color: red;
    }
</style>
<?php include __DIR__ . '/parts/__navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-6">
                <div id="infobar" class="alert alert-success" role="alert" style="display: none">
                    A simple success alert—check it out!
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">編輯訂單</h5>
                        <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                            <!--`sid`, `name`, `email`, `mobile`, `birthday`, `order_time`, `order_price`, `take_date`, `take_time`, `order_address` -->
                            <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                            <div class="form-group">
                                <label for="name"><span class="red-stars">**</span>名稱</label>
                                <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($row['name']) ?>">
                                <small class="form-text error-msg"></small>
                            </div>

                            <div class="form-group">
                                <label for="mobile"><span class="red-stars">**</span>手機</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($row['mobile']) ?>" pattern="09\d{2}-?\d{3}-?\d{3}">
                                <small class="form-text error-msg"></small>
                            </div>

                            <div class="form-group">
                                <label for="email"><span class="red-stars">**</span>電郵</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlentities($row['email']) ?>">
                                <small class="form-text error-msg"></small>
                            </div>

                            <div class="form-group">
                                <label for="birthday">生日</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlentities($row['birthday']) ?>">
                            </div>
                            <!-- 
                            $_POST['name'],
                            $_POST['email'],
                            $_POST['mobile'],
                            $_POST['birthday'],
                            $_POST['order_price'],
                            $_POST['take_date'],
                            $_POST['take_time'],
                            $_POST['order_address'],
                             -->

                            <input type="hidden" class="form-control" id="order_time" name="order_time" value="<?= htmlentities($row['order_time']) ?>">

                            <div class="form-group">
                                <label for="order_price">訂單金額</label>
                                <input type="text" class="form-control" id="order_price" name="order_price" value="<?= htmlentities($row['order_price']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="take_date">取餐日期</label>
                                <input type="date" class="form-control" id="take_date" name="take_date" value="<?= htmlentities($row['take_date']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="take_time">取餐時間</label>
                                <select class="form-control" id="take_time" name="take_time" value="<?= htmlentities($row['take_time']) ?>">
                                    <?php foreach ($cates as $c) : ?>
                                        <option value=" <?= $c['time_option'] ?>" <?= $row['take_time'] == $c['time_option'] ? 'selected' : ''  ?>><?= $c['time_option'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="order_address">取餐地址</label>
                                <textarea class="form-control" name="order_address" id="order_address" cols="30" rows="1"><?= htmlentities($row['order_address']) ?></textarea>
                            </div>

                            <!--`order_time`, `order_price`, `take_time`, `order_address` -->

                            <button type="submit" class="btn btn-primary">送出
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<!-- `sid`, `order_time`, `order_price`, `take_time`, `order_address` -->



<?php include __DIR__ . '/parts/__scripts.php'; ?>
<script>
    const $order_time = document.querySelector('#order_time');
    const $order_price = document.querySelector('#order_price');
    const $take_time = document.querySelector('#take_time');
    const r_fields = [$order_time, $order_price, $take_time];
    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');

    function checkForm() {
        let isPass = true;

        // r_fields.forEach(el => {
        //     el.style.borderColor = '#CCCCCC';
        //     el.nextElementSibling.innerHTML = '';
        // });
        // submitBtn.style.display = 'none';
        // // TODO: 檢查資料格式
        // if ($name.value.length < 2) {
        //     isPass = false;
        //     $order_time.style.borderColor = 'red';
        //     $order_time.nextElementSibling.innerHTML = '請填寫正確的姓名';
        // }

        // if (!order_price_pattern.test($order_price.value)) {
        //     isPass = false;
        //     $order_price.style.borderColor = 'red';
        //     $order_price.nextElementSibling.innerHTML = '請填寫正確格式的電子郵箱';
        // }

        // if (!mobile_pattern.test($take_time.value)) {
        //     isPass = false;
        //     $take_time.style.borderColor = 'red';
        //     $take_time.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
        // }

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('order-edit-api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infobar.innerHTML = '修改成功';
                        infobar.className = "alert alert-success";

                        setTimeout(() => {
                            location.href = 'order-manage.php';
                        }, 2000)


                    } else {
                        infobar.innerHTML = obj.error || '資料沒有修改';
                        infobar.className = "alert alert-danger";
                        submitBtn.style.display = 'block';
                    }
                    infobar.style.display = 'block';
                });

        } else {
            submitBtn.style.display = 'block';
        }
    }
</script>
<?php include __DIR__ . '/parts/__html_foot.php'; ?>