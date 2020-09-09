<?php
$page_title = '登入';
$page_name = 'login';
require __DIR__ . '/parts/__connect_db.php';

?>
<?php include __DIR__ . '/parts/__html_head.php'; ?>
<?php include __DIR__ . '/parts/__navbar.php'; ?>

    <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <form method="post" name="form1">
                        <div class="form-group">
                            <label for="account">Account </label>
                            <input type="text" class="form-control" id="account" name="account">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
    </div>


<script src="./lib/jquery-3.5.1.min.js "></script>
<script src="./bootstrap/js/bootstrap.js"></script>
</body>

</html>