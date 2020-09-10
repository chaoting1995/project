<?php
$page_title = '新增資料';
$page_name = 'order-insert';
require __DIR__ . '/parts/__connect_db.php';
// require __DIR__ . '/parts/__admin_required.php';

$c_sql = "SELECT * FROM `take_time_select`";
$cates = $pdo->query($c_sql)->fetchAll();

?>
<?php require __DIR__ . '/parts/__html_head.php'; ?>
<style>
    /* 必填樣式 */
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
                        <h5 class="card-title">新增訂單</h5>
                        <!-- 不放標題 -->

                        <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                            <!--`sid`, `name`, `email`, `mobile`, `birthday`, `order_time`, `order_price`, `take_date`, `take_time`, `order_address` -->

                            <div class="form-group">
                                <label for="name"><span class="red-stars">**</span>名稱</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <!-- required，必填 -->
                                <small class="form-text error-msg"></small>
                                <!-- <small>，必填 -->
                            </div>

                            <div class="form-group">
                                <label for="mobile"><span class="red-stars">**</span>手機</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" pattern="09\d{2}-?\d{3}-?\d{3}" placeholder="09xx-xxx-xxx">
                                <!-- 手機的檢查設定：pattern，有填必須合格式 -->
                                <!-- "tel"電話或手機號碼，手機板鍵盤顯示會不同 -->
                                <small class="form-text error-msg"></small>
                            </div>

                            <div class="form-group">
                                <label for="email"><span class="red-stars">**</span>電郵</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <small class="form-text error-msg"></small>
                            </div>
                            <!-- google> email regexp -->
                            <!-- 或是老師的proj54> register.php> email pattern拷貝 -->

                            <div class="form-group">
                                <label for="birthday">生日</label>
                                <input type="date" class="form-control" id="birthday" name="birthday">
                            </div>

                            <div class="form-group">
                                <label for="order_price">訂單金額</label>
                                <input type="text" class="form-control" id="order_price" name="order_price">
                            </div>

                            <div class="form-group">
                                <label for="take_date">取餐日期</label>
                                <input type="date" class="form-control" id="take_date" name="take_date">
                            </div>

                            <div class="form-group">
                                <label for="take_time">取餐時間</label>
                                <select class="form-control" id="take_time" name="take_time">
                                    <?php foreach ($cates as $c) : ?>
                                        <option value="<?= $c['time_option'] ?>"><?= $c['time_option'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <div class="form-group">
                                <label for="order_address">取餐地址</label>
                                <textarea class="form-control" name="order_address" id="order_address" cols="30" rows="1"></textarea>
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
<?php include __DIR__ . '/parts/__scripts.php'; ?>
<script>
    // 表單輸入格式驗證
    const email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    const mobile_pattern = /^09\d{2}-?\d{3}-?\d{3}$/;
    const $name = document.querySelector('#name');
    const $email = document.querySelector('#email');
    const $mobile = document.querySelector('#mobile');
    const r_fields = [$name, $email, $mobile];
    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');

    function checkForm() {
        let isPass = true;
        // 預設條件通過，三欄都通過檢查，就送出(反過來說，只要一個錯誤就不送)
        r_fields.forEach(el => {
            el.style.borderColor = '#CCCCCC';
            el.nextElementSibling.innerHTML = '';
        });
        submitBtn.style.display = 'none';

        // TODO: 檢查資料格式
        // 先檢查必填的，字數<2，即不通過
        if ($name.value.length < 2) {
            isPass = false;
            $name.style.borderColor = 'red';
            $name.nextElementSibling.innerHTML = '請填寫正確的姓名';
        }

        if (!email_pattern.test($email.value)) {
            isPass = false;
            $email.style.borderColor = 'red';
            $email.nextElementSibling.innerHTML = '請填寫正確格式的電子郵箱';
        }

        if (!mobile_pattern.test($mobile.value)) {
            isPass = false;
            $mobile.style.borderColor = 'red';
            $mobile.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
        }

        // 如果通過，讓他發送fetch
        if (isPass) {
            const fd = new FormData(document.form1);
            // FormData()是沒有外觀的表單，會把資料塞進這裡


            // 不要讓他用傳統方式送出，會刷新清掉
            //萬一哪一欄要提醒妳再填寫，不會直接送出            
            fetch('order-insert-api.php', {
                    // 發資料給這支api
                    method: 'POST',
                    body: fd
                    // FormData()丟這裡
                })

                // .then(r => r.text()).then(r => console.log(r))
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infobar.innerHTML = '新增成功';
                        infobar.className = "alert alert-success";
                        // if(infobar.classList.contains('alert-danger')){
                        //     infobar.classList.replace('alert-danger', 'alert-success')
                        // }
                        setTimeout(() => {
                            location.href = 'order-manage.php';
                        }, 2000)
                    } else {
                        infobar.innerHTML = obj.error || '新增失敗';
                        infobar.className = "alert alert-danger";
                        // if(infobar.classList.contains('alert-success')){
                        //     infobar.classList.replace('alert-success', 'alert-danger')
                        // }
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

<!-- 本來的寫法 -->
<!-- <script>
    const fd = new FormData(document.form1);
    fetch('data-insert-api.php', {
            method: 'POST',
            body: fd
        })
        .then(r => r.text())
        .then(str => {
                console.log(str );  
</script> -->