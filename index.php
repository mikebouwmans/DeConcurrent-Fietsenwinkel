<?php
$title = "Home";
include $_SERVER['DOCUMENT_ROOT'] . '/pages/includes/header.php';

?>
<div class="container">
    <div class="index">
        <h1>De Concurrent</h1>
        <br>
        <hr>
        <br>
        <p>
            Wij verhuren fietsen aan particulieren en leveren desgewenst bij hotels, camping en B&amp;B in en rondom Nunteren. <br><br>
            Tevens kunt u bij ons terecht voor groepsarrangementen, voor u familie, bedrijf of vrienden – uitje. <br><br>
            U krijgt bij ons gratis fietsroutes die gemaakt zijn op het knooppunten netwerk.
        </p>
        <br>
        <hr>
        <img class="impressiefoto" src="images/concurrent1.jpg" alt="Impressiefoto">
        <div class="rij">
            <?php
            include $path . '/pages/includes/connect.php';
            getRandomImages($conn);
            ?>

        </div>
    </div>
</div>




