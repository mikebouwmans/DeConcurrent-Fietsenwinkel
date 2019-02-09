<?php

function sanitize($input, $conn){
    $input = trim($input);
    $strlenght = strlen($input);
    for($i = 0; $i <= $strlenght; $i++ ) {
        $input = stripslashes($input);
    }
    $input = htmlspecialchars($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

function getRandomImages($conn){
    if ($stmt = mysqli_prepare($conn, "select id, merk, name, image, modeljaar from products ORDER BY RAND() LIMIT 3")){
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $merk, $name, $image, $modeljaar);
        while (mysqli_stmt_fetch($stmt)){

            echo '<div class="grid-kolom-4">
            <div class="inner">
                <h4><a href="/pages/product.php?id=' . $id . '">' . $merk . ' ' . $name . '</a></h4>
                <a href="/pages/product.php?id=' . $id . '"><img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="' . $merk .  '"/></a>
                <a class="button" href="/pages/product.php?id=' . $id . '">Meer info</a>
            </div>
        </div>';
        }
        mysqli_stmt_close($stmt);
    }
}

function checkUsername($username, $conn){

    if ($stmt2 = mysqli_prepare($conn, "select username from users where username = ?")){
        mysqli_stmt_bind_param($stmt2, "s", $username);

        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_result($stmt2, $uname);
        mysqli_stmt_store_result($stmt2);
        if(mysqli_stmt_num_rows($stmt2) > 0){
            mysqli_stmt_close($stmt2);
            return true;
        }
        mysqli_stmt_close($stmt2);

    }
    return false;

}

function setUser($username, $password, $firstname, $lastname, $adres, $postcode, $plaats, $telnr, $conn){
    if ($stmt2 = mysqli_prepare($conn, "INSERT INTO users (username, password, firstname, lastname, adres, postcode, plaats, telefoon) VALUES (?,?,?,?,?,?,?,?)")){
        /* bind statement parameters */
        mysqli_stmt_bind_param($stmt2, "ssssssss", $username, $password, $firstname, $lastname, $adres, $postcode, $plaats, $telnr);

        /* execute query */
        if(mysqli_stmt_execute($stmt2)){
            mysqli_stmt_close($stmt2);
            return true;
        }

        /* close statement */
        mysqli_stmt_close($stmt2);

    }

    return false;
}

function getPassword($username, $conn){
    if ($stmt2 = mysqli_prepare($conn, "select password from users where username = ?")){
        /* bind statement parameters */
        mysqli_stmt_bind_param($stmt2, "s", $username);

        /* execute query */
        mysqli_stmt_execute($stmt2);

        //resultaten worden gebonden
        mysqli_stmt_bind_result($stmt2, $password);
        mysqli_stmt_fetch($stmt2);

        /* close statement */
        mysqli_stmt_close($stmt2);
        return $password;
    }

}

function getUserId($username, $conn){
    if ($stmt2 = mysqli_prepare($conn, "select user_id from users where username = ?")){
        mysqli_stmt_bind_param($stmt2, "s", $username);

        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_result($stmt2, $user_id);

        mysqli_stmt_fetch($stmt2);

        mysqli_stmt_close($stmt2);

        return $user_id;
    }
}
function checkPassword($user_pass, $hashed_pass){
    if (password_verify($user_pass, $hashed_pass)) {
        return true;
    }
    return false;

}
function showAllProducts($conn){
    if ($stmt = mysqli_prepare($conn, "select * from products")){

        mysqli_stmt_execute($stmt);
        $int = 0;
        mysqli_stmt_bind_result($stmt, $product_id, $merk, $name, $price, $actie, $black, $green, $pink, $white, $model, $modelyear, $image, $description);

        while (mysqli_stmt_fetch($stmt)){
            $int++;
            echo '<div class="grid-kolom-4">
            <div class="inner">
                <h4><a href="/pages/product.php?id=' . $product_id . '">' . $merk . ' ' . $name . '</a></h4>
                <a href="/pages/product.php?id=' . $product_id . '"><img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="' . $merk .  '"/></a>
                <div>Prijs: €' . $price . ',-<br>
                ' . $modelyear . ' Editie</div>
                <a class="button" href="/pages/product.php?id=' . $product_id . '">Bestellen</a>
            </div>
        </div>';
            if ($int == 3){
                echo '<div class="line"></div>';
            }

        }
        mysqli_stmt_close($stmt);
    }

}
function checkLogin(){
    if ($_SESSION['login'] == 1) {
        $_SESSION['loginmessage'] = 0;
    }
    else{
        $_SESSION['loginmessage'] = 1;
        header('location:/pages/login.php');
    }
}
function addProductToSession($product_id){
    if (isset($_SESSION['basket'])) {
        if (!isset($_SESSION['basket'][$product_id])){
            $_SESSION['basket'][$product_id] = 0;
        }
        $aantal = $_SESSION['basket'][$product_id];
        $aantal++;
        $_SESSION['basket'][$product_id] = $aantal;
    } else {
        $_SESSION['basket'] = array();
        if (!isset($_SESSION['basket'][$product_id])){
            $_SESSION['basket'][$product_id] = 0;
        }
        $aantal = $_SESSION['basket'][$product_id];
        $aantal++;
        $_SESSION['basket'][$product_id] = $aantal;
    }
}
function showBasketOrders($conn){
    if (isset($_SESSION['basket'])) {
        if (isset($_POST['aantal']) && isset($_POST['id'])){
            if (checkProductID($id = sanitize($_POST['id'], $conn), $conn)){
                if (is_numeric($aantal = sanitize($_POST['aantal'], $conn))){
                    $_SESSION['basket'][$id] = $aantal;
                }
            }
        }
        $totalprice = 0;
        $totalqty = 0;
        echo "<table class='table'>";
        echo "<tr>";
        echo "<th>Image</th>";
        echo "<th>Artikel</th>";
        echo "<th>Prijs</th>";
        echo "<th>Aantal</th>";
        echo "</tr>";
        echo '<br>';
        while (current($_SESSION['basket'])) {
            $id = key($_SESSION['basket']);
            if ($stmt = mysqli_prepare($conn, "SELECT id, name, merk, price, image FROM products WHERE id = ?")) {
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id, $naam, $merk, $price, $image);
                mysqli_stmt_fetch($stmt);
                $totalprice += $price;
                $totalqty += $_SESSION['basket'][$id];
                echo '<tr>';
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="' . $merk . '"/></td>';
                echo '<td>' . $merk . ' - ' . $naam . '</td>';
                echo '<td>€' . $price . ',-</td>';
                echo '<td><form action="" method="post"><input type="hidden" name="id" value="' . $id . '"><select name="aantal" id="" onchange="this.form.submit()">';
                for ($i = 1; $i < 1000; $i++){
                    if ($i == $_SESSION['basket'][$id]){
                        echo '<option selected value="' . $i , '">' . $i , '</option>';
                    }
                    else{
                        echo '<option value="' . $i , '">' . $i , '</option>';
                    }
                }
                echo '</select></form></td>';
                echo '</tr>';

                mysqli_stmt_close($stmt);
            }
            next($_SESSION['basket']);
        }
        echo '<tr>';
        echo '<td></td>';
        echo '<td>Totaal: €' . ($totalprice * $totalqty) . ',-</td>';
        echo '<td>Aantal: ' . $totalqty . '</td>';
        echo '<td><form action="" method="post"><input type="submit" name="addorder" value="Afrekenen"></form></td>';

        echo "</table>";

    }
    else {
        echo '<div>U heeft nog niks in uw winkelwagen, klik <a href="/pages/shop.php">hier </a>om te winkelen.</div>';
    }
}
function addOrderToDatabase($user_id, $conn){
    if ($stmt = mysqli_prepare($conn, "select max(order_number) from orders")){

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $ordernumber);

        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);
        $ordernumber++;
        if (isset($_SESSION['basket'])) {
            $bool = true;
            foreach ($_SESSION['basket'] as $key => $values) {
                if ($stmt = mysqli_prepare($conn, "INSERT INTO orders (order_number, user_id, product_id, quantity) VALUES (?, ?, ?, ?)")) {
                    //values = QTY
                    //key is the index
                    mysqli_stmt_bind_param($stmt, 'iiii', $ordernumber, $user_id, $key, $values);
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_close($stmt);
                }
                else{
                    $bool = false;
                }
            }
            unset($_SESSION['basket']);
        }
        if (!isset($_SESSION['basket']) || $bool) {
            echo '<div class="success">Uw bestelling is succesvol doorgevoert.</div>';
        }
        else{
            echo '<div>U heeft nog niks in uw winkelwagen, klik <a href="/pages/shop.php">hier </a>om te winkelen.</div>';
        }
    }
}
function checkProductID($id, $conn){
    if ($stmt2 = mysqli_prepare($conn, "SELECT id FROM products WHERE id = ?")){
        mysqli_stmt_bind_param($stmt2, "i", $id);

        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_result($stmt2, $id);

        mysqli_stmt_store_result($stmt2);
        if (mysqli_stmt_num_rows($stmt2) > 0){
            mysqli_stmt_close($stmt2);
            return true;
        }
        mysqli_stmt_close($stmt2);
    }
    return false;
}