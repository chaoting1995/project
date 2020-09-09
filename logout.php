<?php

session_start();

unset($_SESSION['user']);

header('Location: 0825-06-login.php'); //redirect//轉向，轉到別的網址
