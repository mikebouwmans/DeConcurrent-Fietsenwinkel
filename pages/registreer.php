<?php
$title = "Registreren";
include 'includes/header.php';
?>

<div class="container">
    <?php
    if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
        if (isset($_POST['submit'])) {
            include 'includes/connect.php';
            if (!empty($username = sanitize($_POST['username'], $conn))
                && !empty($password = password_hash($_POST['password'], PASSWORD_DEFAULT))
                && !empty($firstname = sanitize($_POST['firstname'], $conn))
                && !empty($lastname = sanitize($_POST['lastname'], $conn))
                && !empty($adres = sanitize($_POST['adres'], $conn))
                && !empty($postcode = sanitize($_POST['postcode'], $conn))
                && !empty($plaats = sanitize($_POST['plaats'], $conn))
                && !empty($telefoon = sanitize($_POST['telefoon'], $conn))) {
                if (checkUsername($username, $conn)) {
                    echo '<div class="danger">Sorry, er is al een gebruiker gevonden met de gebruikersnaam: ' . $username . '. Kies een andere gebruikersnaam.</div>';
                } else {
                    if(setUser($username, $password, $firstname, $lastname, $adres, $postcode, $plaats, $telefoon, $conn))
                    {
                        header('Location:/pages/login.php');
                    } else {
                        echo '<div class="danger">Er is iets fout gegaan.</div>';
                    }
                }
            } else {
                echo '<div class="danger">U moet alle velden invullen.</div>';
            }
            mysqli_close($conn);
        }
    }
    else{
        echo '<div class="danger">U bent al ingelogd.</div>';
    }
    ?>
    <form id="form" action="" method="post">
       <h1>Registreren</h1><br>
        <label for="un">Gebruikersnaam:</label><input class="input" type="text" id="un" name="username" placeholder="Gebruikersnaam" maxlength="50"><br>
        <label for="pd">Wachtwoord:</label><input class="input" type="password" id="pd" name="password" placeholder="Wachtwoord"><br>
        <label for="vn">Voornaam:</label><input class="input" type="text" id="vn" name="firstname" placeholder="Voornaam" maxlength="30"><br>
        <label for="an">Achternaam:</label><input class="input" type="text" id="an" name="lastname" placeholder="Achternaam" maxlength="30"><br>
        <label for="ad">Adres:</label><input class="input" type="text" id="ad" name="adres" placeholder="Adres"><br>
        <label for="pc">Postcode:</label><input class="input" type="text" id="pc" name="postcode" placeholder="Postcode" maxlength="6"><br>
        <label for="pl">Plaatsnaam:</label><input class="input" type="text" id="pl" name="plaats" placeholder="Plaats" maxlength="35"><br>
        <label for="tn">Telefoonnr:</label><input class="input" type="text" id="tn" name="telefoon" placeholder="Telefoonnr" maxlength="15"><br>
        <input id="submit" type="submit" name="submit" value="Registreer">
    </form>
</div>


