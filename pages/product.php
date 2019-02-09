<?php
$title = 'Bestellen';
include 'includes/header.php';
if (isset($_GET['id'])) {
    include 'includes/connect.php';

    $id = sanitize($_GET['id'], $conn);
    if (!empty($id) && is_numeric($id)) {
        if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?")) {
            mysqli_stmt_bind_param($stmt2, "i", $id);

            mysqli_stmt_execute($stmt2);

            mysqli_stmt_bind_result($stmt2, $product_id, $merk, $name, $price, $actie, $black, $green, $pink, $white, $model, $modelyear, $image, $desctiption);
            mysqli_stmt_fetch($stmt2);

            mysqli_stmt_close($stmt2);
        }
    }
    else{
        header('location:/');
    }
    mysqli_close($conn);
}
?>
<style>
    .bold{
        font-weight: bold;
    }
</style>
<div class="container">
    <h1><?php echo $name?></h1>
    <hr>
    <div class="products">
        <div class="rij">
            <?php
            if (isset($_POST['bestel'])){
                include 'includes/connect.php';
                checkLogin();
                $id = sanitize($_POST['bestel'], $conn);
                if (is_numeric($id)){
                    if (checkProductID($id, $conn)){
                        addProductToSession($id);
                        echo '<div class="success grid-kolom-12">Dit product is toegevoegt aan uw winkelmand, klik&nbsp<a href="/pages/basket.php">hier</a> &nbspom je winkelmand te bekijken</div>';
                    }
                    else{
                        echo '<div class="danger">Dit is geen geldig product</div>';
                    }
                }
                else{
                    echo '<div class="danger">Dit is geen geldig product</div>';
                }
            }
            ?>
            <div class="grid-kolom-8">
                <?php
                echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="' . $merk .  '"/>';
                ?>
            </div>
            <div class="grid-kolom-4">
                <div class="productinfo">
                    <h2>
                        <?php echo $merk;?>
                    </h2>
                    <?php echo $name;?>
                    <hr>
                    <div class="description">
                        <?php echo $desctiption;?>
                    </div>
                    <hr>
                    Prijs:
                    <span class="bold">
                        €<?php echo $price;?>,-<br><br>
                    </span>
                    <form action="" method="post">
                        <label for="color">Kleur(en) beschikbaar: </label>
                        <select name="color" id="color">
                            <?php
                            if ($black != 0){
                                echo '<option value="black">Zwart</option>';
                            }
                            if ($green != 0){
                                echo '<option value="green">Groen</option>';
                            }
                            if ($pink != 0){
                                echo '<option value="pink">Roze</option>';
                            }
                            if ($white != 0){
                                echo '<option value="white">Wit</option>';
                            }
                            ?>
                        </select><br>
                        <button class="button" name="bestel" value="<?php echo $product_id;?>">Bestellen</button><br>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

