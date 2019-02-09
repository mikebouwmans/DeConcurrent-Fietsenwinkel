<?php
session_start();
$_SESSION['login'] = 0;
unset($_SESSION['login']);
unset($_SESSION['basket']);
session_destroy();
header('location:/');