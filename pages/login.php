<?php
$title = "Inloggen";
include 'includes/header.php';
?>
<div class="container">
<?php
if (isset($_SESSION['loginmessage'])){
    if ($_SESSION['loginmessage'] == 1 && !isset($_SESSION['login'])){
        $_SESSION['loginmessage'] = 0;
        echo '<div class="danger">U moet inloggen om dat te kunnen doen.</div>';
    }
}
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    if (isset($_POST['submit'])) {
        include 'includes/connect.php';
        if (!empty($username = sanitize($_POST['username'], $conn)) && !empty($password = sanitize($_POST['password'], $conn))) {
            if (checkUsername($username, $conn)) {
                if (!empty($dbs_password = getPassword($username, $conn))) {
                    if (checkPassword($password, $dbs_password)) {
                        $_SESSION['login'] = 1;
                        $_SESSION['user_id'] = getUserId($username, $conn);
                        header('location:/');
                    } else {
                        echo '<div class="danger">Sorry, het wachtwoord is onjuist.</div>';
                    }
                }
            } else {
                echo '<div class="danger">Sorry, er is geen gebruiker gevonden met de username ' . $username . '</div>';
            }
        } else {
            echo '<div class="danger">U moet alle velden invullen.</div>';
        }
        mysqli_close($conn);
    }
}
else{
    header('location:/');
}
?>
    <form id="form" action="" method="post">
       <h1>Inloggen</h1><br>
        <label for="username">Gebruikersnaam: </label><input class="input" id="username" type="text" name="username" placeholder="Naam"><br>
        <label for="password">Wachtwoord: </label><input class="input" id="password" type="password" name="password" placeholder="Wachtwoord"><br>
        <input id="submit" type="submit" name="submit" value="Inloggen"><br><br>
        Heeft u nog geen account? klik <a id="registreerlink" href="/pages/registreer.php">hier</a> om te registreren.
    </form>
</div>