<?php
$path = $_SERVER['DOCUMENT_ROOT'];

session_start();

include($path . '/pages/includes/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?> | De Concurrent</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>
<header>
    <nav>
        <a id="logoimage" href="/">
            <img src="/images/logo.png" alt="Het logo van De Concurrent" width="200px" height="80px">
        </a>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/pages/shop.php">Shop</a></li>
            <li><a href="/pages/overons.php">Over ons</a></li>
            <li><a href="/pages/werkplaats.php">Werkplaats</a></li>
            <li><a href="/pages/contact.php">Contact</a></li>
            <?php
            if (isset($_SESSION['login'])){
                if ($_SESSION['login'] != 1){
                    echo '<li><a href="/pages/login.php">Inloggen</a></li>';
                }
                else{
                    echo '<li><a href="/pages/logout.php">Uitloggen</a></li>';
                    echo '<li id="winkelwagen"><a href="/pages/basket.php"><img src="/images/winkelwagen.png" alt="Winkelwagen"></a></li>';
                }
            }
            else{
                echo '<li><a href="/pages/login.php">Inloggen</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>