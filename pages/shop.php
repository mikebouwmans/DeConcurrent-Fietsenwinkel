<?php
$title = "Shop";
include 'includes/header.php';
include 'includes/connect.php';

?>
<div class="container">
    <h1>Artikelen</h1>
    <hr>
    <div class="allproducts">
        <div class="rij">
            <?php
            showAllProducts($conn);
            ?>
        </div>
    </div>
</div>
