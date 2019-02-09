<?php

$title = "Registreren";
include 'includes/header.php';
include 'includes/connect.php';

if (isset($_POST['submit'])){
    $name = sanitize($_POST['name'], $conn);
    $email = sanitize($_POST['email'], $conn);
    $phone = sanitize($_POST['phone'], $conn);
    $message = sanitize($_POST['message'], $conn);
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $date = date("Y-m-d, H:i:s");
            $msg = "Van: $name\nEmail: $email,\nTel:$phone,\n----------------------------------\n$message\n\nVerzonden op: $date";
            $from = "From: $name<$email>";
            $subject = "Contact-formulier De Concurrent";
            $to = "glenncopal@gmail.com";
            mail($to, $subject, $msg, $from);
        }
        else{
            echo '<div class="danger">U moet een geldig email adres invoeren</div>';
        }
    }
    else{
        echo '<div class="danger">U moet alle velden invullen</div>';
    }
}
?>
<div class="container">
<form id="form" action="" method="POST">
        <h1>Contactformulier</h1><br>
                <label for="naam">Naam:</label><br>
                <input class="input" id="naam" type="text" name="name" placeholder="Naam" pattern="[A-Za-z ]+"/><br>
                <label for="email">Email:</label><br>
                <input class="input" id="email" type="text" name="email" placeholder="Email"/><br>
                <label for="phone">Telefoon nummer:</label><br>
                <input class="input" id="phone" name="phone" placeholder="Telnr." pattern="[0-9]{10} [-]{n,}"/><br>
                <label for="message">Uw bericht:</label><br>
                <textarea class="input" id="message" name="message" placeholder="Uw Bericht"></textarea><br>
                <input id="submit" type="submit" name="submit" value="Verzenden"/>
</form>
</div>



