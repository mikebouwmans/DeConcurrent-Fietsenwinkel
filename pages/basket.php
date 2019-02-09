<?php
$title = 'Winkelmand';
include 'includes/header.php';
checkLogin();
?>
<div class="container">
    <h1>Uw Winkelmandje</h1>
    <hr>
    <div class="cart">
        <?php
        if (isset($_POST['addorder'])){
            include 'includes/connect.php';
            addOrderToDatabase($_SESSION['user_id'], $conn);
            mysqli_close($conn);
        }
        include 'includes/connect.php';
        showBasketOrders($conn);
        mysqli_close($conn);

        ?>
    </div>
</div>
